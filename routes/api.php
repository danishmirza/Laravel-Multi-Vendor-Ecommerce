<?php

use App\Http\Controllers\API\IndexController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Lorisleiva\Actions\Facades\Actions;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::as('api.')->group(function () {

    Route::controller(\App\Http\Controllers\API\IndexController::class)
        ->group(function () {
            Route::post('upload-image/{path}', 'uploadImage')->name('upload-image');
            Route::get('ads/search', 'adsSearch')->name('ads.search');
            Route::get('cities', 'citiesAndAreas')->name('cities');
            Route::get('categories', 'categories')->name('categories');
            Route::get('subcategories/{id}', 'subcategories')->name('subcategories');
            Route::get('settings', 'settings')->name('settings');
            Route::get('page/{page:slug}', 'page')->name('page');
            Route::get('faqs', 'faqs')->name('faqs');
        });
    Actions::registerRoutes();
    Route::controller(\App\Http\Controllers\API\StoreController::class)
        ->prefix('stores')
        ->as('stores.')
        ->group(function () {
            Route::get('', 'index')->name('index');
            Route::get('detail/{user}', 'detail')->name('detail');
            Route::get('portfolio/{store}', 'portfolio')->name('portfolio');
            Route::get('reviews/{user}', 'reviews')->name('reviews');
            Route::get('areas/{user}', 'areas')->name('areas');
            Route::get('categories/{user}', 'categories')->name('categories');
        });
    Route::controller(\App\Http\Controllers\API\ServiceController::class)
        ->prefix('services')
        ->as('services.')
        ->group(function () {
            Route::get('search', 'search')->name('search');
            Route::get('detail/{service}', 'detail')->name('detail');
            Route::get('reviews/{service}', 'reviews')->name('reviews');
        });
    Route::controller(\App\Http\Controllers\API\BlogController::class)
        ->prefix('blogs')
        ->as('blogs.')
        ->group(function () {
            Route::get('', 'list')->name('list');
            Route::get('detail/{article}', 'detail')->name('detail');
        });
    Route::controller(\App\Http\Controllers\API\Dashboard\ProfileController::class)
        ->prefix('dashboard')
        ->as('dashboard.')
        ->middleware('auth:sanctum')
        ->group(function () {
            Route::get('profile', 'profile')->name('profile');
            Route::get('subscription-packages', 'subscriptionPackages')->name('subscription-packages');
            Route::get('featured-packages', 'featurePackages')->name('featured-packages')->middleware( ['verified', 'subscribed']);
            Route::get('purchased-featured-packages', 'purchasedFeaturePackages')->name('purchased-featured-packages')->middleware( ['verified', 'subscribed']);
            Route::get('store-areas', 'storeAreas')->name('store-areas')->middleware(['verified', 'subscribed']);

            Route::controller(\App\Http\Controllers\API\Dashboard\CartController::class)
                ->prefix('cart')
                ->as('cart.')
                ->middleware('verified')
                ->group(function () {
                    Route::get('', 'cart')->name('cart');
                    Route::get('supporting-data', 'supportingData')->name('supporting-data');
                });
            Route::controller(\App\Http\Controllers\API\Dashboard\OrderController::class)
                ->prefix('orders')
                ->as('orders.')
                ->middleware(['verified', 'subscribed'])
                ->group(function () {
                    Route::get('', 'orders')->name('orders');
                    Route::get('detail/{order}', 'detail')->name('detail');
                });
        });
});

