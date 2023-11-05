<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends Controller
{
    //giao diện danh sách sản phẩm trong giỏ hàng
    public function index()
    {
        return view('frontend.cart.index');
    }
}
