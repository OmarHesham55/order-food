<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::with('meals')->get();
        return view('customers.home',compact('restaurants'));
    }
}
