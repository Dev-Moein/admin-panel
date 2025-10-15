<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ContactUsController extends Controller
{
    public function index()
    {
        $messages=ContactUs::all();
        return view('contact-us.index',compact('messages'));
    }
    public function show(ContactUs $contact)
    {
        return view('contact-us.show',compact('contact'));
    }
     public function destroy(ContactUs $contact)
    {
       $contact->delete();
       return Redirect()->back()->with('warning','پبام با موفیقت حدف شد');
    }
}
