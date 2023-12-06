<x-admin-layout>
    <h1 class="text-center my-5">Products Index</h1>

    <div class="text-center">
        <div class="">
            <a class="btn btn-success text-center  mb-4" href="{{route('admin.products.create')}}">Add
                Product</a>
            <a class="btn btn-info text-center  mb-4" href="{{route('admin.products.archive')}}">Archive</a>
        </div>

        <div class=" px-5 mx-5">
            <table class="table text-center align-middle">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Image</th>
                    <th scope="col">Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Category</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>

                @foreach($products as $product)
                    <tr>
                        <td>{{$product->id}}</td>
                        <td class=""><a href="/products/{{$product->id}}">
                                <img
                                    src="{{$product->getFirstMediaUrl('products')}}"
                                    class="w-50"
                                    alt="Product Image">
                            </a></td>
                        <td>{{$product->name}}</td>
                        <td>${{$product->price}}</td>
                        <td>{{$product->quantity}}</td>

                        <td><a href="/categories/{{$product->category->id}}"
                               class="text-decoration-none text-black">{{$product->category->name}}</a></td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('admin.products.edit',$product->id) }}"
                                   class="btn btn-primary me-2">Edit</a>
                                <form method="POST" action="{{ route('admin.products.destroy',$product->id) }}"
                                      onsubmit="return confirm('Are your sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
