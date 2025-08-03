<?php

namespace App\Http\Controllers;

// use App\Models\Category;
use App\Models\Page;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public function index(){
        // $data['cats'] = Category::all();
        $data['page'] = Page::findOrFail(1);
        return view('user.aboutUs.aboutus')->with($data);
    }
}
