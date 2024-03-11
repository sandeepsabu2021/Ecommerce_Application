<?php

namespace App\Http\Controllers;

use App\Models\CMS;
use App\Models\Configuration;
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



}
