<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function show($id){
        $data['cats'] = Category::all();
        $data['cat']= Category::findOrFail($id);
        $data['prods']= Product::where('category_id','=',$id)->get();
        return view("user.cats.show")->with($data);    
    }

    public function SortBy(Request $request,$id){
        $sort = $request->query('sort'); // asc or desc
        $data['cat'] = Category::findOrFail($id);
        $data['cats'] = Category::all();
        // $data['range'] = null;
        $query = Product::where('category_id', $id);
        if ($sort) {
            $query->orderBy('name', $sort);
        }
        $data['prods'] = $query->get();
        return view('user.cats.show')->with($data);
        
    }

    public function CatByColor($id,$color){
        $data['cats'] = Category::all();
        $data['color'] = $color;
        $data['cat']= Category::findOrFail($id);
        $data['prods'] = Product::where('category_id','=',$id)->where('color_id','=',$color)->get();
        return view('user.cats.show')->with($data);     
    }

    public function catByRange($id,$range){
        $data['cats'] = Category::all();
        $data['cat']= Category::findOrFail($id);
        $data['range']= $range;
        if (str_starts_with($range,'more-')){
            $min =floatval(str_replace('more-','',$range));
            $data['prods'] =Product::where('category_id','=',$id)->where('price','>=',$range)->get();
        }
        else if(str_contains($range,'-')){
             [$max,$min] = explode('-',$range);
            $max = floatval($max);
            $min = floatval($min);
            $data['prods']= Product::where('category_id','=',$id)->whereBetween('price',[$min,$max])->get();
        }else{
            $data['prods'] = Product::where('category_id', $id)->get();
        }
       
        return view('user.cats.show')->with($data);
    }
    
}
