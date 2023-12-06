<x-admin-layout>
    <h1 class="text-center my-5">Category Index</h1>

    <div class="text-center">


        <div class=" px-5 mx-5">
            <table class="table text-center align-middle">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Image</th>
                    <th scope="col">Name</th>
                    <th scope="col">Products</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>

                @foreach($categories as $category)
                    <tr class="my-5">
                        <th scope="row">{{$category->id}}</th>

                        <td class="w-25"><a href="/categories/{{$category->id}}"><img
                                    src="{{$category->getFirstMediaUrl('categories')}}"
                                    class="w-100"
                                ></a></td>
                        <td class=""><a href="/categories/{{$category->id}}"
                                        class="text-decoration-none text-black">{{$category->name}}</a></td>
                        <td>{{count($category->products)}}</td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <form method="POST" action="/admin/categories/{{$category->id}}/restore">
                                    @csrf
                                    <button type="submit" class="btn btn-info">Restore</button>
                                </form>
                                <form method="POST" action="{{ route('admin.categories.destroy',$category->id) }}"
                                      onsubmit="return confirm('Are your sure?\nAll related products will be deleted!');">
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
