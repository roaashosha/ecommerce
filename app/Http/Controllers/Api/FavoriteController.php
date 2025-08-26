<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    use ApiResponseTrait;
    public function getFavoriteProductByCategory(Request $request){
        $user = auth()->user();
        if (!$user){
            return $this->ApiResponse(null,"Unauthenticated",401);
        }
        $request->validate([
            'category_id'=>"required|exists:categories,id"
        ]);

        $categoryId = $request->query('category_id');
        $products = Product::whereHas('favorites', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->where('category_id', $categoryId)
        ->get();
        if ($products->isEmpty()) {
        return response()->json([
            'data' => null,
            'message' => 'No favorite products found in this category',
            'status' => 404
        ]);
    }

        return $this->ApiResponse(ProductResource::collection($products),"Favorite Products returned successfully!",200);

    }

    public function addFavorite(Request $request){
        $user = auth()->user();
        if (!$user){
            return $this->ApiResponse(null,"Unauthenticated",401);
        }

        $request->validate([
            'product_id'=>"required|exists:products,id"
        ]);

        $productId = $request->product_id;
        $exists = Favorite::where('user_id',$user->id)->where('product_id',$productId)->exists();
        if ($exists){
            return $this->ApiResponse(null,"Product is already in favorites!",400);
        }
        $favorite = Favorite::create([
            'user_id'=>$user->id,
            'product_id'=>$productId   
        ]);

        return $this->ApiResponse($favorite,"Favorite Product is added successfully!",200);
    }

    public function deleteFavorite(Request $request){
        $user = auth()->user();
        if (!$user){
            return $this->ApiResponse(null,"Unauthenticated",401);
        }
        $productId = $request->product_id;
        $request->validate([
            'product_id'=>'required|exists:products,id'
        ]);

        $favorite = Favorite::where('user_id',$user->id)->where('product_id',$productId)->first();
        if (!$favorite){
            return $this->ApiResponse(null,'Product is not in favorites',404);
        }
        $favorite->delete();
        return $this->ApiResponse(null,"Product removed from favorites successfully!",200);
    }
}
