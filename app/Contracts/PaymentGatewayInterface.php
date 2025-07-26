<?php 


namespace App\Contracts;

interface PaymentGatewayInterface
{
    public function charge(float $amount, string $currency, array $meta = []): mixed;

    public function refund(string $transactionId, float $amount = null): mixed;

    public function getConfig(): array;
}