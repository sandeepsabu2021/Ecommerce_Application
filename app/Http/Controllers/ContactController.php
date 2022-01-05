<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function contact()  //show banners
    {
        $conData = Contact::paginate(5);
        return view('admin.pages.contact.contacts', ['conData' => $conData]);
    }
}
