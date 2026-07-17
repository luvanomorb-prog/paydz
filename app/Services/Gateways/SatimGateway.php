<?php

namespace App\Services\Gateways;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SatimGateway implements PaymentGatewayInterface
{
    protected string $baseUrl;
    protected string $merchantId;
    protected string $password;

    public function __construct()
    {
        $this->baseUrl    = config('services.satim.base_url');
        $this->merchantId = config('services.satim.merchant_id');
        $this->password   = config('services.satim.password');
    }

    public function charge(array $data): array
    {
        try {
            $response = Http::asForm()->post("{$this->baseUrl}/register.do", [
                'userName'    => $this->merchantId,
                'password'    => $this->password,
                'orderNumber' => $data['reference'],
                'amount'      => (int) round($data['amount'] * 100),
                'currency'    => $this->currencyCode($data['currency']),
                'returnUrl'   => $data['return_url'] ?? config('app.url') . '/payment/callback',
                'description' => $data['description'] ?? null,
            ]);

            $body = $response->json();

            if (! $response->successful() || (isset($body['errorCode']) && $body['errorCode'] !== '0')) {
                Log::warning('SATIM charge failed', ['response' => $body]);

                return [
                    'success' => false,
                    'status' => 'failed',
                    'gateway_reference' => $body['orderId'] ?? null,
                    'redirect_url' => null,
                    'raw_response' => $body,
                    'error_message' => $body['errorMessage'] ?? 'فشل التسجيل عند SATIM.',
                ];
            }

            return [
                'success' => true,
                'status' => 'requires_action',
                'gateway_reference' => $body['orderId'],
                'redirect_url' => $body['formUrl'] ?? null,
                'raw_response' => $body,
                'error_message' => null,
            ];
        } catch (\Throwable $e) {
            Log::error('SATIM charge exception', ['message' => $e->getMessage()]);

            return [
                'success' => false,
                'status' => 'failed',
                'gateway_reference' => null,
                'redirect_url' => null,
                'raw_response' => null,
                'error_message' => 'خطأ تقني أثناء الاتصال ببوابة SATIM.',
            ];
        }
    }

    public function verify(string $gatewayReference): array
    {
        try {
            $response = Http::asForm()->post("{$this->baseUrl}/getOrderStatusExtended.do", [
                'userName' => $this->merchantId,
                'password' => $this->password,
                'orderId'  => $gatewayReference,
            ]);

            $body = $response->json();
            $success = ($body['orderStatus'] ?? null) === 2;

            return [
                'success' => $success,
                'status' => $success ? 'succeeded' : 'failed',
                'gateway_reference' => $gatewayReference,
                'raw_response' => $body,
                'error_message' => $success ? null : ($body['errorMessage'] ?? 'لم يتم تأكيد الدفع.'),
            ];
        } catch (\Throwable $e) {
            Log::error('SATIM verify exception', ['message' => $e->getMessage()]);

            return [
                'success' => false,
                'status' => 'failed',
                'gateway_reference' => $gatewayReference,
                'raw_response' => null,
                'error_message' => 'خطأ تقني أثناء التحقق من الدفع.',
            ];
        }
    }

    public function refund(string $gatewayReference, ?float $amount = null): array
    {
        return [
            'success' => false,
            'status' => 'failed',
            'gateway_reference' => $gatewayReference,
            'raw_response' => null,
            'error_message' => 'استرجاع الأموال عبر SATIM غير مفعّل بعد — يحتاج تفعيل من طرفهم.',
        ];
    }

    public function getName(): string
    {
        return 'satim';
    }

    protected function currencyCode(string $currency): string
    {
        return match (strtoupper($currency)) {
            'DZD' => '012',
            default => '012',
        };
    }
}
