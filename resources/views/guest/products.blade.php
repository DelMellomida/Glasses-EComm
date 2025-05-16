<div class="container mx-auto mt-6">
        <table id="user_detail" class="user_tabletable table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ $product->product_description ?? 'N/A' }}</td>
                        <td>{{ $product->price ?? 'N/A' }}</td>
                    </tr>

                    @forelse ($productImages as $productImage)
                        @if ($product->product_image_id == $productImage->product_id)
                            <tr>
                                <td colspan="2">
                                    <img src="{{  $productImage->image_path }}" alt="Product Image" class="img-fluid" style="width: 100px; height: 100px;">
                                </td>
                                <td></td>
                            </tr>
                        @endif
                    @empty
                        <td colspan="5" class="text-center">No product image found.</td>
                    @endforelse
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No products found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if(auth()->user())
            <div class="mt-4">
                cart
            </div>
        @endif
    </div>