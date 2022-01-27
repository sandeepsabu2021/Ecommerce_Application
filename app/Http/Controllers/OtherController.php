<?php

namespace App\Http\Controllers;

use App\Models\CMS;
use App\Models\Configuration;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class OtherController extends Controller
{
    public function cms()  //show cms
    {
        $cmsData = CMS::paginate(5);
        return view('admin.pages.others.cms', ['cmsData' => $cmsData]);
    }

    public function addCms()  //add cms
    {
        return view('admin.pages.others.add-cms');
    }

    public function cmsValid(Request $req)    //add cms validation
    {
        $validateCMS = $req->validate([
            'title' => 'required',
            'body' => 'required|min:5',
            'url' => 'required',

        ], [
            'title.required' => "Enter title",

            'body.required' => "Enter body",
            'body.min' => "Minimum 5 characters",

            'url.required' => "Enter Url",


        ]);
        if ($validateCMS) {

            $cms = new CMS();
            $cms->title = $req->title;
            $cms->body = $req->body;
            $cms->url = $req->url;
            try {
                $cms->save();
                return Redirect::to('/cms')->with('Success', 'CMS added successfully');
            } catch (\Illuminate\Database\QueryException $e) {
                return back()->with('Error', 'Adding CMS failed' . $e->getMessage());
            }
        }
    }

    public function editCms($id)  //edit cms
    {
        $cmsData = CMS::where('id', '=', $id)->first();
        return view('admin.pages.others.edit-cms', ['cmsData' => $cmsData]);
    }

    public function editCmsValid(Request $req)    //edit cms validation
    {
        $validateCMS = $req->validate([
            'title' => 'required',
            'body' => 'required|min:5',
            'url' => 'required',
            'cid' => 'required'

        ], [
            'title.required' => "Enter title",

            'body.required' => "Enter body",
            'body.min' => "Minimum 5 characters",

            'url.required' => "Enter Url",

        ]);
        if ($validateCMS) {

            $cms = CMS::where('id', '=', $req->cid)->first();
            $cms->title = $req->title;
            $cms->body = $req->body;
            $cms->url = $req->url;

            try {
                $cms->save();
                return back()->with('Success', 'CMS updated successfully');
            } catch (\Illuminate\Database\QueryException $e) {
                return back()->with('Error', 'Updating CMS failed' . $e->getMessage());
            }
        }
    }

    public function delCms(Request $req)   //delete cms
    {
        $id = $req->id;
        $cms = CMS::where('id', '=', $id)->first();

        try {
            $cms->delete();
            return "CMS deleted successfully";
        } catch (\Illuminate\Database\QueryException $e) {
            return "Error deleting CMS - " . $e->getMessage();
        }
    }

    public function config()  //show config
    {
        $conData = Configuration::paginate(5);
        return view('admin.pages.others.config', ['conData' => $conData]);
    }

    public function addConfig()  //add config
    {
        return view('admin.pages.others.add-config');
    }

    public function configValid(Request $req)    //add config validation
    {
        $validateConfig = $req->validate([
            'email_type' => 'required|unique:configurations',
            'mail' => 'required|regex:/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/',

        ], [
            'email_type.required' => "Enter configuration type",
            'email_type.unique' => "Configuration already exists",

            'mail.required' => "Enter email",
            'mail.regex' => "Enter valid format (example: abc@lmn.xyz)",


        ]);
        if ($validateConfig) {

            $con = new Configuration();
            $con->email_type = $req->email_type;
            $con->email = $req->mail;
            try {
                $con->save();
                return Redirect::to('/config')->with('Success', 'Configuration added successfully');
            } catch (\Illuminate\Database\QueryException $e) {
                return back()->with('Error', 'Adding config failed' . $e->getMessage());
            }
        }
    }

    public function editConfig($id)  //edit config
    {
        $conData = Configuration::where('id', '=', $id)->first();
        return view('admin.pages.others.edit-config', ['conData' => $conData]);
    }

    public function editConfigValid(Request $req)    //edit config validation
    {
        $validateConfig = $req->validate([
            'email_type' => 'required',
            'mail' => 'required|regex:/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/',
            'cid' => 'required'

        ], [
            'email_type.required' => "Enter configuration type",

            'mail.required' => "Enter email",
            'mail.regex' => "Enter valid format (example: abc@lmn.xyz)",

        ]);
        if ($validateConfig) {

            $con = Configuration::where('id', '=', $req->cid)->first();
            $con->email_type = $req->email_type;
            $con->email = $req->mail;

            try {
                $con->save();
                return back()->with('Success', 'Configuration updated successfully');
            } catch (\Illuminate\Database\QueryException $e) {
                return back()->with('Error', 'Updating config failed' . $e->getMessage());
            }
        }
    }

    public function delConfig(Request $req)   //delete config
    {
        $id = $req->id;
        $con = Configuration::where('id', '=', $id)->first();

        try {
            $con->delete();
            return "Config deleted successfully";
        } catch (\Illuminate\Database\QueryException $e) {
            return "Error deleting Config - " . $e->getMessage();
        }
    }

    public function coupon()  //show coupons
    {
        $copData = Coupon::paginate(5);
        return view('admin.pages.others.coupons', ['copData' => $copData]);
    }

    public function addCoupon()  //add coupon
    {
        return view('admin.pages.others.add-coupon');
    }

    public function couponValid(Request $req)    //add coupon validation
    {
        $validateCoupon = $req->validate([
            'code' => 'required',
            'type' => 'required',
            'amt' => 'required',
            'quant' => 'required',


        ], [
            'code.required' => "Enter coupon code",
            'type.required' => "Select type",
            'amt.required' => "Enter amount or percentage",
            'quant.required' => "Enter quantity",

        ]);
        if ($validateCoupon) {

            $cop = new Coupon();
            $cop->code = $req->code;
            $cop->type = $req->type;
            $cop->amount = $req->amt;
            $cop->quantity = $req->quant;
            try {
                $cop->save();
                return Redirect::to('/coupon')->with('Success', 'Coupon added successfully');
            } catch (\Illuminate\Database\QueryException $e) {
                return back()->with('Error', 'Adding Coupon failed' . $e->getMessage());
            }
        }
    }

    public function editCoupon($id)  //edit coupon
    {
        $copData = Coupon::where('id', '=', $id)->first();
        return view('admin.pages.others.edit-coupon', ['copData' => $copData]);
    }

    public function editCouponValid(Request $req)    //edit coupon validation
    {
        $validateCoupon = $req->validate([
            'code' => 'required',
            'type' => 'required',
            'amt' => 'required',
            'quant' => 'required',
            'cid' => 'required',


        ], [
            'code.required' => "Enter coupon code",
            'type.required' => "Select type",
            'amt.required' => "Enter amount or percentage",
            'quant.required' => "Enter quantity",

        ]);
        if ($validateCoupon) {

            $cop = Coupon::where('id', '=', $req->cid)->first();
            $cop->code = $req->code;
            $cop->type = $req->type;
            $cop->amount = $req->amt;
            $cop->quantity = $req->quant;

            try {
                $cop->save();
                return back()->with('Success', 'Coupon updated successfully');
            } catch (\Illuminate\Database\QueryException $e) {
                return back()->with('Error', 'Updating coupon failed' . $e->getMessage());
            }
        }
    }

    public function delCoupon(Request $req)   //delete coupon
    {
        $id = $req->id;
        $cop = Coupon::where('id', '=', $id)->first();

        try {
            $cop->delete();
            return "Coupon deleted successfully";
        } catch (\Illuminate\Database\QueryException $e) {
            return "Error deleting coupon - " . $e->getMessage();
        }
    }
}
