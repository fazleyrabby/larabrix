<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\PaymentGateway;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentGatewayRequest;
use App\Services\PaymentGatewayService;

class PaymentGatewayController extends Controller
{
    protected PaymentGatewayService $service;
    public function __construct(){
         $this->service = new PaymentGatewayService;
    }
    public function index(Request $request)
    {
        $paymentGateways = $this->service->getPaginatedItems($request->all());
        return view('admin.payment_gateways.index', compact('paymentGateways'));
    }

    public function create()
    {
        return view('admin.payment_gateways.create');
    }

    public function store(PaymentGatewayRequest $request)
    {
        PaymentGateway::create($request->validated());
        return redirect()->route('admin.payment-gateways.index')->with('success', 'Payment gateway added.');
    }

    public function edit(PaymentGateway $paymentGateway)
    {
        return view('admin.payment_gateways.edit', compact('paymentGateway'));
    }

    public function update(PaymentGatewayRequest $request, PaymentGateway $paymentGateway)
    {
        $paymentGateway->update($request->validated());
        return redirect()->route('admin.payment-gateways.index')->with('success', 'Payment gateway updated.');
    }

    public function destroy(PaymentGateway $paymentGateway)
    {
        $paymentGateway->delete();
        return redirect()->back()->with('success', 'Payment gateway deleted.');
    }
}
