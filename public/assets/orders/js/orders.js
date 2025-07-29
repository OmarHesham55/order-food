$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function(){
    $('.status-radio').on('change', function() {
        let selectedRadio = $(this);
        let orderId = selectedRadio.data('order-id');
        let status = selectedRadio.val();
        $.ajax({
            url: `${baseUrl}/dashboard/admin/orders/update_order`,
            method: "POST",
            data: {
                status: status,
                orderId:orderId
            },
            success: function(response) {
                Swal.fire({
                    icon:"success",
                    text:'updated',
                    timer:1000
                });
            },
            error: function(xhr) {
                Swal.fire({
                    icon: "error",
                    text: "error",
                    timer: 1000
                });
            }
        });
    });
});
