<x-admin-layout>

    <h1 class="text-center mt-5">Create a Discount Code</h1>

    <div class="px-5 mx-auto mt-5 w-50">
        <form action="{{ route('admin.discountCodes.store') }}" enctype="multipart/form-data" method="post">
            @csrf
            <div class="my-3">
                <label for="code" class="form-label d-block">Discount Code Text (must be Unique)</label>
                <input type="text" class="form-control" id="code" name="code"
                placeholder="e.g. new_year_2024"
                >

            </div>

            <div class="my-3">
                <label for="quantity" class="form-label d-block">Discount Code Quantity</label>
                <input type="number" class="form-control " id="quantity" name="quantity" step="1" min="1"
                
                placeholder="10, 1000, etc..."
                >
                <div class="form-check mt-2">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" onclick="toggleDiscountQuantity()">
                    
                    <label class="form-check-label" for="flexCheckDefault">
                      Inifinity
                    </label>
                  </div>
            </div>

            <div class="form-group my-4">
                <label for="type">Discount type</label>
                <select class="form-control" id="type" name="discount_type"
                onchange="toggleDiscountType()"
                >
                    <option value="fixed">Fixed Amount</option>
                    <option value="percent">Percent</option>
                </select>
                
            </div>
            <div class="my-2">
                <label for="amount" class="form-label d-block" id='label-amount'>Discount Amount</label>
                <input type="number" class="form-control" id="amount" name="discount_amount" step="1"
                placeholder="200$"
                >
            </div>

            <div class="text-center mt-5">
                <button type="submit" class="btn btn-primary ">Add Code</button>
            </div>
        </form>
    </div>

</x-admin-layout>
