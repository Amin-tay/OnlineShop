<x-user-layout>

    <div class="">

        <h1 class="text-center my-5">{{ $category->name }}</h1>
        <div class="mx-auto px-5 text-center">
            <img src="{{$category->getFirstMediaUrl('categories')}}" class="w-75 border rounded mx-auto">
        </div>
        <br>
        <hr>
        @if (!empty($products))
            <h2 class="text-center mt-5"> Product in this Category</h2>
            <div class="container my-5">
                <div class="row align-items-stretch">
                    @foreach ($products as $product)
                        <div class="col-md-5 my-3 mx-auto">
                            <div class="rounded border border-primary h-100 pb-2">
                                <a href="/products/{{ $product->id }}" class="text-decoration-none">
                                    <img class="w-100 img-fluid object-contain rounded h-75"
                                        src="{{$product->getFirstMediaUrl('products')}}" alt="Product Image">
                                    <h3 class="text-center text-black ">{{ $product->name }}</h3>
                                    <h4 class="text-center text-black ">${{ $product->price }}</h4>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <h2 class="text-center mt-5"> No Product in this Category!</h2>
        @endif
    </div>

</x-user-layout>
