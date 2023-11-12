<x-admin-layout>
    <h1 class="text-center my-5">Discount Code Index</h1>

    <div class="text-center">
        <a class="btn btn-success text-center mx-auto mb-4" href="{{route('admin.discountCodes.create')}}">Add Discount Code</a>

        <div class=" px-5 mx-5">
            <table class="table text-center align-middle">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Code</th>
                    <th scope="col">Qunatity</th>
                    <th scope="col">Uses number</th>
                    <th scope="col">Discount Type</th>
                    <th scope="col">Amount</th>
                    
                </tr>
                </thead>
                <tbody>
                    @foreach ($discountCodes  as $discountCode )
                        <tr>
                            <td>{{$discountCode->id}}</td>
                            <td>{{$discountCode->code}}</td>
                            <td>{{$discountCode->quantity == -1 ? 'No Limit' : $discountCode->quantity}}</td>
                            <td>{{$discountCode->used_number}}</td>
                            <td>{{$discountCode->discount_type}}</td>
                            <td>{{$discountCode->discount_amount}}</td>
                            
                        </tr>
                    @endforeach
                {{-- @foreach($products as $product)
                    <tr>
                        <td>{{$product->id}}</td>
                        <td class=""><a href="/products/{{$product->id}}">
                                <img
                                    src="/storage/{{$product->image}}"
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
                @endforeach --}}

                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
