<x-admin-layout>
    <h1 class="text-center my-5">Archived Products</h1>

    <div class="text-center">
        <div class=" px-1 mx-5">
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
                    <td>
                    <td>{{$product->id}}</td>
                    <td class=""><a href="/products/{{$product->id}}">
                            <img
                                src="{{$product->getFirstMediaUrl('products')}}"
                                class="w-50"
                                alt="Product Image">
                        </a>
                    </td>
                    <td>{{$product->name}}</td>
                    <td>${{$product->price}}</td>
                    <td>{{$product->quantity}}</td>

                    @if(!empty($product->category))
                        <td>
                            <a href="/categories/{{$product->category->id}}"
                               class="text-decoration-none text-black">{{$product->category->name}}
                            </a>
                        </td>
                    @else
                        <td>
                            <p
                                class="text-decoration-none text-black">null
                            </p>
                        </td>
                    @endif
                    <div class="d-flex justify-content-center">
                        <form method="POST" action="/admin/products/{{$product->id}}/restore">
                            @csrf
                            <button type="submit" class="btn btn-info">Restore</button>
                        </form>
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
