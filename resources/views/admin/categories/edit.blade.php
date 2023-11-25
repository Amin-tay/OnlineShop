<x-admin-layout>

    <h1 class="text-center mt-5">Edit Category</h1>
    <div class="px-5 mx-auto mt-5 w-50">
        <form
            action="{{route('admin.categories.update',$category->id)}}"
            enctype="multipart/form-data"
            method="post"
        >
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Category Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{$category->name}}">

            </div>
            <div class="">
                <img
                    src="{{$category->getFirstMediaUrl('categories')}}"
                    class="w-100"
                >
            </div>
            <div class="my-2">

                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" class="form-control-file" id="image" name="image">
                </div>
            </div>

            <div class="text-center mt-2">
                <button type="submit" class="btn btn-primary ">Update Category</button>
            </div>
        </form>
    </div>

</x-admin-layout>
