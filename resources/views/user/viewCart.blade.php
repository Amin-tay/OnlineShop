<x-user-layout>

    <div class="px-3 mb-5">



        <br>
        @if (!empty(session('cart')))
            <h1 class="text-center my-5 ">My Cart</h1>

            @foreach ($products as $product)
                <div class="px-4 my-5 border border-warning d-flex justify-content-between rounded">

                    <a class="w-25" href="/products/{{ $product->id }}">
                        <img src="{{$product->getFirstMediaUrl('products')}}" class="w-100">
                    </a>
                    <div>
                        <h2><a href="/products/{{ $product->id }}"
                                class="text-decoration-none text-black">{{ $product->name }}</a></h2>
                        <h2>Price: ${{ $product->price * $product->quantity }}(${{ $product->price }})</h2>
                        <h2>Quantity: {{ $product->quantity }}</h2>

                    </div>

                </div>
            @endforeach

            <h2 class="text-center"> Total Cost: ${{ $totalCost }}</h2>
            <div class="d-flex justify-content-center my-5">


                @if (empty(session('discount_code')))
                    <form action="/addDiscountCode" method="post" class="">
                        @csrf
                        <label for="code" class="form-label d-block">Add Discount Code</label>
                        <div class="d-flex">
                            <input type="text" class="form-control" style="width: auto;" name='code'>
                            <button class="btn btn-info">Submit</button>
                        </div>
                    </form>
                @else
                    <form action="/removeDiscountCode" method="post" class="">
                        @csrf
                        <label for="code" class="form-label d-block">{{ session('explainCode') }}</label>
                        <div class="d-flex">
                            <input type="text" class="form-control mr-2" style="width: auto;"
                            value={{ session('discount_code')->code }} name='code' disabled>
                        <button class="btn btn-warning">Remove</button>
                        </div>
                    </form>
                @endif
            </div>
            <h2 class="text-center "> Final Price: ${{ session('final_price') ?? $totalCost }}</h2>

            <div class="text-center ">
                <form action="/order" method="post">
                    @csrf
                    <input type="hidden" name="payment_status" value="cash">
                    <button type="submit" class="btn btn-success text-center w-25 mx-auto">Finalize Order</button>

                </form>

            </div>
        @else
            <h1 class="text-center">The Cart is Empty!</h1>
        @endif
    </div>

</x-user-layout>
