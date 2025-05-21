<!-- guest-home is user-home narin dko na muna pinalitan yung name para hindi na magulo yung controllers -ocariza -->
<div class="flex flex-col min-h-screen md:pt-16 bg-white">
    @if (auth()->user())
        <x-nav-user></x-nav-user>
    @else
    <x-nav-guest></x-nav-guest>
    @endif
        <!-- more or less responsive na sya, although hindi kinaya hanggang mobile devices -ocariza -->
        <x-guest-layout>
            <x-hero-section></x-hero-section>

            <!-- balak ko sana yung left and right shit parang mirrored
            tas scroll yung mga products pa design nalang hahaah -ocariza -->
            <x-featured-products></x-featured-products>
        <x-product-container-right>
            <x-product-card :products="$products" :productImages="$productImages" /> <!-- aayusin pa db for new arrival -->
        </x-product-container-right>
        <x-product-container-left>
            <x-product-card :products="$products" :productImages="$productImages" />
        </x-product-container-left>
        </x-guest-layout>
    <x-personalized-eyecare></x-personalized-eyecare>

    <x-footer></x-footer>
</div>
