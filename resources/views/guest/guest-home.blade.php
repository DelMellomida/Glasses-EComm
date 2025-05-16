<div class="flex flex-col min-h-screen md:pt-16">
    @if (auth()->user())
        <x-nav-user></x-nav-user>
    @else
    <x-nav-guest></x-nav-guest>
    @endif
    <div class="flex-grow">
        <x-guest-layout>
            <div class="h-100 flex flex-row w-full bg-green-100">
                <x-product-card :products="$products" :productImages="$productImages" />
            </div>
        </x-guest-layout>
    </div>

    <x-footer></x-footer>
</div>
