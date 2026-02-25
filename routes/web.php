<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserLoginController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\SiteSettingController;
use App\Http\Controllers\GtmController;

use App\Http\Controllers\Frontend\{
    ProductViewController,
    CartController,
    OrderController,
    PaymentController,
    WishlistController,
    SearchController,
    CouponController as FrontendCouponController,
};
use App\Http\Controllers\Backend\{
    HomeController,
    OrderManageController,
    CategoryController,
    SubcategoryController,
    ColorController,
    SizeController,
    BrandController,
    UnitController,
    ProductController,
    ProductImportController,
    SpecialBannerController,
    AdditionalController,
    MessageController,
    SeconderyBannerController,
    SliderController,
    DeliveryChargeController,
    VideoSectionController,
    PopupController,
    ReviewController,
    CouponController,
    QuickCreateController,
    FlatDiscountController
};


// ===================================================================
// Unauthenticated Frontend Routes
// ===================================================================

Route::get('/', [IndexController::class, 'index'])->name('home');

Route::get('/product/details/{id}', [ProductViewController::class, 'productDetails'])->name('product.details');
Route::get('/category/products/{id}', [ProductViewController::class, 'categoryProducts'])->name('category.products');
Route::get('/subcategor/products/{id}', [ProductViewController::class, 'subCategoryProducts'])->name('subcategory.products');
Route::get('/brand/products/{id}', [ProductViewController::class, 'brandProducts'])->name('brand.products');

// User registration & login
Route::get('/user/register', [UserLoginController::class, 'userRegister'])->name('user.register');
Route::post('/store/register', [UserLoginController::class, 'storeRegister'])->name('store.register');
Route::get('/user/login', [UserLoginController::class, 'userLogin'])->name('user.login');

// Info pages
Route::get('/contact/us', [InfoController::class, 'contactUs'])->name('contact.us');
Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
Route::get('/about/us', [InfoController::class, 'aboutUs'])->name('about.us');
Route::get('/faq', [InfoController::class, 'faq'])->name('faq');

// Cart routes
Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');
Route::get('/cart/index', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::get('/cart/items', [CartController::class, 'fetchCartItems'])->name('cart.items');

// Shipping & Order routes
Route::get('/shipping', [OrderController::class, 'shipping'])->name('shipping');
Route::post('/store/order', [OrderController::class, 'store'])->name('store.order');
Route::get('/order/success/{orderNumber}', [OrderController::class, 'success'])->name('order.success');
Route::get('/order/{orderNumber}', [OrderController::class, 'show'])->name('order.show');
Route::get('/track-order', [OrderController::class, 'trackOrder'])->name('track.order');

// Coupon routes (frontend)
Route::post('/coupon/apply', [FrontendCouponController::class, 'apply'])->name('coupon.apply');
Route::post('/coupon/remove', [FrontendCouponController::class, 'remove'])->name('coupon.remove');

// Product quick view & search
Route::get('/product/quick-view/{id}', [ProductViewController::class, 'quickView'])->name('product.quickView');
Route::get('/live-search', [SearchController::class, 'liveSearch'])->name('live.search');
Route::get('get-delivery-charges', [DeliveryChargeController::class, 'getDeliveryCharges'])->name('delivery-charges.getCharges');

// AJAX auth routes (for wishlist auth modal)
Route::post('/ajax/login', [WishlistController::class, 'ajaxLogin'])->name('ajax.login');
Route::post('/ajax/register', [WishlistController::class, 'ajaxRegister'])->name('ajax.register');

// Payment callback routes
Route::post('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
Route::post('/payment/fail', [PaymentController::class, 'fail'])->name('payment.fail');
Route::post('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
Route::post('/payment/ipn', [PaymentController::class, 'ipn'])->name('payment.ipn');

// Static pages
Route::get('/privacy-policy', function () {
    return view('frontend.pages.privacy-policy');
})->name('privacy.policy');

Route::get('/terms-and-conditions', function () {
    return view('frontend.pages.terms-conditions');
})->name('terms.conditions');

Route::get('/shipping-policy', function () {
    return view('frontend.pages.shippingPolicy');
})->name('shipping.policy');

Route::get('/returns-exchanges', function () {
    return view('frontend.pages.returns');
})->name('returns.exchanges');

// Cancel order (requires auth)
Route::post('/orders/{id}/cancel', [UserController::class, 'cancelOrder'])
    ->name('user.orders.cancel')
    ->middleware('auth');

// Reviews (public)
Route::get('/reviews', [IndexController::class, 'reviews'])->name('reviews.index');


// ===================================================================
// Authenticated User Routes
// ===================================================================

Route::middleware('auth')->group(function () {

    // Password update
    Route::post('/new/password/update', [UserController::class, 'UpdateUserPassword'])->name('new.password.update');

    // User dashboard & profile
    Route::get('/user/dashboard', [UserController::class, 'userProfile'])->name('user.dashboard');
    Route::post('/user/user/profile/update', [UserController::class, 'UpdateUserProfile'])->name('user.profile.update');

    // Orders
    Route::get('/user/orders', [UserController::class, 'orders'])->name('user.orders');
    Route::get('/user/orders/{order}', [UserController::class, 'showOrder'])->name('user.orders.show');

    // Wishlist
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::get('/wishlist/check/{product}', [WishlistController::class, 'check'])->name('wishlist.check');
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');

    // Profile Management
    Route::get('/user/edit', [UserController::class, 'editProfile'])->name('user.edit');
    Route::put('/user/update', [UserController::class, 'updateProfile'])->name('user.update');
    Route::put('/user/password/update', [UserController::class, 'updatePassword'])->name('user.password.update');

    // Address Management
    Route::get('/user/addresses', [UserController::class, 'addresses'])->name('user.addresses');
    Route::post('/user/addresses/store', [UserController::class, 'storeAddress'])->name('user.addresses.store');
    Route::put('/user/addresses/{address}/update', [UserController::class, 'updateAddress'])->name('user.addresses.update');
    Route::delete('/user/addresses/{address}/delete', [UserController::class, 'deleteAddress'])->name('user.addresses.delete');
});


require __DIR__ . '/auth.php';


// ===================================================================
// Admin Routes (require auth + admin)
// ===================================================================

Route::group(['middleware' => ['auth', 'admin']], function () {

    // GTM
    Route::get('/gtm/create', [GtmController::class, 'create'])->name('gtm.create');
    Route::post('/gtm/store', [GtmController::class, 'store'])->name('gtm.store');
    Route::post('/gtm/update', [GtmController::class, 'update'])->name('gtm.update');
    Route::get('/gtm/index', [GtmController::class, 'index'])->name('gtm.index');

    // Reviews management
    Route::get('/review', [ReviewController::class, 'index'])->name('review.index');
    Route::get('/review/create', [ReviewController::class, 'create'])->name('review.create');
    Route::post('/review/store', [ReviewController::class, 'store'])->name('review.store');
    Route::get('/review/edit/{id}', [ReviewController::class, 'edit'])->name('review.edit');
    Route::post('/review/update/{id}', [ReviewController::class, 'update'])->name('review.update');
    Route::post('/review/delete/{id}', [ReviewController::class, 'delete'])->name('review.delete');
    Route::post('/review/update-status', [ReviewController::class, 'updateStatus'])->name('review.updateStatus');

    // Admin dashboard & users
    Route::get('/admin/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
    Route::get('/all/users', [HomeController::class, 'allUsers'])->name('all.users');
    Route::post('/delete/user/{id}', [HomeController::class, 'deleteUser'])->name('delete.users');
    Route::post('/user/change-role', [HomeController::class, 'changeUserRole'])->name('user.change.role');

    // Category
    Route::group(['prefix' => "category", 'as' => 'category.'], function () {
        Route::get('/manage', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/store', [CategoryController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('edit');
        Route::post('/update', [CategoryController::class, 'update'])->name('update');
        Route::post('/delete/{id}', [CategoryController::class, 'delete'])->name('delete');
        Route::post('/update-status', [CategoryController::class, 'updateStatus'])->name('updateStatus');
        Route::post('/update-featured', [CategoryController::class, 'updateFeatured'])->name('updateFeatured');
    });

    // Subcategory
    Route::group(['prefix' => "subcategory", 'as' => 'subcategory.'], function () {
        Route::get('/manage', [SubcategoryController::class, 'index'])->name('index');
        Route::get('/create', [SubcategoryController::class, 'create'])->name('create');
        Route::post('/store', [SubcategoryController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [SubcategoryController::class, 'edit'])->name('edit');
        Route::post('/update', [SubcategoryController::class, 'update'])->name('update');
        Route::post('/delete/{id}', [SubcategoryController::class, 'delete'])->name('delete');
        Route::post('/update-status', [SubcategoryController::class, 'updateStatus'])->name('updateStatus');
    });

    // Color
    Route::group(['prefix' => "color", 'as' => 'color.'], function () {
        Route::get('/manage', [ColorController::class, 'index'])->name('index');
        Route::get('/create', [ColorController::class, 'create'])->name('create');
        Route::post('/store', [ColorController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [ColorController::class, 'edit'])->name('edit');
        Route::post('/update', [ColorController::class, 'update'])->name('update');
        Route::post('/delete/{id}', [ColorController::class, 'delete'])->name('delete');
        Route::post('/update-status', [ColorController::class, 'updateStatus'])->name('updateStatus');
    });

    // Size
    Route::group(['prefix' => "size", 'as' => 'size.'], function () {
        Route::get('/manage', [SizeController::class, 'index'])->name('index');
        Route::get('/create', [SizeController::class, 'create'])->name('create');
        Route::post('/store', [SizeController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [SizeController::class, 'edit'])->name('edit');
        Route::post('/update', [SizeController::class, 'update'])->name('update');
        Route::post('/delete/{id}', [SizeController::class, 'delete'])->name('delete');
        Route::post('/update-status', [SizeController::class, 'updateStatus'])->name('updateStatus');
    });

    // Brand
    Route::group(['prefix' => "brand", 'as' => 'brand.'], function () {
        Route::get('/manage', [BrandController::class, 'index'])->name('index');
        Route::get('/create', [BrandController::class, 'create'])->name('create');
        Route::post('/store', [BrandController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [BrandController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [BrandController::class, 'update'])->name('update');
        Route::post('/delete/{id}', [BrandController::class, 'delete'])->name('delete');
        Route::post('/update-status', [BrandController::class, 'updateStatus'])->name('updateStatus');
    });

    // Unit
    Route::group(['prefix' => "unit", 'as' => 'unit.'], function () {
        Route::get('/manage', [UnitController::class, 'index'])->name('index');
        Route::get('/create', [UnitController::class, 'create'])->name('create');
        Route::post('/store', [UnitController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [UnitController::class, 'edit'])->name('edit');
        Route::post('/update', [UnitController::class, 'update'])->name('update');
        Route::post('/delete/{id}', [UnitController::class, 'delete'])->name('delete');
        Route::post('/update-status', [UnitController::class, 'updateStatus'])->name('updateStatus');
    });

    // Product
    Route::group(['prefix' => "product", 'as' => 'product.'], function () {
        Route::get('/list', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::get('/bulk/create', [ProductController::class, 'bulkCreate'])->name('bulk.create');
        Route::get('/get-subcategories/{categoryId}', [ProductController::class, 'getSubcategories'])->name('get.subcategories');
        Route::get('/view/details/{id}', [ProductController::class, 'ViewDetails'])->name('view.details');
        Route::post('/product/update-status/', [ProductController::class, 'updateStatus'])->name('updateStatus');
        Route::post('/product/update-featured/', [ProductController::class, 'updateFeatured'])->name('featuredUpdate');
        Route::post('/product/varient/update-status/', [ProductController::class, 'updateVarientStatus'])->name('varient.updateStatus');
        Route::post('/store', [ProductController::class, 'store'])->name('store');
        Route::post('/bulk/store', [ProductController::class, 'bulkStore'])->name('bulk.store');
        Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [ProductController::class, 'update'])->name('update');
        Route::post('/delete/{id}', [ProductController::class, 'delete'])->name('delete');
        Route::delete('/delete/gallery-image/{id}', [ProductController::class, 'deleteGalleryImage'])->name('delete.gallery-image');
        Route::post('/duplicate/{id}', [ProductController::class, 'duplicateProduct'])->name('duplicate');
        Route::delete('/delete/variant/{id}', [ProductController::class, 'deleteVariant'])->name('delete.variant');

        // CSV Import
        Route::get('/import', [ProductImportController::class, 'showImportForm'])->name('import');
        Route::post('/import/process', [ProductImportController::class, 'import'])->name('import.process');
        Route::get('/import/sample', [ProductImportController::class, 'downloadSample'])->name('import.sample');
    });

    // Quick Create (inline creation from product form)
    Route::prefix('quick-create')->name('quick.create.')->group(function () {
        Route::post('/category',    [QuickCreateController::class, 'storeCategory'])->name('category');
        Route::post('/subcategory', [QuickCreateController::class, 'storeSubcategory'])->name('subcategory');
        Route::post('/brand',       [QuickCreateController::class, 'storeBrand'])->name('brand');
        Route::post('/unit',        [QuickCreateController::class, 'storeUnit'])->name('unit');
        Route::post('/size',        [QuickCreateController::class, 'storeSize'])->name('size');
    });

    // Order Management
    Route::group(['prefix' => "order", 'as' => 'order.'], function () {
        Route::get('/manage/order', [OrderManageController::class, 'index'])->name('index');
        Route::get('/each/details/{id}', [OrderManageController::class, 'orderDetails'])->name('details');
        Route::post('/store', [OrderManageController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [OrderManageController::class, 'edit'])->name('edit');
        Route::post('/update', [OrderManageController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [OrderManageController::class, 'delete'])->name('delete');
        Route::post('/update-status', [OrderManageController::class, 'updateStatus'])->name('updateStatus');
        Route::post('/admin/orders/bulk-update-status', [OrderManageController::class, 'bulkUpdateStatus'])->name('bulkUpdateStatus');
        Route::post('/admin/orders/bulk-update-payment', [OrderManageController::class, 'bulkUpdatePayment'])->name('bulkUpdatePayment');
        Route::get('/invoice/{id}', [OrderManageController::class, 'invoice'])->name('invoice');
        Route::get('/download-pdf/{id}', [OrderManageController::class, 'downloadPDF'])->name('download-pdf');
        Route::post('/update-payment-status', [OrderController::class, 'updatePaymentStatus'])->name('updatePaymentStatus');
    });

    // Special Banner
    Route::group(['prefix' => 'special-banner', 'as' => 'special-banner.'], function () {
        Route::get('/', [SpecialBannerController::class, 'index'])->name('index');
        Route::post('/store', [SpecialBannerController::class, 'store'])->name('store');
        Route::post('/update-status', [SpecialBannerController::class, 'updateStatus'])->name('updateStatus');
    });

    // Messages
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{id}', [MessageController::class, 'show'])->name('messages.show');
    Route::delete('/messages/{id}', [MessageController::class, 'destroy'])->name('messages.destroy');

    // Secondary Banner
    Route::group(['prefix' => 'secondary-banner', 'as' => 'secondary-banner.'], function () {
        Route::get('/', [SeconderyBannerController::class, 'index'])->name('index');
        Route::get('/create', [SeconderyBannerController::class, 'create'])->name('create');
        Route::post('/store', [SeconderyBannerController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [SeconderyBannerController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [SeconderyBannerController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [SeconderyBannerController::class, 'destroy'])->name('destroy');
        Route::post('/update-status', [SeconderyBannerController::class, 'updateStatus'])->name('updateStatus');
    });

    // Sliders
    Route::group(['prefix' => 'sliders', 'as' => 'sliders.'], function () {
        Route::get('/', [SliderController::class, 'index'])->name('index');
        Route::get('/create', [SliderController::class, 'create'])->name('create');
        Route::post('/store', [SliderController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [SliderController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [SliderController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [SliderController::class, 'destroy'])->name('destroy');
        Route::post('/update-status', [SliderController::class, 'updateStatus'])->name('updateStatus');
    });

    // Popup Management
    Route::group(['prefix' => 'popup', 'as' => 'popup.'], function () {
        Route::get('/', [PopupController::class, 'index'])->name('index');
        Route::get('/create', [PopupController::class, 'create'])->name('create');
        Route::post('/store', [PopupController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [PopupController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [PopupController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [PopupController::class, 'destroy'])->name('destroy');
        Route::post('/update-status', [PopupController::class, 'updateStatus'])->name('updateStatus');
    });

    // Site Settings
    Route::get('/settings', [SiteSettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SiteSettingController::class, 'update'])->name('settings.update');

    // Admin Password Change
    Route::get('/admin/change-password', [UserController::class, 'changePasswordForm'])->name('admin.change.password');
    Route::post('/admin/update-password', [UserController::class, 'updatePassword'])->name('admin.update.password');

    // Delivery Charges
    Route::get('delivery-charges', [DeliveryChargeController::class, 'index'])->name('delivery-charges.index');
    Route::get('delivery-charges/create', [DeliveryChargeController::class, 'create'])->name('delivery-charges.create');
    Route::post('delivery-charges', [DeliveryChargeController::class, 'store'])->name('delivery-charges.store');
    Route::put('delivery-charges/{charge}', [DeliveryChargeController::class, 'update'])->name('delivery-charges.update');
    Route::post('delivery-charges/{charge}/status', [DeliveryChargeController::class, 'updateStatus'])->name('delivery-charges.updateStatus');

    // Flat Discount
    Route::get('/flat-discount', [FlatDiscountController::class, 'index'])->name('flat-discount.index');
    Route::post('/flat-discount/update', [FlatDiscountController::class, 'update'])->name('flat-discount.update');

    // Coupons
    Route::group(['prefix' => 'coupon', 'as' => 'coupon.'], function () {
        Route::get('/manage', [CouponController::class, 'index'])->name('index');
        Route::get('/create', [CouponController::class, 'create'])->name('create');
        Route::post('/store', [CouponController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [CouponController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [CouponController::class, 'update'])->name('update');
        Route::post('/delete/{id}', [CouponController::class, 'delete'])->name('delete');
        Route::post('/update-status', [CouponController::class, 'updateStatus'])->name('updateStatus');
    });

    // Video Section
    Route::group(['prefix' => 'video-section', 'as' => 'video-section.'], function () {
        Route::get('/index', [VideoSectionController::class, 'index'])->name('index');
        Route::post('/store', [VideoSectionController::class, 'store'])->name('store');
        Route::post('/update/{id}', [VideoSectionController::class, 'update'])->name('update');
        Route::post('/{id}', [VideoSectionController::class, 'destroy'])->name('destroy');
        Route::post('/update-status', [VideoSectionController::class, 'updateStatus'])->name('updateStatus');
    });
});
