<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\MainController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\ReaderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\InstituteController;
use App\Http\Controllers\LibrarianController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SubCategoryController;

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

Route::get('/', [MainController::class, 'welcome']);

Route::get('/create-admin-account', [MainController::class, 'createAdminAccount']);

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [MainController::class, 'dashboard'])->name('dashboard');

    Route::resource('librarians', LibrarianController::class)->except(['show', 'destroy']);
    Route::resource('institutes', InstituteController::class)->except(['show', 'destroy']);
    Route::resource('resources', ResourceController::class)->except(['destroy', 'show']);
    Route::resource('types', TypeController::class)->except(['create', 'store', 'show', 'destroy']);
    Route::resource('categories', CategoryController::class)->except(['create', 'store', 'show', 'destroy']);
    Route::resource('sub-categories', SubCategoryController::class)->except(['show', 'destroy']);
    Route::resource('readers', ReaderController::class)->except(['show', 'destroy']);
    Route::resource('groups', GroupController::class)->except(['create', 'store', 'show', 'destroy']);
    Route::resource('groups.members', MemberController::class)->except(['create', 'store', 'show', 'edit', 'update', 'destroy']);
    Route::resource('loans', LoanController::class)->except(['show', 'edit', 'update', 'destroy']);
    Route::resource('reservations', ReservationController::class)->except(['show', 'edit', 'update', 'destroy']);


    Route::get('/profiles/{profile}/edit', [MainController::class, 'editProfile']);
    Route::put('/profiles/{profile}', [MainController::class, 'updateProfile']);

    Route::get('/test', [ReservationController::class, 'manageDelays']);
});

Route::get('resources/types/{id}', [ResourceController::class, 'indexTypes']);
Route::get('resources/sub-categories/{id}', [ResourceController::class, 'indexCategorySubCategories']);

Route::get('resources/{id}', [ResourceController::class, 'show'])->name('resources.show');


require __DIR__.'/auth.php';


Route::get('/disable-reader-accounts', function () {
    \Illuminate\Support\Facades\Artisan::call('readers:disable');
});

Route::get('/manage-loans', function () {
    \Illuminate\Support\Facades\Artisan::call('loans:manage');
});

Route::get('/manage-reservations', function () {
    \Illuminate\Support\Facades\Artisan::call('reservations:manage');
});

