<?php

use App\Http\Controllers\Admin\MarketplaceAdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\MarketplaceController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MarketplaceController::class, 'home'])->name('home');
Route::get('/services', [MarketplaceController::class, 'services'])->name('services');
Route::get('/services/{serviceOffering:slug}', [MarketplaceController::class, 'serviceDetail'])->name('services.show');
Route::get('/templates', [MarketplaceController::class, 'templates'])->name('templates.index');
Route::get('/templates/{websiteTemplate:slug}', [MarketplaceController::class, 'templateDetail'])->name('templates.show');
Route::get('/portfolio', [MarketplaceController::class, 'portfolio'])->name('portfolio.index');
Route::get('/portfolio/{demoProject:slug}', [MarketplaceController::class, 'portfolioDetail'])->name('portfolio.show');
Route::get('/blog', [MarketplaceController::class, 'blog'])->name('blog.index');
Route::get('/blog/{blogPost:slug}', [MarketplaceController::class, 'blogDetail'])->name('blog.show');
Route::get('/sitemap.xml', [MarketplaceController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [MarketplaceController::class, 'robots'])->name('robots');

Route::middleware('throttle:10,1')->group(function (): void {
    Route::post('/orders', [MarketplaceController::class, 'storeOrder'])->name('orders.store');
    Route::post('/quote-requests', [MarketplaceController::class, 'storeQuote'])->name('quote-requests.store');
    Route::post('/graduation-project-requests', [MarketplaceController::class, 'storeGraduationRequest'])->name('graduation-project-requests.store');
    Route::post('/contact-messages', [MarketplaceController::class, 'storeContact'])->name('contact-messages.store');
});

Route::middleware('guest')->group(function (): void {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function (): void {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::get('/admin', [MarketplaceAdminController::class, 'dashboard'])
        ->can('access-admin')
        ->name('admin.dashboard');

    Route::prefix('/admin/marketplace')->name('admin.marketplace.')->middleware('can:access-admin')->group(function (): void {
        Route::get('/categories', [MarketplaceAdminController::class, 'categories'])->name('categories');
        Route::post('/categories', [MarketplaceAdminController::class, 'storeCategory'])->name('categories.store');
        Route::get('/templates', [MarketplaceAdminController::class, 'templates'])->name('templates');
        Route::post('/templates', [MarketplaceAdminController::class, 'storeTemplate'])->name('templates.store');
        Route::get('/services', [MarketplaceAdminController::class, 'services'])->name('services');
        Route::post('/services', [MarketplaceAdminController::class, 'storeService'])->name('services.store');
        Route::patch('/services/{serviceOffering}', [MarketplaceAdminController::class, 'updateService'])->name('services.update');
        Route::get('/orders', [MarketplaceAdminController::class, 'orders'])->name('orders');
        Route::patch('/orders/{orderRequest}', [MarketplaceAdminController::class, 'updateOrder'])->name('orders.update');
        Route::get('/customers', [MarketplaceAdminController::class, 'customers'])->name('customers');
        Route::patch('/customers/{customer}', [MarketplaceAdminController::class, 'updateCustomer'])->name('customers.update');
        Route::get('/contacts', [MarketplaceAdminController::class, 'contacts'])->name('contacts');
        Route::patch('/contacts/{contactMessage}', [MarketplaceAdminController::class, 'updateContact'])->name('contacts.update');
        Route::get('/quotes', [MarketplaceAdminController::class, 'quotes'])->name('quotes');
        Route::patch('/quotes/{quoteRequest}', [MarketplaceAdminController::class, 'updateQuote'])->name('quotes.update');
        Route::get('/graduation-requests', [MarketplaceAdminController::class, 'graduationRequests'])->name('graduation-requests');
        Route::patch('/graduation-requests/{graduationProjectRequest}', [MarketplaceAdminController::class, 'updateGraduationRequest'])->name('graduation-requests.update');
        Route::get('/blog-posts', [MarketplaceAdminController::class, 'blogPosts'])->name('blog-posts');
        Route::post('/blog-posts', [MarketplaceAdminController::class, 'storeBlogPost'])->name('blog-posts.store');
        Route::get('/demo-projects', [MarketplaceAdminController::class, 'demoProjects'])->name('demo-projects');
        Route::post('/demo-projects', [MarketplaceAdminController::class, 'storeDemoProject'])->name('demo-projects.store');
        Route::patch('/demo-projects/{demoProject}', [MarketplaceAdminController::class, 'updateDemoProject'])->name('demo-projects.update');
        Route::get('/testimonials', [MarketplaceAdminController::class, 'testimonials'])->name('testimonials');
        Route::post('/testimonials', [MarketplaceAdminController::class, 'storeTestimonial'])->name('testimonials.store');
        Route::patch('/testimonials/{testimonial}', [MarketplaceAdminController::class, 'updateTestimonial'])->name('testimonials.update');
        Route::get('/faqs', [MarketplaceAdminController::class, 'faqs'])->name('faqs');
    });
});
