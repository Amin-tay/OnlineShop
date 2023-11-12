
$(document).ready(function () {
    $('.order_status').change(function () {
        var selectedOption = $(this).find('option:selected');
        var csrf_token = $('meta[name="_token"]').attr('content');

        var data = {
            '_token': csrf_token,
            order_id: $(this).data('order-id'),
            status: selectedOption.val(),
            status_label: selectedOption.text()
        };

        // Handle the response from the controller
        $.post('/admin/change-order-status', data, function (response) {
            selectedOption.parent().removeClass().addClass(response.css_class);
        }, 'json');
    });
})

function toggleDiscountQuantity() {
    var input = document.getElementById('quantity');

    if (input.disabled) {
        input.value = '';
        input.placeholder = "10, 1000, etc..."
    }
    else {
        input.value = '';
        input.placeholder = 'No Limit'
    }
    input.disabled = !input.disabled;
}
function toggleDiscountType() {
// alert('hi')
var select = document.getElementById('type');
var label = document.getElementById('label-amount');
var input = document.getElementById('amount');
console.log(select.value);


if (select.value == 'fixed'){
 label.textContent = 'Discount Amount';
 input.placeholder = '200$'

}
else {
    label.textContent = 'Discount Percent';
    input.placeholder = '15%';
}



}