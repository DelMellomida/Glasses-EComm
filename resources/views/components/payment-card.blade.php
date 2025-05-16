<!-- Centering Wrapper -->
<div class="w-full min-h-screen flex items-center justify-center pt-24">
    <!-- Payment Card -->
    <div class="max-w-md w-full bg-white shadow-md rounded-lg p-6 z-50">
        <h2 class="text-lg font-semibold mb-4">Choose Payment Method</h2>

        <form method="POST" action="{{ route('admin.list-users') }}">
            @csrf

            <label class="block mb-2">
                <input type="radio" name="payment_method" value="credit_card" required>
                Credit Card
            </label>

            <div class="mt-2" id="credit-card-fields" style="display: none;">
                <input type="text" name="card_number" class="w-full border p-2" placeholder="Card Number">
                <input type="text" name="card_holder" class="w-full border p-2 mt-2" placeholder="Card Holder Name">
                <input type="text" name="expiry_date" class="w-full border p-2 mt-2" placeholder="MM/YY">
                <input type="text" name="cvv" class="w-full border p-2 mt-2" placeholder="CVV">
            </div>

            <label class="block mt-4">
                <input type="radio" name="payment_method" value="paypal">
                PayPal
            </label>

            <div class="mt-2" id="paypal-fields" style="display: none;">
                <input type="email" name="paypal_email" class="w-full border p-2" placeholder="PayPal Email">
            </div>

            <label class="block mt-4">
                <input type="radio" name="payment_method" value="bank_transfer">
                Bank Transfer
            </label>

            <div class="mt-2" id="bank-fields" style="display: none;">
                <input type="text" name="bank_name" class="w-full border p-2" placeholder="Bank Name">
                <input type="text" name="account_number" class="w-full border p-2 mt-2" placeholder="Account Number">
            </div>

            <button type="submit" class="mt-4 bg-blue-500 text-white py-2 px-4 rounded">Submit Payment</button>
        </form>
    </div>
</div>

<script>
    document.querySelectorAll('input[name="payment_method"]').forEach(input => {
        input.addEventListener('change', function() {
            document.getElementById('credit-card-fields').style.display = this.value === 'credit_card' ? 'block' : 'none';
            document.getElementById('paypal-fields').style.display = this.value === 'paypal' ? 'block' : 'none';
            document.getElementById('bank-fields').style.display = this.value === 'bank_transfer' ? 'block' : 'none';
        });
    });
</script>
