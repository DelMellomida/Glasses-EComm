<!-- guest-home is user-home narin dko na muna pinalitan yung name para hindi na magulo yung controllers -ocariza -->
<div class="flex flex-col min-h-screen md:pt-16 bg-white">
    @if (auth()->user())
        <x-nav-user></x-nav-user>
    @else
        <x-nav-guest></x-nav-guest>
    @endif

    <!-- more or less responsive na sya, although hindi kinaya hanggang mobile devices -ocariza -->
    <x-guest-layout>
        <x-product-header></x-product-header>

        <x-product-outwrapper-left>
            <x-product-card :products="$products" :productImages="$productImages" />
        </x-product-outwrapper-left>

        <x-product-outwrapper-right>
            <x-product-card :products="$products" :productImages="$productImages" />
        </x-product-outwrapper-right>

        <x-product-card :products="$products" :productImages="$productImages" />

    </x-guest-layout>

    <x-footer></x-footer>
</div>
