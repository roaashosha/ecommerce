<?php

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\GoogleController;
use App\Http\Controllers\api\NotificationController;
use App\Http\Controllers\api\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\api\RateController;
use App\Http\Controllers\Api\UserController;
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
    Route::post('/change-password',[AuthController::class,'changePassword']);
    Route::post('/send-otp', [AuthController::class, 'sendOtp']);
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
    Route::get('/user-profile',[AuthController::class,'userProfile']);
    Route::post('/user-profile/{id}',[UserController::class,'updateProfile']);
    Route::get('/user-data/{id}',[UserController::class,'getUserData']);
    Route::post('/user/{id}/set-photo',[UserController::class,'setPhoto']);
    Route::post('/user/delete',[UserController::class,'deleteUser']);
    Route::post('/user/update-language',[UserController::class,'setLanguage']);
//     Route::post('/notification-create', [NotificationController::class, 'create']); 
//     Route::get('/notifications', [NotificationController::class, 'list']);   
//     Route::post('/save-device-token',[NotificationController::class,'saveDeviceToken']);
});

Route::get('/home-products',[ProductController::class,'HomePageProducts']);
Route::get('/products/filter',[ProductController::class,'allProducts']);
Route::get('/products/{id}',[ProductController::class,'show']);
Route::get('/category/{id}/products',[ProductController::class,'getProductByCategoryGender']);
Route::get('/related-products/{id}',[ProductController::class,'relatedProducts']);

Route::get('/orders/{id?}',[OrderController::class,'userOrders']);
Route::get('/orders/{id}/items',[OrderController::class,'orderItems']);
Route::post('/order-submit', [OrderController::class, 'submitOrder']);

Route::get('/cart/{id}',[CartController::class,'cartDetails']);
Route::get('/cart/{id}/items',[CartController::class,'cartItems']);
Route::post('/cart/{id}/product-add',[CartController::class,'addItem']);
Route::delete('cart/{id}/product-delete/{productId}',[CartController::class,'deleteItem']);
// Route::post('/cart/{id}/select-cart-items', [CartController::class, 'selectItems']);
Route::put('/cart/{cartId}/product-update/{productId}', [CartController::class, 'updateQuantity']);

Route::get('/faq',[PageController::class,'faq']);
Route::get('/about-us',[PageController::class,'aboutUs']);
Route::get('/legal',[PageController::class,'legal']);
Route::get('/contacts',[PageController::class,'contacts']);

Route::get('/address/{id}',[AddressController::class,'userAddress']);
Route::post('/add-address/{id}',[AddressController::class,'addAddress']);


Route::post('/checkout/login',[AuthController::class,'login']);
Route::post('/guest',[AuthController::class,'guestLogin'])->withoutMiddleware('auth:api');


Route::get('/favorites/products', [FavoriteController::class, 'getFavoriteProductByCategory']);
Route::post('/favorites/add', [FavoriteController::class, 'addFavorite']);
Route::post('/favorites/delete', [FavoriteController::class, 'deleteFavorite']);

Route::post('/notification-create', [NotificationController::class, 'create']); 
Route::get('/notifications', [NotificationController::class, 'list']);   
Route::post('/save-device-token',[NotificationController::class,'saveDeviceToken']);
Route::post('/test-send-notification',[NotificationController::class,'testSendNotification']); 

Route::post('/review-create', [ReviewController::class, 'store']); 
Route::get('/reviews/{productId}', [ReviewController::class, 'productReviews']);
Route::put('/review/{id}/update',[ReviewController::class,'updateReview']);
Route::delete('/review/{id}/delete',[ReviewController::class,'destroyReview']);



Route::post('/rate-create', [RateController::class, 'store']); 
Route::get('/rate/{productId}', [RateController::class, 'productRates']);
Route::get('/rate-stats/{productId}', [RateController::class, 'rateStats']);
Route::put('/rate/{id}/update',[RateController::class,'updateRate']);
Route::delete('/rate/{id}/delete',[RateController::class,'destroyRate']);



Route::get('/google', [GoogleController::class, 'redirect']);
Route::get('/google/callback', [GoogleController::class, 'callback']);
Route::post('/google/mobile', [GoogleController::class, 'mobileLogin']);
