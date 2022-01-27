<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\TaskResource;
use App\Mail\ContactAdmin;
use App\Mail\OrderMail;
use App\Mail\RegisterAdmin;
use App\Mail\RegisterMail;
use App\Models\Configuration;
use App\Models\Contact;
use App\Models\Coupon;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\Transaction;
use App\Models\UserAddress;
use App\Models\UserOrder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class JWTController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'contact', 'changepass', 'editprofile', 'checkout']]);
    }

    public function register(Request $req)      // customer registration api with email
    {
        $admin = Configuration::where('email_type', '=', 'Admin')->first();
        $validator = Validator::make($req->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string',

        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        } else {
            $user = new User();
            $user->first_name = $req->first_name;
            $user->last_name = $req->last_name;
            $user->status = 1;
            $user->role = 5;
            $user->email = $req->email;
            $user->password = Hash::make($req->password);
            if ($user->save()) {
                $regmail = [
                    'email' => $user->email,
                    'password' => $req->password,
                ];
                Mail::to($user->email)->send(new RegisterMail($regmail));
                Mail::to($admin->email)->send(new RegisterAdmin($regmail));
                return response(['user' => new TaskResource($user), 'msg' => 'Thankyou for registering.', 'error' => 0], 201);
            } else {
                return response()->json(['msg' => 'User registration failed, Try again later.', 'error' => 1]);
            }
        }
    }

    public function login(Request $req)         // customer login api
    {
        $validator = Validator::make($req->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        } else {
            if (!$token = auth()->guard('api')->attempt($validator->validated())) {
                return response()->json(['error' => 1, 'message' => 'Unauthorized User',], 401);
            }
            // return $this->respondWithToken($token);
            return response()->json(['error' => 0, 'token' => $token, 'email' => $req->email, 'message' => 'Logged in successfully!',], 200);
        }
    }

    public function respondWithToken($token)
    {
        return response()->json([
            'error' => 0,
            'message' => 'Logged in',
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->guard('api')->factory()->getTTL() * 60
        ]);
    }

    public function contact(Request $req)       // contact api
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required|string',
            'email' => 'required|string',
            'subject' => 'required|string',
            'message' => 'required|string',

        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        } else {
            $con = new Contact();
            $con->name = $req->name;
            $con->email = $req->email;
            $con->subject = $req->subject;
            $con->status = 0;
            $con->message = $req->message;
            if ($con->save()) {
                $admin = Configuration::where('email_type', '=', 'Admin')->first();
                $conmail = [
                    'name' => $req->name,
                    'email' => $req->email,
                    'subject' => $req->subject,
                    'message' => $req->message
                ];
                Mail::to($admin->email)->send(new ContactAdmin($conmail));
                return response(['contact' => new TaskResource($con), 'msg' => "Your message is recorded. We'll connect back with you soon!", 'error' => 0], 201);
            } else {
                return response()->json(['msg' => 'Sending message failed, Try again later.', 'error' => 1]);
            }
        }
    }

    public function changepass(Request $req)    // change password api
    {
        $user = User::where('email', '=', $req->email)->first();
        if (Hash::check($req->oldpassword, $user->password)) {
            $validator = Validator::make($req->all(), [
                'password' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors());
            } else {
                $user->password = Hash::make($req->password);
                if ($user->save()) {
                    return response(['user' => new TaskResource($user), 'msg' => 'Password changed successfully!', 'error' => 0], 201); //using resource
                } else {
                    return response()->json(['msg' => 'Password change failed', 'error' => 2]);
                }
            }
        } else {
            return response()->json(['msg' => "Current password doesn't match", 'error' => 1]);
        }
    }

    public function editprofile(Request $req)   // edit profile api
    {
        $user = User::where('id', '=', $req->id)->first();
        $validator = Validator::make($req->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        } else {
            $user->first_name = $req->first_name;
            $user->last_name = $req->last_name;
            $user->email = $req->email;
            if ($user->save()) {
                return response(['user' => new TaskResource($user), 'msg' => 'Profile updated successfully', 'error' => 0], 201);
            } else {
                return response()->json(['msg' => 'Profile updation failed, Try again later.', 'error' => 1]);
            }
        }
    }

    public function checkout(Request $req)      // place order api
    {
        $admin = Configuration::where('email_type', '=', 'Admin')->first();
        $status = 0;
        $user = User::where('email', '=', $req->id)->first();
        $id = $user->id;
        $ord = new UserOrder();
        $ord->user_id = $id;

        $add = new UserAddress();
        $add->user_id = $id;
        $add->name = $req->first_name;
        $add->email = $req->email;
        $add->address_1 = $req->line1;
        $add->address_2 = $req->line2;
        $add->city = $req->city;
        $add->postal_code = $req->pincode;
        $add->state = $req->state;
        $add->mobile = $req->mobile;
        $add->save();

        $ord->address_id = $add->id;
        $ord->total = $req->total;
        $ord->status = 0;

        if ($req->mode == 2) {
            $ord->payment_mode = 2;
            $trans = new Transaction();
            $trans->card_name = $req->cardname;
            $trans->card_number = $req->card;
            $trans->cvv = $req->cvv;
            $trans->expiry = $req->expiry;
            $trans->amount = $req->total;
            $trans->save();

            $ord->transaction_id = $trans->id;
        } else {
            $ord->payment_mode = 0;
        }

        if ($req->coupon > 0) {
            $ord->coupon_id = $req->coupon;
            Coupon::where('id',  $req->coupon)->decrement('quantity', 1);
        }
        $ord->comment = $req->comment;
        $ord->save();

        $products = $req->cart;
        // echo $cart;
        // $products = json_decode($cart, true);
        // return $cart;
        // exit;
        $prodetails = collect();
        foreach ($products as $p) {

            $pro = new OrderDetail();
            $pro->order_id = $ord->id;
            $pro->product_id = $p['pid'];
            $pro->product_name = $p['name'];
            $pro->price = $p['price'];
            Product::where('id',  $p['pid'])->decrement('quantity', $p['quantity']);
            ProductAttribute::where('product_id',  $p['pid'])->decrement('quantity', $p['quantity']);
            $pro->quantity = $p['quantity'];
            $total = bcmul($p['quantity'], $p['price']);
            $pro->total = $total;
            $pro->save();
            $prodetails->push($pro);
            
        }
        $prodetails = $prodetails->flatten();
        $catpro = Product::all();
        $status = 1;
        if ($status == 1) {
            $ordmail = [
                'address' => $add,
                'order' => $ord,
                'details' => $prodetails,
                'product' => $catpro
            ];
            Mail::to($req->id)->send(new OrderMail($ordmail));
            Mail::to($admin->email)->send(new OrderMail($ordmail));
            return response(['order' => new TaskResource($ord), 'msg' => 'Order placed successfully', 'error' => 0], 201);
        } else {
            return response()->json(['msg' => 'Placing order failed, Try again later.', 'error' => 1]);
        }
    }

    public function profile()
    {
        return response()->json(auth()->guard('api')->user());
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->guard('api')->refresh());
    }

    public function logout()
    {
        auth()->guard('api')->logout();
        return response()->json(['msg' => 'Logged Out']);
    }
}
