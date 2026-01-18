<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function contact(): View
    {
        return view('frontend.contact');
    }

    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'message' => 'required|string|max:1000',
        ]);

        // store or email later
        return back()->with('success', 'Message sent successfully.');
    }

    public function terms(): View
    {
        return view('frontend.terms');
    }

    public function privacy(): View
    {
        return view('frontend.privacy');
    }

    public function faqs(): View
    {
        return view('frontend.faqs');
    }
}
