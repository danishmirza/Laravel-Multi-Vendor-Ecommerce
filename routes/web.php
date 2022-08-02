<?php

use Illuminate\Support\Facades\Route;
use Lorisleiva\Actions\Facades\Actions;

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



Route::as('web.')->group(function () {
    Route::get('test', function (){
       \App\Models\User::find(1)->notify(new \App\Notifications\OrderCreatedNotification(13, 'user'));
    });
    Actions::registerRoutes();
    Route::as('front.')->group(function (){
        Route::controller(\App\Http\Controllers\Web\IndexController::class)
            ->group(function () {
                Route::get('', 'index')->name('index');
                Route::get('about-us', 'aboutUs')->name('about-us');
                Route::get('page/{page:slug}', 'page')->name('page');
                Route::get('contact-us', 'contactUs')->name('contact-us');
                Route::post('select-area', 'selectArea')->name('select-area');
                Route::get('select-area-get', 'selectArea')->name('select-area-get');
            });
        Route::controller(\App\Http\Controllers\Web\CategoryController::class)
            ->prefix('categories')
            ->group(function () {
                Route::get('', 'index')->name('categories');
                Route::get('{category:id}/subcategories', 'subcategories')->name('category.subcategories');
            });
        Route::controller(\App\Http\Controllers\Web\ArticleController::class)
            ->prefix('articles')
            ->group(function () {
                Route::get('', 'index')->name('articles');
                Route::get('detail/{article:id}', 'detail')->name('article.detail');
            });
        Route::get('faqs', [\App\Http\Controllers\Web\FaqController::class, 'index'])->name('faqs');
        Route::controller(\App\Http\Controllers\Web\StoreController::class)
            ->prefix('stores')
            ->group(function () {
                Route::get('', 'index')->name('stores');
                Route::get('detail/{user:id}', 'detail')->name('store.detail');
                Route::get('detail/{user:id}/portfolio', 'portfolio')->name('store.detail.portfolio');
                Route::get('detail/{user:id}/reviews', 'reviews')->name('store.detail.reviews');
            });
        Route::controller(\App\Http\Controllers\Web\ServiceController::class)
            ->prefix('services')
            ->group(function () {
                Route::get('', 'index')->name('services');
                Route::get('offered', 'offered')->name('offered-services');
                Route::get('detail/{service:id}', 'detail')->name('service.detail');
            });
    });
    Route::controller(\App\Http\Controllers\Web\AuthController::class)
        ->as('auth.')
        ->prefix('auth')
        ->middleware('guest')
        ->group(function () {
            Route::get('login', 'login')->name('login');
            Route::get('register', 'register')->name('register');
            Route::get('register/user', 'registerUser')->name('register-user');
            Route::get('register/service-provider', 'registerStore')->name('register-store');
            Route::get('forgot-password', 'forgotPassword')->name('forgot-password');
            Route::get('reset-password', 'resetPassword')->name('reset-password');
        });
    Route::as('dashboard.')->prefix('dashboard')->middleware('auth')->group(function () {
        Route::controller(\App\Http\Controllers\Web\Dashboard\ProfileController::class)
            ->group(function () {
                Route::get('profile', 'profile')->name('profile');
                Route::get('edit-user-profile', 'editProfileUser')->name('edit-user-profile');
                Route::get('edit-store-profile', 'editProfileStore')->name('edit-store-profile');
                Route::get('change-password', 'changePassword')->name('change-password');
                Route::get('verify-email', 'verifyEmail')->name('verify-email');
                Route::get('subscription', 'subscription')->name('subscription');
                Route::get('notifications', 'notifications')->name('notifications');
                Route::get('addresses', 'addresses')->name('addresses')->middleware('verified');
                Route::get('cart', 'cart')->name('cart')->middleware('verified');
                Route::get('checkout', 'checkout')->name('checkout')->middleware('verified','check-service-area');
            });
        Route::resource('store-areas', \App\Http\Controllers\Web\Dashboard\StoreAreaController::class)
            ->only(['index', 'create', 'edit'])->middleware(['verified', 'subscribed']);
        Route::resource('store-services', \App\Http\Controllers\Web\Dashboard\StoreServiceController::class)
            ->only(['index', 'create', 'edit'])->parameters(['store-services'=> 'service'])->middleware(['verified', 'subscribed']);
        Route::controller(\App\Http\Controllers\Web\Dashboard\StorePackageController::class)
            ->as('feature-packages.')
            ->prefix('feature-packages')
            ->middleware(['verified', 'subscribed'])
            ->group(function () {
                Route::get('', 'index')->name('index');
                Route::get('purchased', 'purchased')->name('purchased');
            });
        Route::controller(\App\Http\Controllers\Web\Dashboard\StorePortfolioController::class)
            ->as('portfolios.')
            ->prefix('portfolios')
            ->middleware(['verified', 'subscribed'])
            ->group(function () {
                Route::get('', 'index')->name('index');
                Route::get('create', 'create')->name('create');
            });
        Route::resource('store-ads', \App\Http\Controllers\Web\Dashboard\StoreAdController::class)
            ->only(['create', 'edit'])->parameters(['store-ads'=> 'ad'])->middleware(['verified', 'subscribed']);
        Route::get('/store-ads/{status}', [\App\Http\Controllers\Web\Dashboard\StoreAdController::class, 'index'])
            ->name('store-ads.index')->middleware('verified');
        Route::controller(\App\Http\Controllers\Web\Dashboard\OrderController::class)
            ->as('orders.')
            ->prefix('orders')
            ->middleware(['verified', 'subscribed'])
            ->group(function () {
                Route::get('', 'orders')->name('index');
                Route::get('detail/{order}', 'detail')->name('detail');
            });
        Route::controller(\App\Http\Controllers\Web\Dashboard\ChatController::class)
            ->as('chats.')
            ->prefix('chats')
            ->middleware(['verified', 'subscribed'])
            ->group(function () {
                Route::get('', 'conversations')->name('index');
                Route::get('messages/{conversation}', 'messages')->name('messages');
            });
    });
});
