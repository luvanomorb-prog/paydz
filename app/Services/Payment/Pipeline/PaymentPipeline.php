<?php

namespace App\Services\Payment\Pipeline;

class PaymentPipeline
{
    protected array $stages = [];

    public function through(array $stages): static
    {
        $this->stages = $stages;

        return $this;
    }

    public function process(array $payload): array
    {
        foreach ($this->stages as $stage) {

            $instance = app($stage);

            $payload = $instance->handle($payload);

        }

        return $payload;
    }
}
