<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
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
use App\Http\Controllers\User\CommentController;
use App\Http\Controllers\User\PaymentMethodController;
use App\Http\Controllers\User\UserOrderController;
use App\Http\Controllers\User\Payment_Method\PayPalController;

Route::get('/register',[RegisterController::class,'index']);
Route::post('/register',[RegisterController::class,'register']);
Route::get('/verify-otp', [RegisterController::class, 'showVerifyOtpForm'])->name('verifyOtpForm');
Route::post('/verify-otp', [RegisterController::class, 'verifyOtp'])->name('verifyOtp');

Route::get('/login',[LoginController::class,'index'])->name("login");
Route::post('/login',[LoginController::class,'login']);

Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

Route::get('/',[HomeController::class,'index']);

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index']);

    Route::prefix('/admin')->group(function(){

        Route::get('/dashboard', [DashboardController::class, 'index']);

        Route::prefix('/product')->group(function(){
            Route::get('/index', [ProductController::class, 'index'])->name('admin.product.index');
            Route::get('/create', [ProductController::class, 'create']);
            Route::post('/create', [ProductController::class, 'store']);
            Route::get('/edit/{id}', [ProductController::class, 'edit']);
            Route::post('/edit/{id}', [ProductController::class, 'update']);
            Route::get('/delete/{id}', [ProductController::class, 'delete']);
            Route::get('/search', [ProductController::class, 'search']);
            Route::post('/search', [ProductController::class, 'searchFullText']);

        });

        Route::prefix('/account')->group(function(){
            Route::get('/index', [AccountController::class, 'index']);
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
            Route::get('/index', [OrderController::class, 'index']);
        });
    });
});

Route::middleware(['auth'])->group(function () {

    Route::prefix('/user')->group(function(){

        Route::get('/userhome', [UserHomeController::class, 'index'])->name("home");
        Route::get('/product',[UserProductController::class,'index']);
        Route::get('/details/{id}',[UserHomeController::class,'details']);
        Route::post('/details/{id}/comment', [CommentController::class, 'store'])->name('comment.store');

        Route::prefix('/cart')->group(function(){
            Route::post('/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
            Route::get('/', [CartController::class, 'viewCart'])->name('cart.view');
            Route::post('/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
            Route::post('/update/{id}', [CartController::class, 'updateCart'])->name('cart.update');
            Route::post('/save-selected', [CartController::class, 'saveSelected'])->name('cart.saveSelected');
            Route::post('/cart/buyNow/{id}', [CartController::class, 'buyNow'])->name('cart.buyNow');

        });

        Route::prefix('/checkout')->group(function(){
            Route::post('/',[CheckoutController::class,'viewCheckout'])->name('checkout.view');
            Route::get('/',[CheckoutController::class,'viewSavedCheckout']);
        });

        Route::prefix('/order')->group(function(){
            Route::get('/',[UserOrderController::class,'index']);
            Route::post('/',[UserOrderController::class,'placeOrder'])->name('order.place');
            Route::get('/success', [UserOrderController::class, 'orderSuccess'])->name('order.success');
        });

        Route::prefix('/payment_method')->group(function(){
            Route::get('/bank_transfer',[PaymentMethodController::class,'bank_transfer']);
            Route::get('/credit_card',[PaymentMethodController::class,'credit_card']);
            //thanh toan bang paypal 
            Route::get('/paypal',[PaymentMethodController::class,'paypal']);
            Route::post('/paypal/create-payment', [PaypalController::class, 'createPayment'])->name('paypal.create');
            Route::get('/paypal/success-payment', [PaypalController::class, 'paymentSuccess'])->name('paypal.paymnet.success');
            Route::get('/paypal/cancel-payment', [PaypalController::class, 'paymentCancel'])->name('paypal.payment.cancel');

        });



    });

    // Route::get('/user/userhome', [UserHomeController::class, 'index'])->name("home");
    // Route::get('/user/product',[UserProductController::class,'index']);
    // Route::get('/user/details/{id}',[UserHomeController::class,'details']);
    // Route::post('/user/details/{id}/comment', [CommentController::class, 'store'])->name('comment.store');

    // Route::post('/user/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    // Route::get('/user/cart', [CartController::class, 'viewCart'])->name('cart.view');
    // Route::post('/user/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    // Route::post('/user/cart/update/{id}', [CartController::class, 'updateCart'])->name('cart.update');
    // Route::post('/user/cart/save-selected', [CartController::class, 'saveSelected'])->name('cart.saveSelected');

    // Route::post('/user/checkout',[CheckoutController::class,'viewCheckout'])->name('checkout.view');
    // Route::get('/user/checkout',[CheckoutController::class,'viewSavedCheckout']);

    Route::post('/user/save-address', [AddressController::class, 'store'])->name('save-address');
    Route::post('/user/update-address', [AddressController::class, 'update'])->name('update-address');

    // Route::get('/user/order',[UserOrderController::class,'index']);
    // Route::post('/user/order',[UserOrderController::class,'placeOrder'])->name('order.place');
    // Route::get('/user/order/success', [UserOrderController::class, 'orderSuccess'])->name('order.success');

    

});

