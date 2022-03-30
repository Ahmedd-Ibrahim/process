<?php
namespace App\Http\Controllers\Api\V1\Admin;

use App\Models\Payment;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Http\Resources\PaymentResource;

class PaymentController extends Controller
{
    public function index()
    {
        return response()->json(PaymentResource::collection(Payment::paginate())->resource);
    }

    public function store(PaymentRequest $request)
    {
        Payment::create($request->validated());

        return response()->json(['message' => 'Payment created successfully']);
    }

    public function update(Payment $payment, PaymentRequest $paymentRequest)
    {
        $payment->update($paymentRequest->validated());
        return response()->json(['message' => 'Payment updated successfully']);
    }

    public function show(Payment $payment)
    {
        return response()->json(new PaymentResource($payment));
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return response()->json(['message' => 'Payment Deleted successfully']);
    }
}
