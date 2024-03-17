<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class FaqController extends Controller
{
    //

    public function faq()
    {
        $FaqData = Faq::paginate(5);
        return view('admin.pages.faq.faq', ['FaqData' => $FaqData]);
    }

    public function addFaq()
    {
        return view('admin.pages.faq.addFaq');
    }
   
    public function faqValid(Request $req)    //add banner validation
    {
        $validateFaq = $req->validate([
            'title' => 'required|regex:/^[a-zA-Z0-9 ]{2,100}$/',
            'description' => 'required|regex:/^[a-zA-Z ]/',

        ], [
            'title.required' => "Enter title",
            'title.regex' => "Alphanumeric only, 2-100 characters",

            'description.required' => "Add Description",
            'description.regex' => "Minimum 10 words are required",

        ]);
        if ($validateFaq) {

            $faq = new faq();
            $faq->title = $req->title;
            $faq->description = $req->description;
            
            try {
                $faq->save();
                
                return Redirect::to('/faq')->with('Success', 'FAQ uploaded successfully');
            } catch (\Illuminate\Database\QueryException $e) {
                return back()->with('Error', 'Adding banner failed' . $e->getMessage());
            }
        }
    }


    public function editFaq($id)
    {
        $faqData = faq::where('id', '=', $id)->first();
        return view('admin.pages.faq.editFaqs', ['faqData' => $faqData]);
    }


    public function editFaqValid(Request $req)    //edit banner validation
    {
        
        $validateFaq = $req->validate([
            'title' => 'required|regex:/^[a-zA-Z ]{2,100}$/',
           'description' => 'required|regex:/^[a-zA-Z ]/',

        ], [
            'title.required' => "Enter title",
            'title.regex' => "Alphabets only, 2-100 characters",

            'description.required' => "Enter a valid description",
            'description.regex' => "Enter minimum 10 characters",

        ]);
        if ($validateFaq) {
            $faq = faq::where('id', '=', $req->id)->first();
            
            $faq->title = $req->title;
            $faq->description = $req->description;

            try {
                $faq->save();
                return Redirect::to('/faq')->with('Success', 'FAQ updated successfully');
            } catch (\Illuminate\Database\QueryException $e) {
                return back()->with('Error', 'Updating banner failed' . $e->getMessage());
            }
        }
    }

    public function delFaq(Request $req)   //delete banner
    {
        $id = $req->id;
        $faq = faq::where('id', '=', $id)->first();

        $faq->title = $req->title;
        $faq->description = $req->description;

        try {
            $faq->delete();
            return "Data deleted successfully";
        } catch (\Illuminate\Database\QueryException $e) {
            return "Error deleting banner - " . $e->getMessage();
        }
    }


}
