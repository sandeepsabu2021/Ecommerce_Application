<?php

namespace App\Http\Controllers;
use App\Models\Vendor;
use Illuminate\Support\Facades\Redirect;

use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function addVendor()     {
        return view('admin.pages.vendor.addVendor');
    }

    public function vendor()
    {
        $VendorData = Vendor::paginate(5);
        return view('admin.pages.vendor.vendors', ['VendorData' => $VendorData]);
    }

    public function vendorValid(Request $req)    //add banner validation
    {
        $validateVendor = $req->validate([
            'name' => 'required|regex:/^[a-zA-Z0-9 ]{2,100}$/',
            'image' => 'required|mimes:jpeg,jpg,png',

        ], [
            'name.required' => "Enter title",
            'name.regex' => "Alphanumeric only, 2-100 characters",

            'image.required' => "Select image",
            'image.mimes' => "Only jpeg, jpg and png files allowed",

        ]);
        if ($validateVendor) {

            $vendor = new vendor();
            $vendor->name = $req->name;
            $name = time() . "--" . $req->title . '.' . $req->image->extension();
            $vendor->image = $name;
            try {
                $vendor->save();
                $req->image->move(public_path('uploads/vendor'), $name);
                return Redirect::to('/vendor')->with('Success', 'vendor added successfully');
            } catch (\Illuminate\Database\QueryException $e) {
                return back()->with('Error', 'Adding banner failed' . $e->getMessage());
            }
        }
    }

    public function editVendor($id)
    {
        $vendorData = vendor::where('id', '=', $id)->first();
        return view('admin.pages.vendor.editVendors', ['vendorData' => $vendorData]);
    }



    public function editVendorValid(Request $req)    //edit banner validation
    {
        $validateVendor = $req->validate([
            'name' => 'required|regex:/^[a-zA-Z ]{2,100}$/',
            'image' => 'mimes:jpeg,jpg,png',

        ], [
            'name.required' => "Enter title",
            'name.regex' => "Alphabets only, 2-100 characters",

            'image.mimes' => "Only jpeg, jpg and png files allowed",

        ]);
        if ($validateVendor) {

            $vendor = vendor::where('id', '=', $req->bid)->first();
            $vendor->name = $req->name;


            try {
                $vendor->save();
                if($req->image){
                    $name = $req->img_name;
                    $req->image->move(public_path('uploads/vendor'), $name);
                }
                return Redirect::to('/vendor')->with('Success', 'vendor added successfully');
            } catch (\Illuminate\Database\QueryException $e) {
                return back()->with('Error', 'Updating banner failed' . $e->getMessage());
            }
        }
    }


    public function delVendor(Request $req)   //delete banner
    {
        $id = $req->id;
        $vendor = vendor::where('id', '=', $id)->first();

        try {
            $img = public_path('uploads/vendor/') . $vendor->image;
            unlink($img);
            $vendor->delete();
            return "banner deleted successfully";
        } catch (\Illuminate\Database\QueryException $e) {
            return "Error deleting banner - " . $e->getMessage();
        }
    }
}
