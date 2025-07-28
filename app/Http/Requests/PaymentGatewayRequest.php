<?php

namespace App\Http\Requests;

use App\Models\PaymentGateway;
use Illuminate\Foundation\Http\FormRequest;

class PaymentGatewayRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $paymentGateway = $this->route('payment_gateway') ?? $this->payment_gateway;
        $id = $paymentGateway instanceof PaymentGateway ? $paymentGateway->id : (is_string($paymentGateway) ? $paymentGateway : null);

        return [
            'name' => 'required|string',
            'slug' => 'required|string|unique:payment_gateways,slug,' . $id,
            'namespace' => 'required|string',
            'config' => 'nullable|array',
            'enabled' => 'boolean',
        ];
    }
}
