<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EnquiryController as AdminEnquiryController;
use App\Http\Controllers\Admin\PermitController as AdminPermitController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvestorProfileController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public website routes
|--------------------------------------------------------------------------
*/

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/start-a-business', [PageController::class, 'startBusiness'])->name('start-business');
Route::get('/business-registration', [PageController::class, 'registration'])->name('registration');
Route::get('/business-licensing', [PageController::class, 'licensing'])->name('licensing');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'storeContact'])->name('contact.store');

/*
|--------------------------------------------------------------------------
| Investor authentication
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');

    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Investor dashboard
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/profile', [InvestorProfileController::class, 'edit'])->name('dashboard.profile.edit');
    Route::put('/dashboard/profile', [InvestorProfileController::class, 'update'])->name('dashboard.profile.update');
});

/*
|--------------------------------------------------------------------------
| Agency console (staff only)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::get('/enquiries', [AdminEnquiryController::class, 'index'])->name('enquiries.index');
        Route::get('/enquiries/{enquiry}', [AdminEnquiryController::class, 'show'])->name('enquiries.show');
        Route::put('/enquiries/{enquiry}', [AdminEnquiryController::class, 'update'])->name('enquiries.update');
        Route::post('/enquiries/{enquiry}/notes', [AdminEnquiryController::class, 'storeNote'])->name('enquiries.notes.store');

        Route::get('/permits', [AdminPermitController::class, 'index'])->name('permits.index');
        Route::get('/permits/create', [AdminPermitController::class, 'create'])->name('permits.create');
        Route::post('/permits', [AdminPermitController::class, 'store'])->name('permits.store');
        Route::get('/permits/{permit}/edit', [AdminPermitController::class, 'edit'])->name('permits.edit');
        Route::put('/permits/{permit}', [AdminPermitController::class, 'update'])->name('permits.update');

        /* Sectors */
        Route::get('/admin/sectors', [AdminSectorController::class, 'index'])->name('sectors.index');
        Route::get('/admin/sectors/create', [AdminSectorController::class, 'create'])->name('sectors.create');
        Route::post('/admin/sectors', [AdminSectorController::class, 'store'])->name('sectors.store');
        Route::get('/admin/sectors/{sector}/edit', [AdminSectorController::class, 'edit'])->name('sectors.edit');
        Route::put('/admin/sectors/{sector}', [AdminSectorController::class, 'update'])->name('sectors.update');

        /* Opportunities */
        Route::get('/admin/opportunities', [AdminOpportunityController::class, 'index'])->name('opportunities.index');
        Route::get('/admin/opportunities/create', [AdminOpportunityController::class, 'create'])->name('opportunities.create');
        Route::post('/admin/opportunities', [AdminOpportunityController::class, 'store'])->name('opportunities.store');
        Route::get('/admin/opportunities/{opp}/edit', [AdminOpportunityController::class, 'edit'])->name('opportunities.edit');
        Route::put('/admin/opportunities/{opp}', [AdminOpportunityController::class, 'update'])->name('opportunities.update');

        /* News */
        Route::get('/admin/news', [AdminNewsController::class, 'index'])->name('news.index');
        Route::get('/admin/news/create', [AdminNewsController::class, 'create'])->name('news.create');
        Route::post('/admin/news', [AdminNewsController::class, 'store'])->name('news.store');
        Route::get('/admin/news/{post}/edit', [AdminNewsController::class, 'edit'])->name('news.edit');
        Route::put('/admin/news/{post}', [AdminNewsController::class, 'update'])->name('news.update');
    });

/*
|--------------------------------------------------------------------------
| Content-driven sections
|--------------------------------------------------------------------------
*/

Route::get('/opportunities', [PageController::class, 'opportunities'])->name('opportunities.index');
Route::get('/sectors', [PageController::class, 'sectors'])->name('sectors.index');
Route::get('/sectors/{industry:slug}', [PageController::class, 'showSector'])->name('sectors.show');
Route::get('/news', [PageController::class, 'news'])->name('news.index');
Route::get('/news/{post:slug}', [PageController::class, 'showNews'])->name('news.show');
