<x-user-layout>
    <div class="px-3 mb-5">
        <h1 class="text-center my-5 ">View Order Details {{$order->id}}</h1>
        <br>
        @foreach($products as $product)
            <div class="px-4 my-5 border border-warning d-flex justify-content-between rounded">
                <a class="w-25"
                   href="/products/{{$product->id}}">
                    <img src="{{$product->getFirstMediaUrl('products')}}"
                         class="w-100">
                </a>
                <div>
                    <h2><a href="/products/{{$product->id}}"
                           class="text-decoration-none text-black">{{$product->name}}</a></h2>
                    <h2>Price: ${{$product->price * $product->quantity}}(${{$product->price}})</h2>
                    <h2>Quantity: {{$product->quantity}}</h2>
                </div>
            </div>
        @endforeach
        <h2 class="text-center mb-5"> Total Cost: ${{$order->final_price}}</h2>
    </div>
</x-user-layout>
