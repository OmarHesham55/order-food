$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {
    fetchCategories();
    $('#categoryForm').validate({
        rules: {
            name: {
                required: true,
                minlength: 3,
                maxlength: 255
            },
            slug: {
                required: true,
                minlength: 3,
                maxlength: 255
            }
        },
        messages: {
            name: {
                required: "name field is required",
                minlength: "min words is 3",
                maxlength: "max words is 255",
            },
            slug: {
                required: "slug field is required",
                minlength: "min words is 3",
                maxlength: "max words is 255",
            }
        },
        submitHandler: function (form) {
            const dataForm = $(form).serializeArray();
            const formAction = $(form).attr("action");
            $.ajax({
                url: formAction,
                type: 'POST',
                data: dataForm,
                success: function (response) {
                    if (response.status === 'success')
                    {
                        Swal.fire({
                            icon:"success",
                            title:response.status,
                            text:response.message,
                        });
                        $('#categoryForm')[0].reset();
                        fetchCategories();
                    }else
                    {
                        Swal.fire({
                            icon:"error",
                            title:response.status,
                            text:response.message,
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        icon:"error",
                        title:"Error",
                        text:"An Error acquired while processing",
                    });
                }
            });
        }
    })

    $(document).on('click', '.deleteBtn', function() {
        const id = $(this).data('id');
        const url = `${baseUrl}/admin/categories/${id}`;
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
                            fetchCategories();
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
                    error:function (){
                        Swal.fire({
                            title: "Failed!",
                            text: "Unable to delete Category!",
                            icon: "error",
                        });
                    }
                });
            }
        });
    });

    $(document).on("click",".allCategoriesBtn",function (){
        fetchCategories();
        $(".allCategories").toggleClass("d-none");

        if ($(".allCategories").hasClass("d-none")) {

            $(".allCategoriesBtn").text("Show Categories");
        } else {

            $(".allCategoriesBtn").text("Hide Categories");
        }
    });

});

function fetchCategories() {

    $.ajax({
        url: baseUrl + '/dashboard/admin/categories',
        type: 'GET',
        success: function (response){
            const categories = response.categories;
            $("tbody").empty();
            categories.forEach(function (category){
            const categoryRow = `
            <tr>
                <td>${category.name}</td>
                <td>${category.slug}</td>
                <td>
                    <a class="btn btn-sm btn-outline-primary editBtn" data-id = "${category.id}">Edit</a>
                    <a class="btn btn-sm btn-outline-danger deleteBtn" data-id= "${category.id}">Delete</a>
                </td>
            </tr>`;
            $("tbody").append(categoryRow);
            });
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
