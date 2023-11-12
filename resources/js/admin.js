// alert('hi')

// $(document).ready(function () {
//     let selects = $('.order_status');
//     selects.forEach(function (select) {
//         // alert(select);
//         select.on('change', function () {
//             alert('hi');
//         })
//     })
// })


    // $(document).ready(function () {
    //     $('.order_status').change(function () {
    //         var selectedOption = $(this).find('option:selected');

    //         var data = {
    //             _token: '{{ csrf_token() }}', // Add the CSRF token
    //             order_id: $(this).data('order-id'), // Assuming you have an order ID associated with each select element
    //             status: selectedOption.val(),
    //             status_label: selectedOption.text()
    //         };

    //         $.post('/admin/change-order-status', data, function (response) {
    //             // Handle the response from the controller
    //             selectedOption.parent().removeClass().addClass(response.css_class);

    //         }, 'json');
    //     });
    // });
 