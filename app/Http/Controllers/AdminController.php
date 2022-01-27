<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use App\Models\Role;
use App\Models\UserOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function master()  // master template
    {
        return view('admin.master');
    }

    public function home()  // home page
    {
        return view('admin.pages.user.home');
    }

    public function user()  //show users
    {
        $userData = User::paginate(5);
        $roleData = Role::all();
        return view('admin.pages.user.users', ['userData' => $userData, 'roleData' => $roleData]);
    }

    public function addUser()  //add user
    {
        $roleData = Role::all();
        return view('admin.pages.user.add-user', ['roleData' => $roleData]);
    }

    public function userValid(Request $req)    //user reg validation
    {
        $validateUser = $req->validate([
            'fname' => 'required|regex:/^[a-zA-Z ]{2,100}$/',
            'lname' => 'required|regex:/^[a-zA-Z ]{2,100}$/',
            'email' => 'required|regex:/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/|unique:users',
            'role' => 'required',
            'status' => 'required',
            'password' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,12}$/',
            'conpass' => 'required_with:pass|same:password'

        ], [
            'fname.required' => "Enter first name",
            'fname.regex' => "Alphabets only, 2-100 characters",

            'lname.required' => "Enter last name",
            'lname.regex' => "Alphabets only, 2-100 characters",

            'email.required' => "Enter email",
            'email.regex' => "Enter valid format (example: abc@lmn.xyz)",
            'email.unique' => "Email already exists",

            'status.required' => "Select status",

            'password.required' => "Enter password",
            'password.regex' => "Minimum 8 and maximum 12 characters, at least one uppercase letter, one lowercase letter and one number",

            'conpass.required_with' => "Re-enter new password",
            'conpass.same' => "Password doesn't match",

        ]);
        if ($validateUser) {

            $user = new User();
            $user->first_name = $req->fname;
            $user->last_name = $req->lname;
            $user->email = $req->email;
            $user->status = $req->status;
            $user->role = $req->role;
            $user->password = Hash::make($req->password);

            try {
                $user->save();
                return Redirect::to('/user')->with('Success', 'User added successfully');
            } catch (\Illuminate\Database\QueryException $e) {
                return back()->with('Error', 'Adding user failed - ' . $e->getMessage());
            }
        }
    }

    public function changePass()    //change password page
    {
        return view('admin.pages.user.change-password');
    }

    public function passValid(Request $req) // change password validation
    {
        $validatePass = $req->validate([
            'uid' => 'required',
            'opass' => 'required',
            'pass' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/',
            'cpass' => 'required_with:pass|same:pass',
        ], [
            'opass.required' => "Enter current password",

            'pass.required' => "Enter password",
            'pass.regex' => "Minimum eight characters, at least one uppercase letter, one lowercase letter and one number",

            'cpass.required_with' => "Re-enter new password",
            'cpass.same' => "Password doesn't match",
        ]);
        if ($validatePass) {

            $password = Auth::user()->password;
            if (Hash::check($req->opass, $password)) {
                $npass = Hash::make($req->pass);
                $user = User::where('id', '=', $req->uid)->first();
                $user->password = $npass;

                try {
                    $user->save();
                    return back()->with('Success', 'Password changed successfully!');
                } catch (\Illuminate\Database\QueryException $e) {
                    return back()->with('Error', 'Password change failed - ' . $e->getMessage());
                }
            } else {
                return back()->with('Error', 'Incorrect current password');
            }
        }
    }

    public function editProfile()   // edit profile
    {
        return view('admin.pages.user.edit-profile');
    }

    public function editProfileValid(Request $req) //edit profile validation
    {
        $validateUser = $req->validate([
            'uid' => 'required',
            'fname' => 'required|regex:/^[a-zA-Z ]{2,100}$/',
            'lname' => 'required|regex:/^[a-zA-Z ]{2,100}$/',
            'email' => 'required|regex:/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/',
        ], [
            'fname.required' => "Enter first name",
            'fname.regex' => "Alphabets only, 2-100 characters",

            'lname.required' => "Enter last name",
            'lname.regex' => "Alphabets only, 2-100 characters",

            'email.required' => "Enter email",
            'email.regex' => "Enter valid format (example: abc@lmn.xyz)",

        ]);
        if ($validateUser) {

            $user = User::where('id', '=', $req->uid)->first();
            $user->first_name = $req->fname;
            $user->last_name = $req->lname;
            $user->email = $req->email;

            try {
                $user->save();
                return back()->with('Success', 'Profile updated successfully!');
            } catch (\Illuminate\Database\QueryException $e) {
                return back()->with('Error', 'Profile update failed - ' . $e->getMessage());
            }
        }
    }

    public function modifyUser($id)  //modify user
    {
        $userData = User::where('id', '=', $id)->first();
        $roleData = Role::all();
        return view('admin.pages.user.modify-user', ['userData' => $userData, 'roleData' => $roleData]);
    }

    public function modifyUserValid(Request $req)    //modify user validation
    {
        $validateUser = $req->validate([
            'fname' => 'required|regex:/^[a-zA-Z ]{2,100}$/',
            'lname' => 'required|regex:/^[a-zA-Z ]{2,100}$/',
            'email' => 'required|regex:/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/',
            'role' => 'required',
            'status' => 'required',
            'uid' => 'required',

        ], [
            'fname.required' => "Enter first name",
            'fname.regex' => "Alphabets only, 2-100 characters",

            'lname.required' => "Enter last name",
            'lname.regex' => "Alphabets only, 2-100 characters",

            'email.required' => "Enter email",
            'email.regex' => "Enter valid format (example: abc@lmn.xyz)",

            'status.required' => "Select status",

        ]);
        if ($validateUser) {

            $user = User::where('id', '=', $req->uid)->first();
            $user->first_name = $req->fname;
            $user->last_name = $req->lname;
            $user->email = $req->email;
            $user->status = $req->status;
            $user->role = $req->role;

            try {
                $user->save();
                return back()->with('Success', 'User modified successfully');
            } catch (\Illuminate\Database\QueryException $e) {
                return back()->with('Error', 'Modifying user failed - ' . $e->getMessage());
            }
        }
    }

    public function delUser(Request $req)   //delete user
    {
        $id = $req->uid;
        $user = User::where('id', '=', $id)->first();
        try {
            $user->delete();
            return "User deleted successfully";
        } catch (\Illuminate\Database\QueryException $e) {
            return "Error deleting user" . $e->getMessage();
        }
    }

    public function dashboard() //dashboard page
    {
        $typeData = Role::all();        //user count
        $data = DB::select(DB::raw("select count(*) as user_count,
        role from users group by role"));
        $pieChart = "";
        $total = 0;
        foreach ($data as $a) {
            foreach ($typeData as $type) {
                if ($type->role_id == $a->role) {
                    $name = $type->role_name;
                    $pieChart .= "['" . $name . "',     " . $a->user_count . "],";
                    $total += $a->user_count;
                }
            }
        }

        $status = DB::select(DB::raw("select count(*) as user_count,
        status from users group by status"));   //active inactive user count
        $barChart = "";
        foreach ($status as $s) {
            if ($s->status == '1') {
                $name = 'Active';
            } else {
                $name = 'Inactive';
            }
            $barChart .= "['" . $name . "',     " . $s->user_count . "],";
        }

        $proData = Product::all();      //products sold count
        $pdata = DB::select(DB::raw("select count(*) as product_count,
        product_id from order_details group by product_id"));
        $proChart = "";
        $prototal = 0;
        foreach ($pdata as $p) {
            foreach ($proData as $pro) {
                if ($pro->id == $p->product_id) {
                    $quant = OrderDetail::where('product_id', '=', $pro->id)->get();
                    $count = 0;
                    foreach($quant as $q){
                        $count = $count + $q->quantity;
                    }
                    $pname = $pro->name;
                    $proChart .= "['" . $pname . "',     " . $count . "],";
                    $prototal += $count;
                }
            }
        }

        $copData = Coupon::all();   //coupon used count
        $cdata = DB::select(DB::raw("select count(*) as coupon_count,
        coupon_id from user_orders group by coupon_id"));
        $copChart = "";
        $copcount = 0;
        foreach ($cdata as $c) {
            foreach ($copData as $cop) {
                if ($cop->id == $c->coupon_id) {
                    $cname = $cop->code;
                    $copChart .= "['" . $cname . "',     " . $c->coupon_count . "],";
                    $copcount += $c->coupon_count;
                }
            }
        }

        $orders = UserOrder::all();     //orders placed count
        $ordcount = 0;
        foreach($orders as $ord){
            $ordcount = $ordcount + 1;
        }

        $pieChart = rtrim($pieChart, ',');
        $barChart = rtrim($barChart, ',');
        $proChart = rtrim($proChart, ',');
        $copChart = rtrim($copChart, ',');

        return view('admin.pages.user.dashboard', [
            'pieChart' => $pieChart,
            'barChart' => $barChart,
            'proChart' => $proChart,
            'copChart' => $copChart,
            'total' => $total,
            'ptotal' => $prototal,
            'cop_count' => $copcount,
            'order' => $ordcount
        ]);
    }

    public function logout()    // logout
    {
        Session::flush();
        Auth::logout();
        return Redirect::to('/login');
    }
}
