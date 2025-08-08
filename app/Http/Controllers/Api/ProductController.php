<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ApiResponseTrait;
    public function allProducts(Request $request){
        $filters = $request->only(['color','min_price','max_price','category_id','sort']);
        if (empty($filters['category_id'])){
            $filters['category_id'] = 1;
        }
        
        $products = Product::with('category')->filter($filters)->select('id','price','offer_price','name','offer','category_id','img')->get();
        return $this->ApiResponse(ProductResource::collection($products),"Products are fetched Sucesffully!",200);
    }

    public function HomePageProducts(){
        $products = Product::select('id','price','offer_price','name','offer','img')->latest()->take(8)->get();
        return $this->ApiResponse(ProductResource::collection($products),"8
        Products are fetched Sucesffully!",200);
    }

    public function show($id){
        $products = Product::with('category')->where('id',$id)->select('id','price','offer_price','name','offer','desc','img','category_id')->get();
        return $this->ApiResponse(ProductResource::collection($products),"Products are fetched Sucesffully!",200);
    }

    public function relatedProducts($id){
        $product = Product::findOrFail($id); 
        $categoryId = $product->category_id;
        $products = Product::where('category_id',$categoryId)->where('id',"!=",$id)->take(4)->get();
        return $this->ApiResponse(ProductResource::collection($products),"Products are fetched Sucesffully!",200);

     }


    

}
