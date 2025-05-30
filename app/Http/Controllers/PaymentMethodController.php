<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\PaymentMethod;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('cart.checkout');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.payment_method.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
            return redirect()->route('payment_methods.create')->with('error', 'Failed to create payment method.');
        }

        Log::info('Successfully created payment method', ['payment_method_id' => $paymentMethod->id]);
        return redirect()->route('payment_methods.create')->with('success', 'Payment method created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);
        if (!$paymentMethod) {
            return redirect()->route('payment_methods.index')->with('error', 'Payment method not found.');
        }
        return view('admin.payment_method.show', compact('paymentMethod'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);
        return view('admin.payment_method.edit', compact('paymentMethod'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'pay_method' => 'required|in:cash,credit_card,debit_card,gcash',
            'available' => 'required|in:yes,no',
        ]);

        try {
            $paymentMethod = PaymentMethod::findOrFail($id);
            $paymentMethod->update($request->all());
        } catch (\Exception $e) {
            Log::error('Error updating payment method:', ['error' => $e->getMessage()]);
            return redirect()->route('payment_methods.edit', $id)->with('error', 'Failed to update payment method.');
        }

        Log::info('Successfully updated payment method', ['payment_method_id' => $paymentMethod->id]);
        return redirect()->route('payment_methods.edit', $id)->with('success', 'Payment method updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $paymentMethod = PaymentMethod::findOrFail($id);
            $paymentMethod->delete();
        } catch (\Exception $e) {
            Log::error('Error deleting payment method:', ['error' => $e->getMessage()]);
            return redirect()->route('payment_methods.index')->with('error', 'Failed to delete payment method.');
        }

        Log::info('Successfully deleted payment method', ['payment_method_id' => $id]);
        return redirect()->route('payment_methods.index')->with('success', 'Payment method deleted successfully.');
    }
}
