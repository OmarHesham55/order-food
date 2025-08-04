<?php

namespace App\Services;

use App\Mail\OrderPlacedMail;
use App\Models\Meal;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function getCart()
    {
        return Session::get('cart', []);

    }

    public function addToCart(Meal $meal)
    {
        $cart = $this->getCart();
        $mealId = $meal->id;
        if (isset($cart[$mealId])) {
            $cart[$mealId]['quantity'] += 1;
        } else {
            $cart[$mealId] = [
                'name' => $meal->name,
                'price' => $meal->price,
                'quantity' => 1
            ];
        }
        Session::put('cart',$cart);

        return $cart;
    }

    public function clearCart()
    {
        Session::forget('cart');
    }

    public function removeItem($mealId)
    {
        $cart = $this->getCart();
        if ((isset($cart[$mealId])))
        {
            unset($cart[$mealId]);
        }
        Session::put('cart', $cart);
        return $cart;
    }

    public function calculateItems($cart = null)
    {
        $cart = $cart ?? $this->getCart();
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['quantity'] * $item['price'];
        }
        return $total;
    }
    public function placeOrder($userId,$restaurantId)
    {
        $cart = $this->getCart();
        $mealIds = array_keys($cart);

        if(empty($cart)) {
            return [
                'status' => 'error',
                'message' => 'cart is empty'
            ];
        }


        $validMealIds = Meal::whereIn('id',$mealIds)->pluck('id')->toArray();
        $invalidMeals = array_diff($mealIds,$validMealIds);

        if(count($invalidMeals) > 0) {
            return [
                'status' => 'error',
                'message' => 'some meals are invalid',
                'invalidIds' => $invalidMeals
            ];
        }

        $total = $this->calculateItems($cart);

        $order = Order::create([
            'user_id' => $userId,
            'restaurant_id' => $restaurantId,
            'status' => 'pending',
            'total_price' => $total,
            'address' => 'default address'
        ]);
        foreach ($cart as $mealId => $item)
        {
            OrderItem::create([
               'order_id' => $order->id,
               'meal_id' => $mealId,
               'quantity' => $item['quantity'],
               'price' => $item['price']
            ]);
        }
        $this->clearCart();

        Mail::to("omarhisham32@gmail.com")
            ->queue(new OrderPlacedMail([
                'id' => $order->id,
                'total_price' => $order->total_price,
            ]));

        return [
            'status' => 'success',
            'order_id' => $order->id
        ];

    }
}
