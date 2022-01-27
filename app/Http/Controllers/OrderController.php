<?php

namespace App\Http\Controllers;

use App\Mail\OrderUpdateMail;
use App\Models\Coupon;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class OrderController extends Controller
{
    public function order() //show orders
    {
        $ordData = UserOrder::paginate(5);
        $userData = User::all();
        $proDetails = OrderDetail::all();
        $products = Product::all();
        $coupon = Coupon::all();
        return view(
            'admin.pages.order.orders',
            [
                'ordData' => $ordData,
                'userData' => $userData,
                'products' => $products,
                'proDetails' => $proDetails,
                'coupon' => $coupon
            ]
        );
    }

    public function orderValid(Request $req, $id)    // update order validation with email
    {
        $validateOrd = $req->validate([
            'status' => 'required',
            'ordid' => 'required',

        ]);
        if ($validateOrd) {
            $ord = UserOrder::where('id', '=', $id)->first();
            $user = User::where('id', '=', $ord->user_id)->first();
            $address = UserAddress::where('id', '=', $ord->address_id)->first();
            $ord->status = $req->status;

            switch ($req->status) {
                case 1:
                    $status = 'Confirmed';
                    break;
                case 2:
                    $status = 'Shipped';
                    break;
                case 3:
                    $status = 'Delivered';
                    break;
                default:
                    $status = 'Placed';
            }

            try {
                $ord->save();
                $ordmail = [
                    'order' => $ord,
                    'status' => $status,
                    'address' => $address
                ];
                Mail::to($user->email)->send(new OrderUpdateMail($ordmail));
                return Redirect::to('/order')->with('Success', 'Order status updated successfully');
            } catch (\Illuminate\Database\QueryException $e) {
                return back()->with('Error', 'Updating status failed - ' . $e->getMessage());
            }
        }
    }
}
