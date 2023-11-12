<x-user-layout>
    <h1 class="text-center my-5">Orders</h1>

    <div class="text-center">
        <div class="final_status">

        </div>
        <div class="px-5 mx-5">
            <table class="table text-center align-middle">
                <thead>
                <tr>
                    <th scope="col">Order ID</th>
                    <th scope="col">Order Date</th>
                    <th scope="col">Payment</th>
                    <th scope="col">Final Price</th>
                    <th scope="col">Order Status</th>
                    <th scope="col">Details</th>

                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr class="my-5 bg-danger">

                        <th scope="row">{{    $order->id }}</th>
                        <td class="">{{$order->formated_date}}</td>


                        <td class="">{{ucfirst($order->payment_status)}}</td>
                        <td class="w-25">${{$order->final_price}} </td>
                        <td class=" ">
                            <div class="p-2 rounded  {{$order->order_color}}">
                                {{ucfirst($order->order_status)}}
                            </div>
                        </td>
                        <td class=""><a
                                class="btn btn-info"
                                href="viewOrders/{{$order->id}}">View Order</a></td>

                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>
</x-user-layout>
