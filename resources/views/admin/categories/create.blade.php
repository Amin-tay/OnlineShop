<x-admin-layout>


    <div class="container-fluid">

        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.categories.index')}}">Categories</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Pricing</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                       aria-expanded="false">
                        Dropdown link
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li>
                <li>
                    <div class="container-fluid">
                        <form class="d-flex" role="search">
                            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                            <button class="btn btn-outline-success" type="submit">Search</button>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <h1 class="text-center mt-5">Create a Category</h1>

    <div class="px-5 mx-auto mt-5 w-50">
        <form
            action="{{route('admin.categories.store')}}"
            enctype="multipart/form-data"
            method="post"
        >
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label d-block">Category Name</label>
                <input type="text" class="form-control" id="name" name="name">

            </div>

            <div class="form-group my-5">
                <label for="image">Image</label>
                <input type="file" class="form-control-file" id="image" name="image">
            </div>


            <div class="text-center">
                <button type="submit" class="btn btn-primary ">Add Category</button>
            </div>
        </form>
    </div>

</x-admin-layout>
