<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\TehsilController;
use App\Http\Controllers\BlockController;
use App\Http\Controllers\VillageController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\SummerController;
use App\Http\Controllers\PromotionalController;
use App\Http\Controllers\CMSController;
use App\Http\Controllers\RecommendedController;
use App\Http\Controllers\AplusController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\AttributeValueController;
use App\Http\Controllers\VarientController;

// Cafe
use App\Http\Controllers\cafe\TypeController;
use App\Http\Controllers\cafe\CategoryController as CafeCategoryController;

Route::controller(LoginController::class)->group(function () {
    Route::get('login', 'login')->name('login');
    Route::post('logins', 'logins')->name('logins');
});

Route::middleware(['auth:admin'])->group(function () {

    Route::controller(AdminController::class)->group(function () {
        Route::get('', 'index')->name('index');
    });

    Route::prefix('users')->controller(UserController::class)->name('users.')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('cart/{id}', 'cart')->name('cart');
        Route::get('order/{id}', 'order')->name('order');
        Route::get('order/details/{id}', 'orderDetails')->name('order_details');
        Route::post('status', 'status')->name('status');
    });

    Route::prefix('categories')->controller(CategoryController::class)->name('category.')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('add', 'add')->name('add');
        Route::post('save', 'save')->name('save');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
        Route::post('update-position', 'updatePosition')->name('updatePosition');
    });

    Route::prefix('sub/category')->controller(SubCategoryController::class)->name('sub_category.')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('add', 'add')->name('add');
        Route::post('save', 'save')->name('save');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
    });

    Route::prefix('brands')->controller(BrandController::class)->name('brand.')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('add', 'add')->name('add');
        Route::post('save', 'save')->name('save');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
    });

    Route::prefix('discount')->controller(DiscountController::class)->name('discount.')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('add', 'add')->name('add');
        Route::post('save', 'save')->name('save');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
    });

    Route::prefix('products')->controller(ProductController::class)->name('product.')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('add', 'add')->name('add');
        Route::post('save', 'save')->name('save');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('status', 'status')->name('status');
        Route::post('update', 'update')->name('update');
        // Gallery
        Route::get('gallery/{id}', 'gallery')->name('gallery');
        Route::post('gallery_save', 'gallery_save')->name('gallery_save');
        Route::delete('gallery_delete/{id}', 'gallery_delete')->name('gallery_delete');
        // Stock
        Route::get('stock/{id}', 'stock')->name('stock');
        Route::post('stock_save', 'stockSave')->name('stock_save');
        Route::post('select_stock', 'selectStock')->name('select_stock');
        Route::post('summer_status', 'summerStatus')->name('summer_status');
        // Simalar
        Route::get('similar/{id}', 'similar')->name('similar');
        Route::post('similar/save', 'saveSimilar')->name('similar.save');
    });

    Route::prefix('stores')->controller(StoreController::class)->name('store.')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('add', 'add')->name('add');
        Route::post('save', 'save')->name('save');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
    });

    Route::prefix('country')->controller(CountryController::class)->name('country.')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('add', 'add')->name('add');
        Route::post('store', 'store')->name('store');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
        Route::delete('delete/{id}', 'delete')->name('delete');
    });

    Route::prefix('state')->controller(StateController::class)->name('state.')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('add', 'add')->name('add');
        Route::post('store', 'store')->name('store');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
        Route::delete('delete/{id}', 'delete')->name('delete');
    });

    Route::prefix('district')->controller(DistrictController::class)->name('district.')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('add', 'add')->name('add');
        Route::post('store', 'store')->name('store');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
        Route::delete('delete/{id}', 'delete')->name('delete');
    });

    Route::prefix('tehsil')->controller(TehsilController::class)->name('tehsil.')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('add', 'add')->name('add');
        Route::post('store', 'store')->name('store');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
        Route::delete('delete/{id}', 'delete')->name('delete');
    });

    Route::prefix('block')->controller(BlockController::class)->name('block.')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('add', 'add')->name('add');
        Route::post('save', 'save')->name('save');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
        Route::delete('delete/{id}', 'delete')->name('delete');
    });

    Route::prefix('village')->controller(VillageController::class)->name('village.')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('add', 'add')->name('add');
        Route::post('save', 'save')->name('save');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
        Route::delete('delete/{id}', 'delete')->name('delete');
    });

    Route::prefix('tax')->controller(TaxController::class)->name('tax.')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('add', 'add')->name('add');
        Route::post('save', 'save')->name('save');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
        Route::post('status', 'status')->name('status');
        Route::delete('delete/{id}', 'delete')->name('delete');
    });

    Route::prefix('settings')->controller(SettingController::class)->name('setting.')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('add', 'add')->name('add');
        Route::post('save', 'save')->name('save');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
        Route::delete('delete', 'delete')->name('delete');
    });

    Route::prefix('email/template')->controller(EmailTemplateController::class)->name('email_template.')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('add', 'add')->name('add');
        Route::post('save', 'save')->name('save');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
        Route::delete('delete', 'delete')->name('delete');
    });

    Route::prefix('sliders')->controller(SliderController::class)->name('slider.')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('add', 'add')->name('add');
        Route::post('save', 'save')->name('save');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
        Route::post('status', 'status')->name('status');
        Route::delete('delete/{id}', 'delete')->name('delete');
    });

    Route::prefix('summers')->controller(SummerController::class)->name('summer.')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('add', 'add')->name('add');
        Route::post('save', 'save')->name('save');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
        Route::post('update-position', 'updatePosition')->name('updatePosition');
    });

    Route::prefix('promotionals')->controller(PromotionalController::class)->name('promotional.')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('add', 'add')->name('add');
        Route::post('save', 'save')->name('save');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
        Route::post('status', 'status')->name('status');
        Route::delete('delete/{id}', 'delete')->name('delete');
    });

    Route::prefix('cms')->controller(CMSController::class)->name('cms.')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('add', 'add')->name('add');
        Route::post('save', 'save')->name('save');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
        Route::post('status', 'status')->name('status');
        Route::delete('delete/{id}', 'delete')->name('delete');
    });

    Route::prefix('recommendeds')->controller(RecommendedController::class)->name('recommended.')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('add', 'add')->name('add');
        Route::post('save', 'save')->name('save');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
        Route::post('status', 'status')->name('status');
        Route::delete('delete/{id}', 'delete')->name('delete');
    });

    Route::prefix('aplus')->controller(AplusController::class)->name('aplus.')->group(function () {
        Route::get('/{id}', 'index')->name('index');
        Route::post('store', 'store')->name('store');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
        Route::post('status', 'status')->name('status');
        Route::delete('delete/{id}', 'delete')->name('delete');
    });

    Route::prefix('status')->controller(StatusController::class)->name('status.')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('add', 'add')->name('add');
        Route::post('save', 'save')->name('save');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
        Route::delete('delete/{id}', 'delete')->name('delete');
    });

    Route::controller(ReportController::class)->group(function () {
        Route::get('transaction', 'transaction')->name('transaction');
    });

    Route::prefix('supplier')->controller(SupplierController::class)->name('supplier.')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('add', 'add')->name('add');
        Route::post('save', 'save')->name('save');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
        Route::delete('delete/{id}', 'delete')->name('delete');
        Route::post('assign_role', 'assignRole')->name('assign_role');
    });

    Route::prefix('buyer')->controller(BuyerController::class)->name('buyer.')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('add', 'add')->name('add');
        Route::post('save', 'save')->name('save');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
        Route::delete('delete/{id}', 'delete')->name('delete');
        Route::post('assign_role', 'assignRole')->name('assign_role');
    });

    Route::prefix('order')->controller(OrderController::class)->name('order.')->group(function () {
        Route::get('', 'index')->name('index');
        Route::post('status', 'status')->name('status');
        Route::post('delivery_boy', 'deliveryBoy')->name('delivery_boy');
        Route::get('barcodes', 'barcodes')->name('barcodes');
        Route::get('barcode/{id}', 'barcode')->name('barcode');
        Route::get('invoice/{id}', 'invoice')->name('invoice');
        Route::post('barcode-print', 'barcode_print')->name('barcode_print');
    });

    Route::prefix('attribute')->controller(AttributeController::class)->name('attribute.')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('add', 'add')->name('add');
        Route::post('save', 'save')->name('save');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
        Route::post('update-position', 'updatePosition')->name('updatePosition');
    });

    Route::prefix('attribute/value')->controller(AttributeValueController::class)->name('attribute_value.')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('add', 'add')->name('add');
        Route::post('save', 'save')->name('save');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
        Route::post('update-position', 'updatePosition')->name('updatePosition');
    });

    Route::prefix('varient')->controller(VarientController::class)->name('varient.')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('add/{id}', 'add')->name('add');
        Route::post('save', 'save')->name('save');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
        Route::post('update-position', 'updatePosition')->name('updatePosition');
    });

    Route::prefix('cafe')->name('cafe.')->group(function () {
        Route::prefix('type')->controller(TypeController::class)->name('type.')->group(function () {
            Route::get('', 'index')->name('index');
            Route::get('add', 'add')->name('add');
            Route::post('save', 'save')->name('save');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('update', 'update')->name('update');
        });

        Route::prefix('category')->controller(CafeCategoryController::class)->name('category.')->group(function () {
            Route::get('', 'index')->name('index');
            Route::get('add', 'add')->name('add');
            Route::post('save', 'save')->name('save');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('update', 'update')->name('update');
            Route::post('update-position', 'updatePosition')->name('updatePosition');
        });
    });
});
