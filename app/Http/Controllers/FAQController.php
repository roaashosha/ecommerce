<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Page;
use Illuminate\Http\Request;

class FAQController extends Controller
{
    public function index(){
        // $data['cats'] = Category::all();
        $data['page'] = Page::findOrFail(2);
        return view('user.faq.faq')->with($data);
    }
}
