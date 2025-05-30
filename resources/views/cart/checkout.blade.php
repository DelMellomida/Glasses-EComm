<x-app-layout>

        <div class="max-w-6xl mx-auto py-10 space-y-8">

        <div class="">
            
            <div class="bg-[#ffffff] p-8 rounded-xl shadow border-t-4 border-[#378805] shadow">
                <div class="text-4xl font-extrabold text-center text-[#000000] pb-12">Checkout</div>

                <!-- <div class="text-xl font-extrabold text-[#ffd166]">Shipping Details</div> -->
                    
                    <div class = "grid grid-cols-2 gap-6 pb-6 text-center divide-x divide-gray-200">
                        <div><span class="">Payment</span> 

                            <div class="sm:col-span-2 text-left">
                                <x-label for="paymethod" value="{{ __('Payment Method') }}" />
    
                                <select id="paymethod" class="mt-1 block w-full rounded-md" wire:model="state.paymethod" required autocomplete="paymethod">
                                    <option value="">Select Payment Method</option>
                                    <option value="male">GCash</option>
                                    <option value="female">BDO</option>
                                    <option value="other">BPI</option>
                                </select>
                        
                                <x-input-error for="paymethod" class="mt-2" />
                            </div>
            
                            <div class="col-span-6 sm:col-span-4 text-left">
                                <x-label for="cardnum" value="{{ __('Card Number') }}" />
                                <x-input id="cardnum" type="text" class="mt-1 block w-full" wire:model="state.cardnum" required autocomplete="cardnum"/>
                                <x-input-error for="cardnum" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-4 text-left">
                                <x-label for="name" value="{{ __('Name') }}" />
                                <x-input id="name" type="text" class="mt-1 block w-full" wire:model="state.name" required autocomplete="name"/>
                                <x-input-error for="name" class="mt-2" />
                            </div>
                        

                            <div class="col-span-6 sm:col-span-4 text-left">
                                <x-label for="address" value="{{ __('Billing Address') }}" />
                                <x-input id="address" type="text" class="mt-1 block w-full" wire:model="state.address" required autocomplete="address"/>
                                <x-input-error for="address" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-4 text-left">
                                <x-label for="zipcode" value="{{ __('Zip Code') }}" />
                                <x-input id="zipcode" type="text" class="mt-1 block w-full" wire:model="state.zipcode" required autocomplete="zipcode"/>
                                <x-input-error for="zipcode" class="mt-2" />
                            </div>

                        </div>

                        <div> Order Summary
                            <!-- insert cart items here -->
                        </div>
                    </div>

            </div>
        </div>

</x-app-layout>