<?php

namespace App\PaymentGateway;

use App\Contracts\PaymentGatewayInterface;
use App\Models\PaymentGateway;
use Stripe\StripeClient;

class Stripe implements PaymentGatewayInterface
{
    protected array $config;
    protected StripeClient $client;

    public function __construct(PaymentGateway $gateway)
    {
        $this->config = $gateway->config;
        $this->client = new StripeClient($this->config['secret_key']);
    }

    public function charge(float $amount, string $currency, array $meta = []): mixed
    {
        $paymentIntent = $this->client->paymentIntents->create([
            'amount' => (int) ($amount * 100), // amount in cents
            'currency' => $currency,
            'metadata' => $meta,
        ]);

        return [
            'status' => 'success',
            'transaction_id' => $paymentIntent->id,
            'client_secret' => $paymentIntent->client_secret,
            'amount' => $amount,
            'currency' => $currency,
            'meta' => $paymentIntent->toArray(),
        ];
    }

    public function refund(string $transactionId, float $amount = null): mixed
    {
        $refund = $this->client->refunds->create([
            'payment_intent' => $transactionId,
            'amount' => $amount ? (int) ($amount * 100) : null,
        ]);

        return [
            'status' => 'refunded',
            'transaction_id' => $refund->id,
        ];
    }

    public function getConfig(): array
    {
        return $this->config;
    }
}
