<?php

use App\Http\Controllers\Admin\PageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\DashboardController;

Route::as('admin.')->group(function () {
    Route::group(['as' => 'auth.', 'namespace' => 'Auth'], function () {
        Route::get('/', [LoginController::class, 'view'])->name('login.form');
        Route::post('login', [LoginController::class, 'login'])->name('login');
        Route::post('logout', [LoginController::class, 'logout'])->name('logout.post');
        Route::get('logout', [LoginController::class, 'logout'])->name('logout.get');
        Route::get('forgot-password', [ForgotPasswordController::class, 'view'])->name('forgot-password.form');
        Route::post('forgot-password', [ForgotPasswordController::class, 'forgotPassword'])->name('forgot-password');
        Route::get('reset-password/{token}', [ResetPasswordController::class, 'view'])->name('reset-password.form');
        Route::post('reset-password', [ResetPasswordController::class, 'resetPassword'])->name('reset-password');
    });
    Route::middleware('auth:admin')->as('dashboard.')->group(function (){
        Route::resources([
            'pages' => PageController::class,
            'settings' => \App\Http\Controllers\Admin\SettingController::class,
            'articles' => \App\Http\Controllers\Admin\ArticleController::class,
            'categories' => \App\Http\Controllers\Admin\CategoryController::class,
            'categories.subcategories' => \App\Http\Controllers\Admin\SubcategoryController::class,
            'faqs' => \App\Http\Controllers\Admin\FaqsController::class,
            'cities' => \App\Http\Controllers\Admin\CityController::class,
            'cities.areas' => \App\Http\Controllers\Admin\AreaController::class,
            'users' => \App\Http\Controllers\Admin\UserController::class,
            'stores' => \App\Http\Controllers\Admin\StoreController::class,
            'stores.areas' => \App\Http\Controllers\Admin\StoreAreaController::class,
            'stores.services' => \App\Http\Controllers\Admin\ServiceController::class,
            'stores.portfolio' => \App\Http\Controllers\Admin\StorePortfolioController::class,
            'stores.ads' => \App\Http\Controllers\Admin\StoreAdController::class,
            'coupons' => \App\Http\Controllers\Admin\CouponController::class,
        ]);
        Route::controller(\App\Http\Controllers\Admin\PackageController::class)
            ->prefix('packages')
            ->as('packages.')
            ->group(function () {
                Route::get('{type}', 'index')->name('index');
                Route::get('create/{type}', 'create')->name('create');
                Route::get('edit/{type}/{id}', 'edit')->name('edit');
                Route::post('update/{id}', 'update')->name('update');
                Route::post('destroy', 'destroy')->name('destroy');
            });

        Route::prefix('list/')->group(function () {
            Route::post('packages', [\App\Http\Controllers\Admin\PackageController::class, 'all'])->name('packages.ajax.list');
            Route::post('pages', [PageController::class, 'all'])->name('pages.ajax.list');
            Route::post('site-settings', [\App\Http\Controllers\Admin\SettingController::class, 'all'])->name('settings.ajax.list');
            Route::post('articles', [\App\Http\Controllers\Admin\ArticleController::class, 'all'])->name('articles.ajax.list');
            Route::post('faqs', [\App\Http\Controllers\Admin\FaqsController::class, 'all'])->name('faqs.ajax.list');
            Route::post('packages/{type}', [\App\Http\Controllers\Admin\PackageController::class, 'all'])->name('packages.ajax.list');
            Route::post('users', [\App\Http\Controllers\Admin\UserController::class, 'all'])->name('users.ajax.list');
            Route::post('stores', [\App\Http\Controllers\Admin\StoreController::class, 'all'])->name('suppliers.ajax.list');
            Route::post('store-areas/{storeId}', [\App\Http\Controllers\Admin\StoreAreaController::class, 'all'])->name('suppliers.ajax.list');
            Route::post('services/{storeId?}', [\App\Http\Controllers\Admin\ServiceController::class, 'all'])->name('suppliers.ajax.list');
            Route::post('store-ads/{storeId?}', [\App\Http\Controllers\Admin\StoreAdController::class, 'all'])->name('suppliers.ajax.list');
            Route::post('coupons', [\App\Http\Controllers\Admin\CouponController::class, 'all'])->name('coupons.ajax.list');
//            Route::post('administrators', [AdministratorsController::class, 'all'])->name('administrators.ajax.list');
        });
        Route::get('all-services', [\App\Http\Controllers\Admin\ServiceController::class, 'allServices'])->name('all-services');
        Route::get('stores/{store}/ads/{ad}/{status}', [\App\Http\Controllers\Admin\StoreAdController::class, 'changeStatus'])->name('stores.ads.status');
        Route::get('home',[DashboardController::class, 'index'])->name( 'index');
        Route::get('edit-profile',[DashboardController::class, 'editProfile'])->name( 'edit-profile');
        Route::put('update-profile',[DashboardController::class, 'updateProfile'])->name( 'update-profile');
        Route::controller(\App\Http\Controllers\Admin\NotificationController::class)
            ->prefix('notifications')
            ->as('notifications.')
            ->group(function () {
                Route::get('', 'index')->name('index');
                Route::get('read-all', 'readAll')->name('readAll');
                Route::get('delete-all', 'deleteAll')->name('deleteAll');
                Route::get('delete-one/{id}', 'deleteOne')->name('deleteOne');
            });
    });
});
