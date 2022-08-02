<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('web.front.index', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('web.front.index'));
});

Breadcrumbs::for('web.front.about-us', function (BreadcrumbTrail $trail) {
    $trail->parent('web.front.index');
    $trail->push('About Us');
});

Breadcrumbs::for('web.front.contact-us', function (BreadcrumbTrail $trail) {
    $trail->parent('web.front.index');
    $trail->push('Contact Us');
});

Breadcrumbs::for('web.front.page', function (BreadcrumbTrail $trail, \App\Models\Page $page) {
    $trail->parent('web.front.index');
    $trail->push($page->name[app()->getLocale()]);
});

Breadcrumbs::for('web.front.categories', function (BreadcrumbTrail $trail) {
    $trail->parent('web.front.index');
    $trail->push('Categories');
});

Breadcrumbs::for('web.front.category.subcategories', function (BreadcrumbTrail $trail, \App\Models\Category $category) {
    $trail->parent('web.front.index');
    $trail->push('Categories', route('web.front.categories'));
    $trail->push($category->title[app()->getLocale()]);
});

Breadcrumbs::for('web.front.articles', function (BreadcrumbTrail $trail) {
    $trail->parent('web.front.index');
    $trail->push('Articles');
});

Breadcrumbs::for('web.front.article.detail', function (BreadcrumbTrail $trail, \App\Models\Article $article) {
    $trail->parent('web.front.index');
    $trail->push('Articles', route('web.front.articles'));
    $trail->push($article->title[app()->getLocale()]);
});

Breadcrumbs::for('web.front.faqs', function (BreadcrumbTrail $trail) {
    $trail->parent('web.front.index');
    $trail->push('FAQS');
});

Breadcrumbs::for('web.front.stores', function (BreadcrumbTrail $trail) {
    $trail->parent('web.front.index');
    $trail->push('Service Providers');
});

Breadcrumbs::for('web.front.store.detail', function (BreadcrumbTrail $trail, \App\Models\User $user) {
    $trail->parent('web.front.index');
    $trail->push('Service Providers', route('web.front.stores'));
    $trail->push($user->store_name[app()->getLocale()]);
});

Breadcrumbs::for('web.front.store.detail.portfolio', function (BreadcrumbTrail $trail, \App\Models\User $user) {
    $trail->parent('web.front.index');
    $trail->push('Service Providers', route('web.front.stores'));
    $trail->push($user->store_name[app()->getLocale()], route('web.front.store.detail', ['user' => $user->id]));
    $trail->push('Portfolio');
});

Breadcrumbs::for('web.front.store.detail.reviews', function (BreadcrumbTrail $trail, \App\Models\User $user) {
    $trail->parent('web.front.index');
    $trail->push('Service Providers', route('web.front.stores'));
    $trail->push($user->store_name[app()->getLocale()], route('web.front.store.detail', ['user' => $user->id]));
    $trail->push('Reviews');
});

Breadcrumbs::for('web.front.services', function (BreadcrumbTrail $trail) {
    $trail->parent('web.front.index');
    $trail->push('Services');
});

Breadcrumbs::for('web.front.offered-services', function (BreadcrumbTrail $trail) {
    $trail->parent('web.front.index');
    $trail->push('Offered Services');
});

Breadcrumbs::for('web.front.service.detail', function (BreadcrumbTrail $trail, \App\Models\Service $service) {
    $trail->parent('web.front.index');
    $trail->push('Services', route('web.front.services'));
    $trail->push($service->title[app()->getLocale()]);
});

Breadcrumbs::for('web.auth.login', function (BreadcrumbTrail $trail) {
    $trail->parent('web.front.index');
    $trail->push('Login');
});

Breadcrumbs::for('web.auth.register', function (BreadcrumbTrail $trail) {
    $trail->parent('web.front.index');
    $trail->push('Register');
});

Breadcrumbs::for('web.auth.register-user', function (BreadcrumbTrail $trail) {
    $trail->parent('web.front.index');
    $trail->push('Register', route('web.auth.register'));
    $trail->push('Register User');
});

Breadcrumbs::for('web.auth.register-store', function (BreadcrumbTrail $trail) {
    $trail->parent('web.front.index');
    $trail->push('Register', route('web.auth.register'));
    $trail->push('Register Service Provider');
});

Breadcrumbs::for('web.auth.forgot-password', function (BreadcrumbTrail $trail) {
    $trail->parent('web.front.index');
    $trail->push('Forgot Password');
});

Breadcrumbs::for('web.auth.reset-password', function (BreadcrumbTrail $trail) {
    $trail->parent('web.front.index');
    $trail->push('Reset Password');
});

Breadcrumbs::for('web.dashboard.profile', function (BreadcrumbTrail $trail) {
    $trail->parent('web.front.index');
    $trail->push('Profile');
});

Breadcrumbs::for('web.dashboard.edit-user-profile', function (BreadcrumbTrail $trail) {
    $trail->parent('web.front.index');
    $trail->push('Profile', route('web.dashboard.profile'));
    $trail->push('Edit Profile');
});

Breadcrumbs::for('web.dashboard.edit-store-profile', function (BreadcrumbTrail $trail) {
    $trail->parent('web.front.index');
    $trail->push('Profile', route('web.dashboard.profile'));
    $trail->push('Edit Profile');
});

Breadcrumbs::for('web.dashboard.change-password', function (BreadcrumbTrail $trail) {
    $trail->parent('web.front.index');
    $trail->push('Profile', route('web.dashboard.profile'));
    $trail->push('Change Password');
});

Breadcrumbs::for('web.dashboard.verify-email', function (BreadcrumbTrail $trail) {
    $trail->parent('web.front.index');
    $trail->push('Profile', route('web.dashboard.profile'));
    $trail->push('Verify Email');
});

Breadcrumbs::for('web.dashboard.subscription', function (BreadcrumbTrail $trail) {
    $trail->parent('web.front.index');
    $trail->push('Profile', route('web.dashboard.profile'));
    $trail->push('Subscribe To A Package');
});

Breadcrumbs::for('web.dashboard.notifications', function (BreadcrumbTrail $trail) {
    $trail->parent('web.front.index');
    $trail->push('Profile', route('web.dashboard.profile'));
    $trail->push('Notifications');
});

Breadcrumbs::for('web.dashboard.addresses', function (BreadcrumbTrail $trail) {
    $trail->parent('web.front.index');
    $trail->push('Profile', route('web.dashboard.profile'));
    $trail->push('Addresses');
});

Breadcrumbs::for('web.dashboard.store-areas.index', function (BreadcrumbTrail $trail) {
    $trail->parent('web.front.index');
    $trail->push('Profile', route('web.dashboard.profile'));
    $trail->push('Manage Service Areas');
});

Breadcrumbs::for('web.dashboard.store-areas.create', function (BreadcrumbTrail $trail) {
    $trail->parent('web.front.index');
    $trail->push('Profile', route('web.dashboard.profile'));
    $trail->push('Manage Delivery Areas', route('web.dashboard.store-areas.index'));
    $trail->push('Add Delivery Area');
});

Breadcrumbs::for('web.dashboard.store-areas.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('web.front.index');
    $trail->push('Profile', route('web.dashboard.profile'));
    $trail->push('Manage Delivery Areas', route('web.dashboard.store-areas.index'));
    $trail->push('Update Delivery Area');
});

Breadcrumbs::for('web.dashboard.store-services.index', function (BreadcrumbTrail $trail) {
    $trail->parent('web.front.index');
    $trail->push('Profile', route('web.dashboard.profile'));
    $trail->push('Manage Services');
});

Breadcrumbs::for('web.dashboard.store-services.create', function (BreadcrumbTrail $trail) {
    $trail->parent('web.front.index');
    $trail->push('Profile', route('web.dashboard.profile'));
    $trail->push('Manage Services', route('web.dashboard.store-services.index'));
    $trail->push('Add Service');
});

Breadcrumbs::for('web.dashboard.store-services.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('web.front.index');
    $trail->push('Profile', route('web.dashboard.profile'));
    $trail->push('Manage Services', route('web.dashboard.store-services.index'));
    $trail->push('Update Service');
});

Breadcrumbs::for('web.dashboard.feature-packages.index', function (BreadcrumbTrail $trail) {
    $trail->parent('web.front.index');
    $trail->push('Profile', route('web.dashboard.profile'));
    $trail->push('Feature Packages');
});

Breadcrumbs::for('web.dashboard.feature-packages.purchased', function (BreadcrumbTrail $trail) {
    $trail->parent('web.front.index');
    $trail->push('Profile', route('web.dashboard.profile'));
    $trail->push('Purchased Feature Packages');
});

Breadcrumbs::for('web.dashboard.portfolios.index', function (BreadcrumbTrail $trail) {
    $trail->parent('web.front.index');
    $trail->push('Profile', route('web.dashboard.profile'));
    $trail->push('Portfolio');
});

Breadcrumbs::for('web.dashboard.portfolios.create', function (BreadcrumbTrail $trail) {
    $trail->parent('web.front.index');
    $trail->push('Profile', route('web.dashboard.profile'));
    $trail->push('Portfolio', route('web.dashboard.portfolios.index'));
    $trail->push('Upload Images');
});


Breadcrumbs::for('web.dashboard.store-ads.index', function (BreadcrumbTrail $trail) {
    $trail->parent('web.front.index');
    $trail->push('Profile', route('web.dashboard.profile'));
    $trail->push('Manage Ads');
});

Breadcrumbs::for('web.dashboard.store-ads.create', function (BreadcrumbTrail $trail) {
    $trail->parent('web.front.index');
    $trail->push('Profile', route('web.dashboard.profile'));
    $trail->push('Manage Ads', route('web.dashboard.store-ads.index', ['status' => 'pending']));
    $trail->push('Create Request Ad');
});

Breadcrumbs::for('web.dashboard.store-ads.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('web.front.index');
    $trail->push('Profile', route('web.dashboard.profile'));
    $trail->push('Manage Ads', route('web.dashboard.store-ads.index', ['status' => 'pending']));
    $trail->push('Update Request Ad');
});

Breadcrumbs::for('web.dashboard.cart', function (BreadcrumbTrail $trail) {
    $trail->parent('web.front.index');
    $trail->push('Profile', route('web.dashboard.profile'));
    $trail->push('Cart');
});

Breadcrumbs::for('web.dashboard.checkout', function (BreadcrumbTrail $trail) {
    $trail->parent('web.front.index');
    $trail->push('Profile', route('web.dashboard.profile'));
    $trail->push('Cart', route('web.dashboard.cart'));
    $trail->push('Checkout');
});

Breadcrumbs::for('web.dashboard.orders.index', function (BreadcrumbTrail $trail) {
    $trail->parent('web.front.index');
    $trail->push('Profile', route('web.dashboard.profile'));
    $trail->push('Orders');
});

Breadcrumbs::for('web.dashboard.orders.detail', function (BreadcrumbTrail $trail) {
    $trail->parent('web.front.index');
    $trail->push('Profile', route('web.dashboard.profile'));
    $trail->push('Orders', route('web.dashboard.orders.index'));
    $trail->push('Order Detail');
});

Breadcrumbs::for('web.dashboard.chats.index', function (BreadcrumbTrail $trail) {
    $trail->parent('web.front.index');
    $trail->push('Profile', route('web.dashboard.profile'));
    $trail->push('Chats');
});

Breadcrumbs::for('web.dashboard.chats.messages', function (BreadcrumbTrail $trail) {
    $trail->parent('web.front.index');
    $trail->push('Profile', route('web.dashboard.profile'));
    $trail->push('Messages');
});
