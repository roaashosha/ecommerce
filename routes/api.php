<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\CartController as ControllersCartController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


// Route::get('/',[HomeController::class,'index']);



// Route::middleware(['jwt.verify'])->group(function (){
    Route::get('/categories',[CategoryController::class,'index']);
    Route::get('/category/{id}',[CategoryController::class,'show']);
    Route::post('/categories',[CategoryController::class,'store']);
    Route::post('/category/{id}',[CategoryController::class,'update']);
    Route::post('/categories/{id}',[CategoryController::class,'destroy']);
// });

Route::group([
    "middleware"=>"api",
    "prefix"=>"auth"
], function (){
    Route::post('/login',[AuthController::class,'login']);
    Route::post('register',[AuthController::class,'register']);
    Route::post('/logout',[AuthController::class,'logout']);
    Route::post('/refresh',[AuthController::class,'refresh']);
    Route::get('/user-profile',[AuthController::class,'userProfile']);
});

Route::get('/home-products',[ProductController::class,'HomePageProducts']);
Route::get('/products/filter',[ProductController::class,'allProducts']);
Route::get('/products/{id}',[ProductController::class,'show']);
Route::get('/related-products/{id}',[ProductController::class,'relatedProducts']);


Route::get('/orders/{id?}',[OrderController::class,'userOrders']);
Route::get('/orders/{id}/items',[OrderController::class,'orderItems']);

Route::get('/cart/{id}',[CartController::class,'cartDetails']);
Route::get('/cart/{id}/items',[CartController::class,'cartItems']);

Route::get('/faq',[PageController::class,'faq']);
Route::get('/about-us',[PageController::class,'aboutUs']);