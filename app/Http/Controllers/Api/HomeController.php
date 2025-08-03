<?php

namespace App\Http\Controllers\Api;
use App\Models\Category;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    use ApiResponseTrait;
    public function index(){
        $cats = Category::get();
        return $this->ApiResponse($cats,"data returned successfully",200);
    }

    public function show($id){
        $cats = Category::find($id);
        if ($cats){
            return $this->ApiResponse($cats,"data returned successfully",200);     
        }
        return $this->ApiResponse(null,"not found",401);     
    }
}
