<x-admin-layout>

    <h1 class="text-center mt-5">Update Product</h1>

    <div class="px-5 mx-auto mt-5 w-50">
        <form
            action="{{route('admin.products.update', $product->id)}}"
            enctype="multipart/form-data"
            method="post"
        >
            @csrf
            @method('PUT')
            <div class="my-3">
                <label for="name" class="form-label d-block">Product Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{$product->name}}">

            </div>

            <div class="form-group my-4">
                <label for="category">Category</label>
                <select class="form-control" id="category" name="category">
                    @foreach($categories as $category)
                        <option
                            @selected($category->id == $product->category_id) value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach

                </select>
            </div>

            <div class="my-2">
                <label for="price" class="form-label d-block">Price</label>
                <input type="number" class="form-control" id="price" name="price" min="0.01" step="0.01"
                       value="{{$product->price}}">

            </div>
            <div class="">
                <img
                    src="{{$product->getFirstMediaUrl('products')}}"
                    class="w-100"
                    alt="Product Image">
            </div>
            <div class="form-group my-5">
                <label for="image">Image</label>
                <input type="file" class="form-control-file" id="image" name="image">
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" rows="7"
                          name="description">{{$product->description}}</textarea>
            </div>

            <div class="text-center mt-5">
                <button type="submit" class="btn btn-primary ">Update Product</button>
            </div>
        </form>
    </div>

</x-admin-layout>
