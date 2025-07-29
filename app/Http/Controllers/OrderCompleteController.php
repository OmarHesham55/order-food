<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderCompleteController extends Controller
{

    public function index(Request $request)
    {
        $data = "hello";
        return view('customers.orders.orders',compact('data'));
    }
}
