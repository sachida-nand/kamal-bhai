<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CatagoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\frontEnd\FHomeController;
use App\Http\Controllers\frontEnd\CartController;
use App\Http\Controllers\frontEnd\CheckoutController;
use App\Http\Controllers\frontEnd\EsewaPaymentVarifyController;
use App\Http\Controllers\frontEnd\OrdersController;
use App\Http\Controllers\FrontEnd\ProductReviewController;
use App\Http\Controllers\FrontEnd\SupportTicketController;
use App\Http\Controllers\frontEnd\UserController;

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

Route::get('/', function () {
    return view('auth/login');
});

Route::middleware(['middleware' => 'preventBackHistory'])->group(function () {
    Auth::routes();
});

// Route::view('card', 'frontEnd/addToCart')->name('cart');

Route::get('checking-helper-function', function(){
     foreach(userAddress() as $add){
        echo $add->user_id;
     }
});

Route::get('ss', function () {
    return view('emails.confirmOrderEmail');
});

// All admin related route 
Route::group(['middleware' => ['auth', 'isAdmin', 'preventBackHistory']], function() {
    Route::get('dashboard',[HomeController::class, 'index'])->name('admin.dashboard');
    //####### catagorie related route ####################
    Route::get('catagorie', [CatagoryController::class, 'index']);
    Route::get('catagorie/edit/{id}', [CatagoryController::class, 'index']);
    Route::post('manage-catagorie', [CatagoryController::class, 'manageCatagorie'])->name('addAndUpdateCatagorie');
    Route::get('catagorie-delete/{id}', [CatagoryController::class, 'deleteCatagorie']);
    Route::get('catagorie-status/{type}/{opration}/{id}', [CatagoryController::class, 'changeStatusOfTheCatagory']);
    Route::post('remove-catagorie-image', [CatagoryController::class, 'removeCatagorieImage'])->name('removeCatagorieImage');
    //####### Brand related route ####################
    Route::get('brand', [BrandController::class, 'index']);
    Route::get('brand/edit/{id}', [BrandController::class, 'index']);
    Route::post('manage-brand', [BrandController::class, 'manageBrand'])->name('addAndUpdateBrand');
    Route::get('brand-delete/{id}', [BrandController::class, 'deleteBrand']);
    Route::get('brand-status/{type}/{opration}/{id}', [BrandController::class, 'changeStatusOfTheBrand']);
    Route::post('remove-brand-image', [BrandController::class, 'removeBrandImage'])->name('removeBrandImage');
    //####### Product related route ####################
    Route::get('product', [ProductController::class, 'index']);
    Route::get('product/edit/{id}', [ProductController::class, 'index']);
    Route::post('manage-product', [ProductController::class, 'manageProduct'])->name('addAndUpdateProduct');
    Route::get('product-delete/{id}', [ProductController::class, 'deleteProduct']);
    Route::post('change-is-featured-product-status', [ProductController::class, 'changeIsFeaturedStatus'])->name('updateIsFeaturedProductAjax');
    Route::post('change-is-trending-product-status', [ProductController::class, 'changeIsTrendingStatus'])->name('updateIsTrendingProduxctAjax');
    Route::post('change-is-todayDeal-product-status', [ProductController::class, 'changeIsTodayDealStatus'])->name('updateIsTodayDealProduxctAjax');
    Route::post('change-product-published-status', [ProductController::class, 'changePublishedStatus'])->name('changePublishedStatusAjax');
    Route::get('product-status/{type}/{opration}/{id}', [ProductController::class, 'changeStatusOfTheProduct']);
    Route::post('remove-product-image', [ProductController::class, 'removeProductImageAjax'])->name('removeProductImageAjax');
    // auto slug generate
    Route::get('set-slug', [HomeController::class, 'setSlug'])->name('setSlug');
    Route::get('Orders-received', [OrderController::class, 'index']);
});

// All user and frontend related routes 
Route::group(['middleware'=> ['auth','isUser','preventBackHistory']], function(){
    Route::post('checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('place-order', [CheckoutController::class, 'PlaceOrder'])->name('place-order');
    Route::get('varify-eSewa-payment/{response}', [EsewaPaymentVarifyController::class, 'VarifyPayment']);
    Route::get('order-history', [OrdersController::class, 'index']);
    Route::get('order-details/{type}={id}', [OrdersController::class, 'SingleOrder']);
    Route::post('cancel-user-order', [OrdersController::class, 'CancelOrder'])->name('cancel.order');
    Route::get('your-account', function (){return view('frontEnd.accountD');});
    Route::post('add-new-address', [UserController::class, 'AddNewAddressAjax'])->name('addNewAddAjax');
    Route::post('remove-address-ajax', [UserController::class, 'RemoveAddressAjax'])->name('removeAddressAjax');
    Route::get('your-address', function(){ return view('frontEnd.userAddress');});
    Route::get('your-address/add-your-address', [UserController::class, 'index']);
    Route::get('your-address/edit-your-address/{id}', [UserController::class, 'index']);
    Route::post('your-address/manage-your-address', [UserController::class, 'AddNewAddress'])->name('add.address');
    Route::get('product-review', [ProductReviewController::class, 'index']);
    Route::get('product-review/for_product={slug}&order_id={id}', [ProductReviewController::class, 'ProductReview']);
    Route::post('manage-review',[ProductReviewController::class, 'ManageProductReview'])->name('manage.review');
    Route::get('product-review/delete-review/{id}', [ProductReviewController::class, 'DeleteReview']);
    Route::get('support-ticket', [SupportTicketController::class, 'index']);
    Route::post('create-ticket', [SupportTicketController::class, 'CreateTicket'])->name('create.ticket');
    Route::get( 'reply-support-ticket/ticket_number={ticket_id}', [SupportTicketController::class, 'ShowReplySupportTicket']);
    Route::post('reaply-support-ticket-message', [SupportTicketController::class, 'ReaplyTicketMessage'])->name('ticket.message.reaply');
    Route::get('download_ticket_file/{name}', [SupportTicketController::class, 'DownloadFile'])->name('download_ticket_file');
    Route::get('login-and-security', function(){return view('frontEnd.loginAndSecurity');});
    Route::get('security-action/{url_type}', [UserController::class, 'LoginAndSecurity']);
    Route::post('security-update', [UserController::class, 'UpdateUserDetails'])->name('update.usercredential');
    Route::post('update-user-profile-pic', [UserController::class, 'UpdateProfilePicAjax'])->name('updateProfilePicAjax');
});


// frontEnd related Routes 
Route::get('/', [FHomeController::class, 'index'])->name('user.dashboard');
Route::get('catagorie/{cata_url}', [FHomeController::class, 'ByCatagorie']);
Route::get('brand/{brand_url}', [FHomeController::class, 'ByBrand']);
Route::get('op/{url}', [FHomeController::class, 'DealsAndFeature']);
Route::get('product/{url}', [FHomeController::class, 'SingleProduct']);
Route::post('add-to-cart', [CartController::class, 'AddToCart']);
Route::get('cart/{url}', [CartController::class, 'DisplayCartItem']);
Route::get('add-cookie-shoping-item-to-db', [CartController::class, 'AddShoppingCartItemCookieToDatabase']);
Route::get('count-cart-item', [CartController::class, 'CountCartItem']);
Route::get("update_cart_qty", [CartController::class, 'UpdateCartQty']);
Route::delete('delete-cart-item', [CartController::class, 'DeleteCartItem']);


// Route::get('/home', [App\Http\Controllers\HomeController::class, 'home'])->name('home');
