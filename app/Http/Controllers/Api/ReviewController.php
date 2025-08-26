<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Http\Resources\ReviewResource;
class ReviewController extends Controller
{
    use ApiResponseTrait;
    public function store(Request $request){
        $request->validate([
            "product_id"=>"required|exists:products,id",
            "desc"=>"required|string|max:1000"
        ]);

        $user = auth()->user();
        if (!$user){
            return $this->ApiResponse(null."Unauthenticated",401);
        }

        $review = Review::Create([
            "user_id"=>$user->id,
            "product_id"=>$request->product_id,
            "desc"=>$request->desc
        ]);

        return $this->ApiResponse(new ReviewResource($review),"Review Created Succesfully!",200);
    }

    public function updateReview(Request $request,$reviewId){
        $request->validate([
            "desc"=>"required|string|max:1000"
        ]);
        $user = auth()->user();
        if (!$user){
            return $this->ApiResponse(null."Unauthenticated",401);
        }
        $review = Review::find($reviewId);
        if (!$review){
            return $this->ApiResponse(null,"Review is not found!",404);
        }
        if ($review->user_id !== $user->id){
            return $this->ApiResponse(null, "Unauthorized", 403);
        }

        $review->desc = $request->desc;
        $review->save();
        return $this->ApiResponse(new ReviewResource($review),"Review updated Succesfully!",200);



    }

    public function destroyReview($reviewId){
        $user = auth()->user();
        if (!$user){
            return $this->ApiResponse(null."Unauthenticated",401);
        }
        $review = Review::find($reviewId);
        if (!$review){
            return $this->ApiResponse(null,"Review is not found!",404);
        }
        if ($review->user_id !== $user->id){
            return $this->ApiResponse(null, "Unauthorized", 403);
        } 
        $review->delete();
          return $this->ApiResponse(null, "Review deleted successfully!", 200);

    }


    public function productReviews($productId){
        $reviews = Review::where("product_id",$productId)->with("user:id,first_name,last_name")->orderBy('created_at')->get();
         return $this->ApiResponse(ReviewResource::collection($reviews),"Review returned Succesfully!",200);        
    }
}
