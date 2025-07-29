$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function (e){
    $(".add-to-cart-btn").click(function (e){
        e.preventDefault();
        let mealId = $(this).data("id");
        let restaurantId = $(this).closest(".restaurant-card").find(".restaurant-name").data("id");
        let currentRestaurantId = sessionStorage.getItem("restaurant_id");
        if(currentRestaurantId && currentRestaurantId !== restaurantId.toString())
        {

            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'You can only add meals from one restaurant.'
            });
            return;
        }
        $.ajax({
            type: "POST",
            url: `${baseUrl}/order_food/add_to_cart`,
            data: {
                meal_id:mealId,
            },
            success: function (response){
                console.log("cart response",response.cart);

              if(response.status === 'success')
              {
                  sessionStorage.setItem("restaurant_id",restaurantId);
                  $("#cart-item-count").text(response.cart_count);
                  Swal.fire({
                      icon: 'success',
                      title: 'Success',
                      text: 'Meal added successfully'
                  });
                  loadCart();
              }
            },
        });
    });

    function loadCart()
    {
        $.ajax({
            url: `${baseUrl}/order_food/cart_items`,
            type: 'GET',
            success: function (response){
                if (response.status === 'success')
                {
                    let cartHtml = "";
                    let cart = response.cart;
                    let total = response.total;
                    if(Object.keys(cart).length === 0)
                    {
                        cartHtml = "<p>Empty Cart</p>";
                    }
                    else
                    {
                        $.each(cart,function (id,item){
                           cartHtml += `<div class="cart-item">
                                <p><strong>${item.name}</strong></p>
                                <p>Quantity ${item.quantity}</p>
                                <p>Price ${item.price} LE</p>
                                <button class="remove-item" data-id="${id}">remove</button>
                                <hr>
                            </div>`
                        });
                        cartHtml += `<p><strong>Total: ${total} LE</strong></p>`;
                    }
                        $("#cart-items-list").html(cartHtml);
                }
            }
        });
    }
    loadCart();

    $(document).on("click",".remove-item",function (){
        let id = $(this).data("id");
        $.ajax({
            url:`${baseUrl}/order_food/remove_item_cart`,
            type:"POST",
            data: {
                id:id
            },
            success: function (response) {
                if (response.status === 'success')
                {
                    loadCart();
                    const count = Object.values(response.cart || {}).reduce((acc, item) => acc + item.quantity, 0);
                    $("#cart-item-count").text(count);
                    if (count === 0)
                    {
                        sessionStorage.removeItem("restaurant_id");
                    }
                }
            },
        });
    });

    $("#placeorder-btn").click(function (){
        let restaurantId = sessionStorage.getItem("restaurant_id");
        if(!restaurantId)
        {
            Swal.fire({
                icon:'error',
                title:'error',
                text: 'No restaurant Selected.'
            })
            return;
        }
        $.ajax({
            url: `${baseUrl}/order_food/place_order`,
            type:"POST",
            data: {restaurant_id:restaurantId},
            success: function (response){
                if (response.status === 'success')
                {
                sessionStorage.removeItem("restaurant_id");
                Swal.fire('Success','Order Placed','success');
                location.reload();
                }
                else
                {
                    Swal.fire("Error","Failed to place the order","error");
                }
            },
        });
    });

    $("#clear-cart-button").click(function (){
        $.ajax({
            url:`${baseUrl}/order_food/cart_clear`,
            type:"get",
            success: function (response) {
                if(response.status === 'success'){
                    sessionStorage.removeItem("restaurant_id");
                    loadCart();
                    $("#cart-item-count").text(0);
                    Swal.fire({
                        icon:'success',
                        title:'success',
                        text:'Cart is empty now'
                    });
                }
            },
        });
    });
});
