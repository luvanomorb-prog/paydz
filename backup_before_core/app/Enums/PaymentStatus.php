<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case Pending = 'pending';
    case Paid = 'paid';
    case Failed = 'failed';
    case Cancelled = 'cancelled';
    case Expired = 'expired';

    /**
     * هل يمكن الانتقال إلى الحالة الجديدة؟
     */
    public function canTransitionTo(self $newStatus): bool
    {
        return match ($this) {
            self::Pending => in_array($newStatus, [
                self::Paid,
                self::Failed,
                self::Cancelled,
                self::Expired,
            ], true),

            self::Paid => false,
            self::Failed => false,
            self::Cancelled => false,
            self::Expired => false,
        };
    }

    /**
     * هل تعتبر العملية منتهية؟
     */
    public function isFinal(): bool
    {
        return match ($this) {
            self::Pending => false,
            default => true,
        };
    }

    /**
     * هل تعتبر العملية ناجحة؟
     */
    public function isSuccessful(): bool
    {
        return $this === self::Paid;
    }
}
