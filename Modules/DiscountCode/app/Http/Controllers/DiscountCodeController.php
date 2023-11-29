<?php

namespace Modules\DiscountCode\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\DiscountCode\app\Models\DiscountCode;

class DiscountCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
//    public function testFunction(){
//        return back()->with('success', 'back!');
//    }
    public function index()
    {
//        $this->testFunction();
        $discountCodes = DiscountCode::all();

        foreach ($discountCodes as $discountCode) {
            if ($discountCode->discount_type == 'percent') {
                $discountCode->discount_amount = (string)$discountCode->discount_amount . '%';
                $discountCode->discount_type = "Percent";
            } else {
                $discountCode->discount_amount = (string)$discountCode->discount_amount . '$';
                $discountCode->discount_type = "Fixed Amount";
            }
        }
        return view('admin.discountCodes.index', compact('discountCodes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->hasPermissionTo('add discount code')) {
            return to_route('admin.discountCode.index')->with('danger', 'You are not allowed to add Discount Code!');
        }

        return view('admin.discountCodes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('add discount code')) {
            return to_route('admin.discountCode.index')->with('danger', 'You are not allowed to add Discount Code!');
        }

        $quantity = empty($request->quantity) ? '-1' : $request->quantity;
        DiscountCode::create([
            'code' => $request->code,
            'quantity' => $quantity,
            'discount_type' => $request->discount_type,
            'discount_amount' => $request->discount_amount,

        ]);
        return to_route('admin.discountCodes.index')->with('success', 'Discount Code Added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
