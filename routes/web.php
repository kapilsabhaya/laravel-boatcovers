<?php

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MakeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\YearController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ModelController;
use App\Http\Controllers\NavbarController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\MyOrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrainTreeController;
use App\Http\Controllers\ProductFaqController;
use App\Http\Controllers\CategoryFaqController;
use App\Http\Controllers\OptionValueController;
use App\Http\Controllers\MakeModelYearController;
use App\Http\Controllers\DisplayProductController;
use App\Http\Controllers\MasterCategoryController;
use App\Http\Controllers\AssignMakeModelController;

require __DIR__.'/auth.php';

Route::middleware(['auth:admin','verified'])->group(function() 
{
    Route::prefix('admin')->group(function() 
    { 
        Route::get('dashboard',[AdminController::class,'index'])->name('admin_dashboard');
        Route::resource('masterCategory',MasterCategoryController::class);
        Route::resource('category',CategoryController::class);  
        Route::resource('user',UserController::class);
        Route::resource('make',MakeController::class);
        Route::resource('model',ModelController::class);
        Route::resource('year',YearController::class);
        Route::resource('assignMakeModel',AssignMakeModelController::class);
        Route::resource('option',OptionController::class);
        Route::resource('optionValue',OptionValueController::class);
        Route::resource('product',ProductController::class);
        Route::resource('setting',SettingController::class);
        Route::resource('categoryFaq',CategoryFaqController::class);
        Route::resource('productFaq',ProductFaqController::class);
        Route::post('getOptionValue/{id}',[ProductController::class,'getOptionValue'])->name('getOptionValue');
        Route::get ('/getSlug' , function(Request $request){
            $slug = '';
            if(!empty($request->title)) {
                $slug = Str::slug($request->title);
            }
            return response()->json([
                'status' => true,
                'slug' => $slug
            ]);
        })->name('getSlug');

    });
});

Route::middleware('user')->group(function () {
    Route::get('/', function () { return view('dashboard'); })->name('dashboard');
    Route::get('getSubCategory/{id}',[NavbarController::class,'getSubCategory'])->name('getSubCategory');
    Route::prefix('pages')->get('/{slug}',[HomeController::class,'handleSlug'])->name('handleSlug');
    Route::get('getYear/{id}' ,[HomeController::class,'getYear'])->name('getYear');
    Route::get('getModel/{makeId}/{catId}' ,[HomeController::class,'getModel'])->name('getModel');
    Route::get('collections/{make}/{model}/{year}',[DisplayProductController::class,'getProduct'])->name('getProduct');
    Route::get('products/{slug}',[DisplayProductController::class,'singleProduct'])->name('singleProduct');
    Route::get('addToCart',[CartController::class,'addToCart'])->name('addToCart');
    Route::get('updateCart',[CartController::class,'updateCart'])->name('updateCart');
    Route::get('cart',[CartController::class,'cartView'])->name('cartView');
    Route::get('checkout/',[CartController::class,'checkout'])->name('checkout');
    Route::get('/page/{param}',[DisplayProductController::class,'subCatPatio'])->name('subCatPatio');
    Route::post('price_increment',[DisplayProductController::class,'price_increment'])->name('price_increment');
    Route::get('/myorder',[MyOrderController::class,'myOrder'])->name('myOrder');
    Route::get('orderReceipt/{orderId}/{productId}',[MyOrderController::class,'orderReceipt'])->name('orderReceipt');
    Route::post('validateData',[PayPalController::class,'validateData'])->name('validateData');
    Route::any('payment/paypal',[PayPalController::class,'paypal'])->name('paypal');
    Route::get('success',[PayPalController::class,'success'])->name('success');
    Route::get('cancel',[PayPalController::class,'cancel'])->name('cancel');
    Route::any('/payment', [BrainTreeController::class, 'token'])->name('token');
    Route::post('/processData',[BrainTreeController::class,'processData'])->name('processData');
    Route::any('/stripe',[StripeController::class,'stripe'])->name('stripe');
    Route::get('/StripeSuccess',[StripeController::class,'success'])->name('stripe.success');
    Route::get('/StripeCancel',[StripeController::class,'cancel'])->name('stripe.cancel');

    Route::fallback(function () {
        return redirect()->route('dashboard');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

