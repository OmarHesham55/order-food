$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function (){
$("#restaurantForm").validate({
    rules: {
        name: {
            required: true,
        },
        slug: {
            required: true,
        },
        categories_id: {
            required: true
        },
        address: {
            required: true,
        },
        phone: {
            required: true,
            digits: true
        },

    },
    messages: {
        name: {
            required:"this field is required",
        },
        slug: {
            required: "this field is required",
        },
        categories_id: {
            required: "this field is required"
        },
        address: {
            required: "this field is required",
        },
        phone: {
            required: "this field is required",
            digits: "digits only"
        },
    },
    submitHandler: function (form) {
        const formData = new FormData(form);
        const formAction = $(form).attr("action");
        $.ajax({
            url: formAction,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if(response.status === 'success')
                {
                    Swal.fire({
                        icon:"success",
                        title:"success",
                        text:response.message,
                    });
                    $("#restaurantForm")[0].reset();
                }
                else
                {
                    Swal.fire({
                        icon:"error",
                        title:"error",
                        text:"something went wrong",
                    });
                }
            },
            error: function (xhr){
                Swal.fire({
                    icon:"error",
                    title:"error",
                    text:xhr.responseText ?? "an error acquired while processing"
                });
                console.log(xhr.responseText);
            }
        });
    }
});
});
