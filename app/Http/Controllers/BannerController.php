<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\Redirect;

class BannerController extends Controller
{
    public function banner()  //show banners
    {
        $bannerData = Banner::paginate(5);
        return view('admin.pages.banner.banners', ['bannerData' => $bannerData]);
    }

    public function addBanner()  //add banner
    {
        return view('admin.pages.banner.add-banner');
    }

    public function bannerValid(Request $req)    //banner validation
    {
        $validateBanner = $req->validate([
            'title' => 'required|regex:/^[a-zA-Z ]{2,100}$/',
            'subtitle' => 'required|regex:/^[a-zA-Z ]{5,100}$/',
            'body' => 'required|min:5|max:500',
            'image' => 'required|mimes:jpeg,jpg,png',

        ], [
            'title.required' => "Enter title",
            'title.regex' => "Alphabets only, 2-100 characters",

            'subtitle.required' => "Enter sub-title",
            'subtitle.regex' => "Alphabets only, 5-100 characters",

            'body.required' => "Enter body",
            'body.min' => "Minimum 5 characters",
            'body.max' => "Maximum 5 characters",

            'image.required' => "Select image",
            'image.mimes' => "Only jpeg, jpg and png files allowed",

        ]);
        if ($validateBanner) {

            $banner = new Banner();
            $banner->title = $req->title;
            $banner->sub_title = $req->subtitle;
            $banner->body = $req->body;
            $name = time() . "--" . $req->title . '.' . $req->image->extension();
            $banner->image = $name;
            try {
                $banner->save();
                $req->image->move(public_path('uploads/banners'), $name);
                return Redirect::to('/banner')->with('Success', 'Banner added successfully');
            } catch (\Illuminate\Database\QueryException $e) {
                return back()->with('Error', 'Adding banner failed' . $e->getMessage());
            }
        }
    }

    public function editBanner($id)  //edit banner
    {
        $bannerData = Banner::where('id', '=', $id)->first();
        return view('admin.pages.banner.edit-banner', ['bannerData' => $bannerData]);
    }

    public function editBannerValid(Request $req)    //user validation
    {
        $validateBanner = $req->validate([
            'title' => 'required|regex:/^[a-zA-Z ]{2,100}$/',
            'subtitle' => 'required|regex:/^[a-zA-Z ]{5,100}$/',
            'body' => 'required|min:5|max:500',
            'image' => 'mimes:jpeg,jpg,png',

        ], [
            'title.required' => "Enter title",
            'title.regex' => "Alphabets only, 2-100 characters",

            'subtitle.required' => "Enter sub-title",
            'subtitle.regex' => "Alphabets only, 5-100 characters",

            'body.required' => "Enter body",
            'body.min' => "Minimum 5 characters",
            'body.max' => "Maximum 5 characters",

            'image.mimes' => "Only jpeg, jpg and png files allowed",

        ]);
        if ($validateBanner) {

            $banner = Banner::where('id', '=', $req->bid)->first();
            $banner->title = $req->title;
            $banner->sub_title = $req->subtitle;
            $banner->body = $req->body;

            try {
                $banner->save();
                if($req->image){
                    $name = $req->img_name;
                    $req->image->move(public_path('uploads/banners'), $name);
                }
                return back()->with('Success', 'Banner updated successfully');
            } catch (\Illuminate\Database\QueryException $e) {
                return back()->with('Error', 'Updating banner failed' . $e->getMessage());
            }
        }
    }

    public function delBanner(Request $req)   //delete banner
    {
        $id = $req->id;
        $banner = Banner::where('id', '=', $id)->first();

        try {
            $img = public_path('uploads/banners/') . $banner->image;
            unlink($img);
            $banner->delete();
            return "banner deleted successfully";
        } catch (\Illuminate\Database\QueryException $e) {
            return "Error deleting banner - " . $e->getMessage();
        }
    }
}
