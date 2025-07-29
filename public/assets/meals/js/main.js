$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function (){

    $("#meal-form").validate({
        rules: {
            name: {
                required: true,
            },
            price: {
                required: true,
                number: true
            },
            image: {
                required: true,
                imageType: true,
                imageSize: 2097152
            },
            restaurant_id:{
                required:true
            }
        },
        messages:{
            name: {
                required:"name field is required"
            },
            price: {
                required:"name is field is required",
                number: "Number only is required"
            },
            image: {
                required:"image is required"
            },
            restaurant_id: {
                required: "required"
            }
        },
        submitHandler: function (form,e){
            e.preventDefault();
            const formData = new FormData(form);
            const formAction = $(form).attr('action');
                $.ajax({
                    url:formAction,
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData:false,
                    success: function (response){
                        if(response.status === 'success')
                        {
                        Swal.fire({
                            icon: 'success',
                            title:'success',
                            text: response.message
                        });
                        $('#meal-form')[0].reset();
                        // $('#meals-table').DataTable().ajax.relode();
                        }
                        else
                        {
                            Swal.fire({
                                icon: 'error',
                                title:'error',
                                text: response.message
                            });                        }
                    },
                    error: function (xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'error',
                            text: xhr.responseJSON?.message || 'error happend'
                        });
                    }
                });
        }
    })
});


// ************************* Fetch Data ************************* //
$(document).ready(function() {
    $('.restaurant-btn').on('click', function() {
        let restaurantId = $(this).data('id');
        $.ajax({
            url:`${baseUrl}/dashboard/admin/meals/by-restaurant/${restaurantId} `,
            type: 'GET',
            processData: false,
            contentType: false,
            success: function (response){
                if(response.status === 'success')
                {
                    if (!response.meals || response.meals.length === 0) {
                        $('#meals-table tbody').html(`
                        <tr>
                            <td colspan="5" class="text-center text-muted"> No Meals </td>
                        </tr>
                        `);
                    }
                    else
                    {
                        let tbody = $("#meals-table tbody");
                        tbody.empty();
                        response.meals.forEach(function (meal){
                            let imgePath = `${baseUrl}/assets/meals/uploads/${meal.image}`;
                            let row = `
                        <tr>
                            <td>
                            <img src="${imgePath}" width="50" alt="Meal Image" class="rounded-circle">
                            </td>
                            <td data-name="${meal.name}">${meal.name}</td>
                            <td data-price="${meal.price}">${meal.price}</td>
                            <td data-description="${meal.description}">${meal.description}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill mx-1 editBtn"
                                data-id=${meal.id} data-bs-toggle="modal" data-bs-target="#editModal">
                                    <i class="bi bi-pencil-square">Edit</i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger deleteBtn rounded-pill mx-1" data-id=${meal.id}>
                                    <i class="bi bi-trash">Delete</i>
                                </button>
                            </td>
                        </tr>
                       `;
                            tbody.append(row);
                        });
                    }
                }
            },
            error: function (xhr){
                Swal.fire({
                    icon:  "error",
                    title: "error",
                    message:"Eroorrrr"
                });
            }
        });
    });
    let editMealId = null;
    $(document).on("click",".editBtn",function (){
        editMealId = $(this).data("id");
        let row = $(this).closest('tr');
        let modal = document.getElementById("editModal");
        let name = row.find('td[data-name]').data('name');
        let price = row.find('td[data-price]').data('price');
        let description = row.find('td[data-description]').data('description');
        $("#name").val(name);
        $("#price").val(price);
        $("#description").val(description);
    });

    $("#editFormModal").on('submit',function (e){
        e.preventDefault();
        let formData = new FormData(this)
        // formData.append('meal_id',editMealId);
        formData.append('_method','PUT')
        $.ajax({
            url:`${baseUrl}/dashboard/admin/meals/${editMealId}`,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status === 'success'){
                    Swal.fire({
                        icon:"success",
                        title:'Success',
                        text:response.message,
                        timer:1000
                    });
                    const modalElement = document.getElementById('editModal');
                    const modalInstance = bootstrap.Modal.getInstance(modalElement);
                    modalInstance.hide();
                    location.reload();
                }
                else
                {
                    Swal.fire({
                        icon:'error',
                        title:'Error',
                        text:"Something went happen",
                        timer:1000
                    });
                }
            }
        })
    });



    $(document).on("click", ".deleteBtn", function () {
        let mealId = $(this).data("id");
        let row = $(this).closest("tr");

        Swal.fire({
            title: "Are you sure!",
            text: "This is can't be undo",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes delete it",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `${baseUrl}/dashboard/admin/meals/${mealId}`,
                    type: 'DELETE',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire("Deleted", response.message, "success");
                            row.remove();
                        } else {
                            Swal.fire("error", "Can't delete it", "error");
                        }
                    },
                    error: function() {
                        Swal.fire("error", "can't connect to the server", "error");
                    }
                });
            }
        });
    });
});


// ************************* Custom Jquery Validation ************************* //
$.validator.addMethod("imageType", function(value, element) {
    if (element.files.length === 0) return true; // skip if no file
    let type = element.files[0].type;
    return type === "image/jpeg" || type === "image/png" || type === "image/gif";
}, "JPG,PNG,JPEG only are required");

$.validator.addMethod("imageSize", function(value, element) {
    if (element.files.length === 0) return true; // skip if no file
    let size = element.files[0].size;
    return size <= 2 * 1024 * 1024; // 2MB
}, "Maximum file is 2MB");
