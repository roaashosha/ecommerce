<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckOutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\ContactController;
use App\Models\Contact;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('/categories/{id}/color/{color}',[CategoryController::class,'CatByColor']);
Route::get('/categories/{id}',[CategoryController::class,'show'])->name('user.cats.show');
Route::get('/categories/{id}/sort', [CategoryController::class, 'SortBy'])->name('categories.sort');
Route::get('/categories/{id}/{range}',[CategoryController::class,'catByRange']);
Route::get('/products/{id}',[ProductController::class,'show']);


Route::get('/login',[AuthController::class,'loginForm'])->name('login');
Route::post('/login',[AuthController::class,'login']);
Route::get('/signup',[AuthController::class,'signUpForm']);
Route::post('/signup',[AuthController::class,'sign']);

Route::post('/send-otp', [AuthController::class, 'sendOtp'])->name('send.otp');
Route::get('/verify-otp', [AuthController::class, 'verifyOtpForm'])->name('otp.form');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('otp.verify');


Route::get('/forget-password',[AuthController::class,'forgetPasswordForm'])->name('forget.password.form');
Route::post('/forget-password',[AuthController::class,'sendLink'])->name('sendLink');
Route::get('/reset-password',[AuthController::class,'resetForm'])->name('password.reset');
Route::post('/reset-password',[AuthController::class,'reset'])->name('password.update');

Route::get('/profile/{id}',[ProfileController::class,'index']);
Route::put('/profile/{id}',[ProfileController::class,'update']);
Route::get('/profile/{id}/orders',[OrderController::class,'index']);
Route::get('/orders/{id}/items',[OrderController::class,'orderDetails']);
Route::get('/address/{id}',[AddressController::class,'index']);
Route::post('/address/{id}', [AddressController::class, 'addNewAddress']);
Route::get('/change-password/{id}',[AuthController::class,'changePasswordIndex']);
Route::post('change-password/{id}',[AuthController::class,'changePassword']);


Route::get('/cart',[CartController::class,'index']);
Route::post('/cart',[CartController::class,'clear']);
Route::post('/cart/add/{id}',[CartController::class,'addToCart']);
Route::post('/cart/clear',[CartController::class,'addToCart']);

Route::get('/checkout',[CheckOutController::class,'index']);
Route::get('/submit',[CheckOutController::class],'submit');

Route::get('/about-us',[AboutUsController::class,'index']);
Route::get('/faq',[FAQController::class,'index']);
Route::get('/contact',[ContactController::class,'index']);
Route::post('/contact/send',[ContactController::class,'index']);




// Route::middleware(['auth'])->group(function(){
//     Route
// })
// Route::get('/',[ProductController::class,'index']);