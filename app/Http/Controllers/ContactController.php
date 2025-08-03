<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index(){
        // $data['cats'] = Category::all();
        return view('user.contacts.contacts')->with($data);
    }
    public function send(Request $request)
    {
        $request->validate([
            'name'    => 'required|string',
            'email'   => 'required|email',
            'message' => 'required|string',
        ]);

        $to = "roaashosha123@gmail.com";

        Mail::raw(
            "Name: {$request->name}\nEmail: {$request->email}\n\nMessage:\n{$request->message}",
            function ($message) use ($request, $to) {
                $message->to($to)
                        ->replyTo($request->email, $request->name)
                        ->subject('Contact Form Message');
            }
        );

        return back();
    }
    
}
