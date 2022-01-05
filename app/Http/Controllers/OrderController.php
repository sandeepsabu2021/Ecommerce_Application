<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
use App\Models\UserOrder;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function order()
    {
        $ordData = UserOrder::paginate(5);
        $userData = User::all();
        $proDetails = OrderDetail::all();
        $products = Product::all();
        return view(
            'admin.pages.order.orders',
            [
                'ordData' => $ordData,
                'userData' => $userData,
                'products' => $products,
                'proDetails' => $proDetails,
            ]
        );
    }
}
