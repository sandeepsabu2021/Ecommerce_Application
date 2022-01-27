<?php

namespace App\Http\Controllers;

use App\Mail\AdminReply;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function contact()  //show customer messages
    {
        $conData = Contact::paginate(5);
        return view('admin.pages.contact.contacts', ['conData' => $conData]);
    }

    public function replyContact($id)  //reply contact
    {
        $conData = Contact::where('id', '=', $id)->first();
        return view('admin.pages.contact.contact-reply', ['con' => $conData]);
    }

    public function replyValid(Request $req)    //reply validation with email
    {
        $con = Contact::where('id', '=', $req->cid)->first();
        $con->reply = $req->con_reply;
        $con->status = 1;

        try {
            $con->save();
            $conmail = [
                'name' => $con->name,
                'subject' => $con->subject,
                'message' => $req->con_reply
            ];
            Mail::to($con->email)->send(new AdminReply($conmail));
            return Redirect::to('/contact')->with('Success', 'Reply sent successfully');
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('Error', 'Sending reply failed' . $e->getMessage());
        }
    }
}
