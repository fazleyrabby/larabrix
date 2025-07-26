<?php


namespace App\PaymentGateway;

use App\Contracts\PaymentGatewayInterface;
use App\Models\PaymentGateway;

class Stripe implements PaymentGatewayInterface
{
    protected array $config;

    public function __construct(PaymentGateway $gateway)
    {
        $this->config = $gateway->config;
    }

    public function charge(float $amount, string $currency, array $meta = []): mixed
    {
        // Stripe API charge logic here...
        return [
            'status' => 'success',
            'transaction_id' => 'txn_123456',
        ];
    }

    public function refund(string $transactionId, float $amount = null): mixed
    {
        // Refund via Stripe API
        return [
            'status' => 'refunded',
            'transaction_id' => $transactionId,
        ];
    }

    public function getConfig(): array
    {
        return $this->config;
    }
}
