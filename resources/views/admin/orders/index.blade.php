<x-admin-layout>
    <h1 class="text-center my-5">Orders</h1>

    <div class="text-center">
        <div class="final_status">

        </div>
        <div class=" px-5 mx-5">
            <table class="table text-center align-middle">
                <thead>
                <tr>
                    <th scope="col">Order ID</th>
                    <th scope="col">Customer Name</th>
                    <th scope="col">Customer Gmail</th>
                    <th scope="col">Order Date</th>

                    <th scope="col">Final Price</th>
                    <th scope="col">Order Status</th>
                    <th scope="col">Order Products</th>
                </tr>
                </thead>
                <tbody>

                @foreach($orders as $order)
                    <tr class="my-5">
                        <th scope="row">{{$order->id}}</th>

                        <td class="">{{$order->user->name}}</td>
                        <td class="">{{$order->user->email}}</td>
                        <td class="">{{$order->formated_date}} </td>
                        <td class="">${{$order->final_price}} </td>
                        <td>

                            <select class="form-select {{$order->color}} order_status"
                                    data-order-id="{{$order->id}}"
                            >

                                <option class="bg-warning"
                                        value="pending" @selected($order->order_status == 'pending')>
                                    Pending
                                </option>
                                <option class="bg-primary"
                                        value="shipped" @selected($order->order_status == 'shipped')>
                                    Shipped
                                </option>
                                <option class="bg-success"
                                        value="received" @selected($order->order_status == 'received')>
                                    Received
                                </option>
                                <option class="bg-danger"
                                        value="canceled" @selected($order->order_status == 'canceled')>
                                    Canceled
                                </option>
                            </select>
                        </td>
                        <td class=""><a class="btn btn-info" href="/admin/showOrder/{{$order->id}}"> View Details</a>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
