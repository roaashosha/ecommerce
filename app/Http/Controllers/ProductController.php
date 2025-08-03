<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // public function index($id){
    //     $data['product'] = Product::findOrFail($id);
    //     return view('user.prods.index')->with($data);
    // }
    public function show($id){
        // $data['cats'] = Category::all();
        $data['product'] = Product::findOrFail($id);
        $data['products'] = Product::where('category_id', $data['product']->category_id)
                               ->where('id', '!=', $id) // optional: limit results
                               ->get();
        return view("user.prods.show")->with($data); 
    }
}
