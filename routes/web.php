<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\User\UserHomeController;
use App\Http\Controllers\User\UserProductController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\AddressController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\CarouselController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ManageCommentController;
use App\Http\Controllers\Admin\RevenueController;
use App\Http\Controllers\User\CommentController;
use App\Http\Controllers\User\PaymentMethodController;
use App\Http\Controllers\User\UserOrderController;
use App\Http\Controllers\User\Payment_Method\PayPalController;
use App\Http\Controllers\User\Payment_Method\VnPayController;
use App\Http\Controllers\User\ProfileController;

Route::get('/register',[RegisterController::class,'index']);
Route::post('/register',[RegisterController::class,'register']);
Route::get('/verify-otp', [RegisterController::class, 'showVerifyOtpForm'])->name('verifyOtpForm');
Route::post('/verify-otp', [RegisterController::class, 'verifyOtp'])->name('verifyOtp');

Route::get('/login',[LoginController::class,'index'])->name("login");
Route::post('/login',[LoginController::class,'login']);

Route::get('/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

Route::get('/',[HomeController::class,'index'])->name('client.home');
Route::get('/product',[HomeController::class,'product']);
Route::get('/show/{id}',[HomeController::class,'show']);
Route::get('/about_us',[HomeController::class,'aboutus']);
Route::get('/search',[HomeController::class,'search'])->name('search');
Route::get('/contact_us',[HomeController::class,'contactus']);

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index']);

    Route::prefix('/admin')->group(function(){

        Route::get('/dashboard', [DashboardController::class, 'index']);

        Route::prefix('/product')->group(function(){
            Route::get('/index', [ProductController::class, 'index'])->name('admin.product.index');
            Route::get('/{id}/details', [ProductController::class, 'showProductDetails'])->name('admin.product.details');
            Route::get('/create', [ProductController::class, 'create']);
            Route::post('/create', [ProductController::class, 'store']);
            Route::get('/edit/{id}', [ProductController::class, 'edit']);
            Route::post('/edit/{id}', [ProductController::class, 'update']);
            Route::get('/delete/{id}', [ProductController::class, 'delete']);
            Route::get('/search', [ProductController::class, 'search']);
            Route::post('/search', [ProductController::class, 'searchFullText']);

        });

        Route::prefix('/account')->group(function(){
            Route::get('/index', [AccountController::class, 'index'])->name('admin.account.index');
            Route::get('/{id}', [AccountController::class, 'show'])->name('admin.account.show');
            Route::get('/edit/{id}', [AccountController::class, 'edit'])->name('admin.account.edit');
            Route::post('/update/{id}', [AccountController::class, 'update'])->name('admin.account.update');
            Route::get('/lock/{id}', [AccountController::class, 'lock'])->name('admin.account.lock');
            Route::get('/delete/{id}', [AccountController::class, 'destroy'])->name('admin.account.delete');
        });

        Route::prefix('/carousel')->group(function(){
            Route::get('/index', [CarouselController::class, 'index'])->name('admin.carousel.index');
            Route::get('/create', [CarouselController::class, 'create']);
            Route::post('/create', [CarouselController::class, 'store']);
            Route::get('/edit/{id}', [CarouselController::class, 'edit']);
            Route::post('/edit/{id}', [CarouselController::class, 'update']);
            Route::get('/delete/{id}', [CarouselController::class, 'delete']);
        });

        Route::prefix('/order')->group(function(){
            Route::get('/index', [OrderController::class, 'index'])->name('admin.order.index');
            Route::get('/{id}', [OrderController::class, 'show'])->name('admin.order.show');
            Route::put('/{orderId}/update-status', [OrderController::class, 'updateStatus'])->name('admin.order.updateStatus');
        });

        Route::prefix('/revenue')->group(function(){
            Route::get('/index', [RevenueController::class, 'index'])->name('admin.revenue.index');
            Route::get('revenue/details/{period}/{id}', [RevenueController::class, 'showDetails'])->name('admin.revenue.details');


        });

        Route::prefix('/manage_comment')->group(function(){
            Route::get('/index', [ManageCommentController::class, 'index'])->name('admin.manage_comment.index');
            Route::get('/edit/{id}', [ManageCommentController::class, 'edit'])->name('admin.manage_comment.edit');
            Route::post('/edit/{id}', [ManageCommentController::class, 'update'])->name('admin.manage_comment.update');
            Route::get('/delete/{id}', [ManageCommentController::class, 'destroy'])->name('admin.manage_comment.delete');
            //Route::get('/show/{id}', [ManageCommentController::class, 'show'])->name('admin.manage_comment.show');

        });
        
    });
});

Route::middleware(['auth'])->group(function () {

    Route::prefix('/user')->group(function(){

        Route::get('/userhome', [UserHomeController::class, 'index'])->name("home");
        Route::get('/product',[UserProductController::class,'index'])->name("product");
        Route::get('/details/{id}',[UserHomeController::class,'details']);
        Route::post('/details/{id}/comment', [CommentController::class, 'store'])->name('comment.store');
        Route::get('/about_us',[UserHomeController::class,'aboutus']);
        Route::get('/contact_us',[UserHomeController::class,'contactus']);
        Route::get('/search',[UserHomeController::class,'search'])->name('user.search');
        Route::post('/save-address', [AddressController::class, 'store'])->name('save-address');
        Route::post('/update-address', [AddressController::class, 'update'])->name('update-address');

        Route::prefix('/cart')->group(function(){
            Route::post('/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
            Route::get('/', [CartController::class, 'viewCart'])->name('cart.view');
            Route::post('/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
            Route::post('/update/{id}', [CartController::class, 'updateCart'])->name('cart.update');
            Route::post('/save-selected', [CartController::class, 'saveSelected'])->name('cart.saveSelected');
            Route::post('/cart/buyNow/{id}', [CartController::class, 'buyNow'])->name('cart.buyNow');

        });

        Route::prefix('/profile')->group(function(){
            Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::post('/update', [ProfileController::class, 'update'])->name('profile.update');
            Route::post('/update_password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
        });

        Route::prefix('/checkout')->group(function(){
            Route::post('/',[CheckoutController::class,'viewCheckout'])->name('checkout.view');
            Route::get('/',[CheckoutController::class,'viewSavedCheckout']);
        });

        Route::prefix('/order')->group(function(){
            Route::get('/',[UserOrderController::class,'index'])->name('order.index');
            Route::post('/',[UserOrderController::class,'placeOrder'])->name('order.place');
            Route::get('/success', [UserOrderController::class, 'orderSuccess'])->name('order.success');
            Route::post('/{orderId}/cancel', [UserOrderController::class, 'cancel'])->name('order.cancel');
            Route::get('/details/{id}',[UserOrderController::class,'order_show'])->name('order.show');

        });

        Route::prefix('/payment_method')->group(function(){

            //thanh toan bang vnpay
            Route::get('/vnpay',[PaymentMethodController::class,'vnpay']);
            Route::post('/vnpay/vnpay-payment', [VnPayController::class, 'payment'])->name('vnpay.payment');
            Route::get('/vnpay/vnpay-callback', [VnPayController::class, 'callback'])->name('vnpay.callback');

            Route::get('/credit_card',[PaymentMethodController::class,'credit_card']);
            //thanh toan bang paypal 
            Route::get('/paypal',[PaymentMethodController::class,'paypal']);
            Route::post('paypal/payment/create', [PaypalController::class, 'payment'])->name('paypal.payment');
            Route::get('paypal/payment/success', [PaypalController::class, 'paymentSuccess'])->name('paypal.payment.success');
            Route::get('paypal/payment/cancel', [PaypalController::class, 'paymentCancel'])->name('paypal.payment.cancel');

        });

    });

    
    Route::post('/user/save-address', [AddressController::class, 'store'])->name('save-address');
    Route::post('/user/update-address', [AddressController::class, 'update'])->name('update-address');


});

