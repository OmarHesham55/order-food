$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function (){
    $(".deleteBtn").on("click",function (){
        const dataId = $(this).data('id');
        const url = `${baseUrl}/dashboard/admin/restaurants/${dataId}`;
        Swal.fire({
            title: "Are you sure?",
            text: "Once deleted, You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Delete",
        }).then((result)=>{
            if(result.isConfirmed){
                $.ajax({
                    url:url,
                    type:"DELETE",
                    success: function (response){
                        if (response.status === 'success')
                        {
                            Swal.fire({
                                title: "Deleted!",
                                text: "Category has been deleted.",
                                icon: "success",
                                timer: 1500,
                            });
                        }else
                        {
                            Swal.fire({
                                title: "Failed!",
                                text: "Unable to delete!",
                                icon: "error",
                                timer: 1500,
                            });
                        }
                    },
                    error:function (xhr){
                        Swal.fire({
                            icon: "error",
                            title: "Failed!",
                            text: xhr.message || "Unable to delete Category!",
                        });
                    }
                });
            }
        });
    });

$(document).on("click",".editBtn",function (){
    const dataId = $(this).data('id');
    fetchRestaurants(dataId);
});



$(document).on("submit","#editRestaurantForm",function (e) {
    e.preventDefault();
    $("#editRestaurantForm").validate({
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
            const id = $("#restaurantId").val();
            const formAction = `${baseUrl}/dashboard/admin/restaurants/${id}`;
            $(form).attr("action",formAction);
            formData.append("_method",'PUT');
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
                    }
                    else
                    {
                        Swal.fire({
                            icon:"error",
                            title:"error",
                            text:"updating error",
                        });
                    }
                },
                error: function (xhr){
                    Swal.fire({
                        icon:"error",
                        title:"error",
                        text:"an error acquired while processing"
                    });
                    console.log(xhr.responseText);
                }
            });
        }
    });
});
});



function fetchRestaurants(id) {
    $.ajax({
        url:`${baseUrl}/dashboard/admin/restaurants/${id}`,
        type: 'GET',
        success: function (response){
            const restaurant = response.restaurant;
            if(response.status === "success")
            {
                $("#restaurantName").val(restaurant.name);
                $("#restaurantSlug").val(restaurant.slug);
                $("#restaurantAddress").val(restaurant.address);
                $("#restaurantPhone").val(restaurant.phone);
                $("#restaurantId").val(restaurant.id);
            }
            else
            {
                Swal.fire({
                    icon: "error",
                    title: "error",
                    text:"error"
                });
            }
        },
        error:function () {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Failed to fetch categories."
            });
        }
    })
}
