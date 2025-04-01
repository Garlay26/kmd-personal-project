<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\OutcomeController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\TownshipController;
use App\Http\Controllers\DeliveryTimeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();
// Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
Route::get('/privacy-policy',function(){
  return view('auth/policy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('index');

    //Brand
    Route::get('/brands', [BrandController::class, 'index'])->name('brands');
    Route::get('/brand/create', [BrandController::class, 'create'])->name('brand-create');
    Route::post('/brand/store', [BrandController::class, 'store'])->name('brand-store');
    Route::get('/brand/edit/{id}', [BrandController::class, 'edit'])->name('brand-edit');
    Route::post('/brand/update', [BrandController::class, 'update'])->name('brand-update');
    Route::post('/brand/delete', [BrandController::class, 'destroy'])->name('brand-delete');

    //Category
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
    Route::get('/category/create', [CategoryController::class, 'create'])->name('category-create');
    Route::post('/category/store', [CategoryController::class, 'store'])->name('category-store');
    Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->name('category-edit');
    Route::post('/category/update', [CategoryController::class, 'update'])->name('category-update');
    Route::post('/category/delete', [CategoryController::class, 'destroy'])->name('category-delete');

    //Banner
    Route::get('/banners', [BannerController::class, 'index'])->name('banners');
    Route::get('/banner/create', [BannerController::class, 'create'])->name('banner-create');
    Route::post('/banner/store', [BannerController::class, 'store'])->name('banner-store');
    Route::get('/banner/edit/{id}', [BannerController::class, 'edit'])->name('banner-edit');
    Route::post('/banner/update', [BannerController::class, 'update'])->name('banner-update');
    Route::post('/banner/delete', [BannerController::class, 'destroy'])->name('banner-delete');

    //Payment Method
    Route::get('/payment-methods', [PaymentMethodController::class, 'index'])->name('payment-methods');
    Route::get('/payment-method/create', [PaymentMethodController::class, 'create'])->name('payment-method-create');
    Route::post('/payment-method/store', [PaymentMethodController::class, 'store'])->name('payment-method-store');
    Route::get('/payment-method/edit/{id}', [PaymentMethodController::class, 'edit'])->name('payment-method-edit');
    Route::post('/payment-method/update', [PaymentMethodController::class, 'update'])->name('payment-method-update');
    Route::post('/payment-method/delete', [PaymentMethodController::class, 'destroy'])->name('payment-method-delete');

    //Customer
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers');
    Route::get('/customer/detail/{id}', [CustomerController::class, 'show'])->name('customer-detail');
    Route::post('/customer/ban', [CustomerController::class, 'ban'])->name('customer-ban');
    Route::post('/customer/unban', [CustomerController::class, 'unban'])->name('customer-unban');

   //Product
   Route::get('/products', [ProductController::class, 'index'])->name('products');
   Route::get('/product/detail/{id}', [ProductController::class, 'getProductDetail'])->name('product-detail');
   Route::get('/product/create', [ProductController::class, 'create'])->name('product-create');
   Route::post('/product/store', [ProductController::class, 'store'])->name('product-store');
   Route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('product-edit');
   Route::post('/product/update', [ProductController::class, 'update'])->name('product-update');
   Route::post('/product/delete', [ProductController::class, 'destroy'])->name('product-delete');

    //Order
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::get('/order/create', [OrderController::class, 'create'])->name('order-create');
    Route::post('/order/store', [OrderController::class, 'store'])->name('order-store');
    Route::get('/order/detail/{id}', [OrderController::class, 'show'])->name('order-detail');
    Route::post('/order/cancel', [OrderController::class, 'cancel'])->name('order-cancel');
    Route::post('/order/approve', [OrderController::class, 'approve'])->name('order-approve');
    Route::get('/order/print', [OrderController::class, 'print'])->name('order-print');

     //Income
     Route::get('/incomes', [IncomeController::class, 'index'])->name('incomes');
     Route::get('/income/create', [IncomeController::class, 'create'])->name('income-create');
     Route::post('/income/store', [IncomeController::class, 'store'])->name('income-store');
     Route::get('/income/edit/{id}', [IncomeController::class, 'edit'])->name('income-edit');
     Route::post('/income/update', [IncomeController::class, 'update'])->name('income-update');
     Route::post('/income/delete', [IncomeController::class, 'destroy'])->name('income-delete');

     //Outcome
     Route::get('/outcomes', [OutcomeController::class, 'index'])->name('outcomes');
     Route::get('/outcome/create', [OutcomeController::class, 'create'])->name('outcome-create');
     Route::post('/outcome/store', [OutcomeController::class, 'store'])->name('outcome-store');
     Route::get('/outcome/edit/{id}', [OutcomeController::class, 'edit'])->name('outcome-edit');
     Route::post('/outcome/update', [OutcomeController::class, 'update'])->name('outcome-update');
     Route::post('/outcome/delete', [OutcomeController::class, 'destroy'])->name('outcome-delete');

     //Country
     Route::get('/countries', [CountryController::class, 'index'])->name('countries');
     Route::get('/country/create', [CountryController::class, 'create'])->name('country-create');
     Route::post('/country/store', [CountryController::class, 'store'])->name('country-store');
     Route::get('/country/edit/{id}', [CountryController::class, 'edit'])->name('country-edit');
     Route::post('/country/update', [CountryController::class, 'update'])->name('country-update');
     Route::post('/country/delete', [CountryController::class, 'destroy'])->name('country-delete');

    //State
     Route::get('/states', [StateController::class, 'index'])->name('states');
     Route::get('/state/create', [StateController::class, 'create'])->name('state-create');
     Route::post('/state/store', [StateController::class, 'store'])->name('state-store');
     Route::get('/state/edit/{id}', [StateController::class, 'edit'])->name('state-edit');
     Route::post('/state/update', [StateController::class, 'update'])->name('state-update');
     Route::post('/state/delete', [StateController::class, 'destroy'])->name('state-delete');

      //Township
      Route::get('/townships', [TownshipController::class, 'index'])->name('townships');
      Route::get('/township/create', [TownshipController::class, 'create'])->name('township-create');
      Route::post('/township/store', [TownshipController::class, 'store'])->name('township-store');
      Route::get('/township/edit/{id}', [TownshipController::class, 'edit'])->name('township-edit');
      Route::post('/township/update', [TownshipController::class, 'update'])->name('township-update');
      Route::post('/township/delete', [TownshipController::class, 'destroy'])->name('township-delete');

      //Delivery Time
      Route::get('/delivery-times', [DeliveryTimeController::class, 'index'])->name('deliverytimes');
      Route::get('/delivery-time/create', [DeliveryTimeController::class, 'create'])->name('delivery-time-create');
      Route::post('/delivery-time/store', [DeliveryTimeController::class, 'store'])->name('delivery-time-store');
      Route::get('/delivery-time/edit/{id}', [DeliveryTimeController::class, 'edit'])->name('delivery-time-edit');
      Route::post('/delivery-time/update', [DeliveryTimeController::class, 'update'])->name('delivery-time-update');
      Route::post('/delivery-time/delete', [DeliveryTimeController::class, 'destroy'])->name('delivery-time-delete');

      //Admin
      Route::get('/admins', [AdminController::class, 'index'])->name('admins');
      Route::get('/admin/create', [AdminController::class, 'create'])->name('admin-create');
      Route::post('/admin/store', [AdminController::class, 'store'])->name('admin-store');
      Route::get('/admin/edit/{id}', [AdminController::class, 'edit'])->name('admin-edit');
      Route::post('/admin/update', [AdminController::class, 'update'])->name('admin-update');
      Route::post('/admin/delete', [AdminController::class, 'destroy'])->name('admin-delete');

      //Report
      Route::get('/profit-loss', [ReportController::class, 'profitLoss'])->name('profit-loss');

      //Testing Purpose
      Route::get('/print-barcode', 'App\Http\Controllers\BarcodeController@index')->name('print-barcode');

      //Notifications
      Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
      Route::post('/notification/delete', [NotificationController::class, 'destroy'])->name('noti-delete');
      Route::post('/notification/store', [NotificationController::class, 'store'])->name('noti-store');

      Route::get('/optimize-image', 'App\Http\Controllers\BarcodeController@optimize')->name('optimize-image');

    //Cashier
    Route::get('/cashiers', [CashierController::class, 'index'])->name('cashiers');
    Route::get('/cashier/create', [CashierController::class, 'create'])->name('cashier-create');
    Route::post('/cashier/store', [CashierController::class, 'store'])->name('cashier-store');
    Route::get('/cashier/edit/{id}', [CashierController::class, 'edit'])->name('cashier-edit');
    Route::post('/cashier/update', [CashierController::class, 'update'])->name('cashier-update');
    Route::post('/cashier/delete', [CashierController::class, 'destroy'])->name('cashier-delete');
});

