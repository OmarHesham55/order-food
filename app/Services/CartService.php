<?php

namespace App\Services;

use App\Models\Meal;
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
}
