<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{


 public function index()
    {
        $item = AboutUs::first();
        return view('about-us.index',compact('item'));
    }

       public function edit(AboutUs $about)
    {
        return view('about-us.edit',compact('about'));
    }

     public function update(Request $request,AboutUs $about)
    {
         $request->validate([
            'title' => 'required|string',
            'link' => 'required|string',
            'body' => 'required|string'
        ]);
        $about->update([
         'title' => $request->title,
            'link' => $request->link,
            'body' => $request->body
        ]);
         return redirect()->route('about-us.index')->with('success','بخش درباره ما  با موفقیت ویرایش شد');
    }
}
