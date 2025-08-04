<?php

namespace App\Http\Controllers;

use App\Mail\OrderPlacedMail;
use App\Models\Meal;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CartController extends Controller
{

    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function addCart(Request $request)
    {
        if ($request->meal_id)
        {
            $meal = Meal::findOrFail($request->meal_id);
            $cart = $this->cartService->addToCart($meal);
            return response()->json([
                'status' => 'success',
                'message' => 'meal added to cart',
                'cart_count' => array_sum(array_column($cart,'quantity')),
                'cart' => $cart
            ]);
        }
        return response()->json(['status' => 'error','message' => 'something went wrong']);
    }


public function getCartItems()
{
    $cart = $this->cartService->getCart();

    $total = $this->cartService->calculateItems($cart);

    return response()->json([
        'status'=>'success',
        'cart' => $cart,
        'cart_count' => array_sum(array_column($cart,'quantity')),
        'total' => number_format($total,2)
    ]);
}

public function clearCart()
{
    $this->cartService->clearCart();
    return response()->json(['status' => 'success']);
}

public function removeItem(Request $request)
{
    $cart = $this->cartService->removeItem($request->id);
    $total = $this->cartService->calculateItems($cart);
    return response()->json([
        'status' => 'success',
        'cart' => $cart,
        'cart_count' => array_sum(array_column($cart,'quantity')),
        'total' =>$total
    ]);
}

public function placeOrder(Request $request){
        if(!Auth::check())
        {
            return response()->json([
                'status' => 'error',
                'message' => 'You are not authorized to place order'
            ]);
        }
        $validated = $request->validate([
        'restaurant_id' => 'required|exists:restaurants,id'
        ]);

        $result = $this->cartService->placeOrder(Auth::id(),$validated['restaurant_id']);
        if ($result['status'] === 'success') {
            return response()->json([
                'status' => 'success',
                'order_id' => $result['order_id']
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => $result['message'],
        ]);
    }



}
