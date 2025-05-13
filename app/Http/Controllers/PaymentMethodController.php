<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\PaymentMethod;

class PaymentMethodController extends Controller
{
    public function index(){

    }

    public function create(){

    }
    
    public function store(Request $request){
        $request->validate([
            'pay_method' => 'required|in:cash,credit_card,debit_card,gcash',
            'available' => 'required|in:yes,no',
        ]);

        try {
            $paymentMethod = PaymentMethod::create([
                'pay_method' => $request->pay_method,
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating payment method:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to create payment method'], 500);
        }
    }

    public function show($id){
        $paymentMethod = PaymentMethod::findOrFail($id);
        if (!$paymentMethod) {
            return response()->json(['error' => 'Payment method not found'], 404);
        }
        return response()->json($paymentMethod);
    }

    public function edit($id){
        // Code to show form for editing a payment method
    }

    public function update(Request $request, $id){
        $request->validate([
            'pay_method' => 'required|in:cash,credit_card,debit_card,gcash',
            'available' => 'required|in:yes,no',
        ]);

        try {
            $paymentMethod = PaymentMethod::findOrFail($id);
            $paymentMethod->update($request->all());
        } catch (\Exception $e) {
            Log::error('Error updating payment method:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to update payment method'], 500);
        }

        return response()->json(['message' => 'Payment Method updated successfully', 'payment_method' => $paymentMethod], 200);
    }
    public function destroy($id){
        try {
            $paymentMethod = PaymentMethod::findOrFail($id);
            $paymentMethod->delete();
        } catch (\Exception $e) {
            Log::error('Error deleting payment method:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to delete payment method'], 500);
        }
    }
}
