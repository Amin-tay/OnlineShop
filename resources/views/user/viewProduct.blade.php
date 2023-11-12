<x-user-layout>

    <div class="px-3 mb-5">

        <h1 class="text-center my-5 ">{{ $product->name }}</h1>
        <div class="mx-auto px-5 text-center">
            <img src="/storage/{{ $product->image }}" class="w-50 border rounded mx-auto">
        </div>
        <br>
        <div class="px-5 text-center">
            <hr>

            <h2 class="my-3">Category : <a href="/categories/{{ $product->category->id }}"
                    class="text-decoration-none text-info">
                    {{ $product->category->name }}</a></h2>
            <h2 class="my-3">Price : ${{ $product->price }}</h2>
            <h2 class="my-3">Available Quantity: {{ $product->quantity }}</h2>
            <div class="container mx-auto border border-info rounded my-3">
                <div class="row mx-auto">
                    <div class=" mx-auto">

                        <h2 class="w-75 mx-auto">
                            {{ $product->description }}
                        </h2>
                    </div>
                </div>
            </div>
            <div class="my-3">
                <p>Number: </p>
                @if ($quantity != 0)
                    <p class="text-center d-block">Already in Cart!</p>
                @endif
                <form action="/addToCart" method="post">

                    @csrf

                    <div class="form-group d-flex justify-content-center align-items-center">
                        {{-- <label for="quantity">Number</label> --}}

                        <input type="number" class="form-control w-25 mr-2" id="quantity" name="quantity"
                            placeholder="Number" step="1" min="1"
                            value={{ $quantity != 0 ? $quantity : 1 }}>

                        <input type="hidden" value="{{ $product->id }}" name="productId">
                        <button type="submit" class="btn btn-success ml-2">Add to Cart</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

</x-user-layout>
