<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    use ApiResponseTrait;
    public function index(){
        $categories = Category::select('id','name')->get();
        // $cats = CategoryResource::collection(Category::get());
        return $this->ApiResponse(CategoryResource::collection($categories),"data returned successfully",200);
    }

    public function show($id){
        $cat = Category::find($id)->select('id','name');
        if ($cat){
            return $this->ApiResponse(new CategoryResource($cat),"data returned successfully",200);     
        }
        return $this->ApiResponse(null,"not found",401);     
    }

    // public function store(Request $request){
    //     $validator = Validator::make($request->all(),[
    //         "name"=>"required|string|max:50",
    //         "img"=>"required|string"
    //     ]);
    //     if ($validator->fails()){
    //         return $this->ApiResponse(null,$validator->errors(),401); 
    //     }

    //     $cat= Category::create($request->all());
    //     if ($cat){
    //         return $this->ApiResponse(new CategoryResource($cat),"data created successfully",201);     
    //     }
    //     return $this->ApiResponse(null,"data is not saved",401); 
    // } 

    // public function update(Request $request,$id){
    //     $validator = Validator::make($request->all(),[
    //         "name"=>"required|string|max:50",
    //         "img"=>"required|string"
    //     ]);
    //     if ($validator->fails()){
    //         return $this->ApiResponse(null,$validator->errors(),400); 
    //     }      
    //     $cat =Category::find($id);
    //     if (! $cat){
    //         return $this->ApiResponse(null,"data is not found",401); 
    //     }
    //     $cat->update($request->all());
    //     if ($cat){
    //         return $this->ApiResponse(new CategoryResource($cat),"data updated successfully",201);     
    //     }
    

    // }

    // public function destroy($id){
    //     $cat =Category::find($id);
    //     if (! $cat){
    //         return $this->ApiResponse(null,"data is not found",401); 
    //     }
    //     $cat->delete($id);
    //     if ($cat){
    //         return $this->ApiResponse(null,"data deleted successfully",201);     
    //     }
    // }
}
