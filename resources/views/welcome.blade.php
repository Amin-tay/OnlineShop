<x-user-layout>
    <div class="">
        <h1 class="text-center my-5"></h1>
        <div class="mx-auto px-5 text-center">
            <img src="storage/Img/heroImage.jpg"
                 class="w-75 rounded  mx-auto">
        </div>
        <br>
        <hr>
        <h2 class="text-center mt-5"> Categories</h2>
        <div class="container my-5">
            <div class="row align-items-stretch">
                @foreach($categories as $category)
                    <div class="col-md-4 my-3 mx-auto">
                        <div class="rounded border border-primary h-100">
                            <a href="/categories/{{$category->id}}" class="text-decoration-none">
                                <img class="w-100 img-fluid object-fit-fill rounded h-75"
                                     src="/storage/{{$category->image}}" alt="Category Image">
                                <h3 class="text-center text-black my-1">{{$category->name}}</h3>
                            </a>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>

</x-user-layout>
