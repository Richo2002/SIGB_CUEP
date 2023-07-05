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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/resource-details', function () {
    return view('resource-details');
});

Route::get('/create-admin-account', [MainController::class, 'createAdminAccount']);

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [MainController::class, 'dashboard'])->name('dashboard');

    // Route::resources([
    //     'librarians' => LibrarianController::class,
    //     'institutes' => InstituteController::class,
    //     'resources' => ResourceController::class,
    //     'types' => TypeController::class,
    //     'categories' => CategoryController::class,
    //     'sub-categories' => SubCategoryController::class,
    //     'readers' => ReaderController::class,
    //     'groups' => GroupController::class,
    //     'groups.members' => MemberController::class,
    //     'loans' => LoanController::class,
    //     'reservations' => ReservationController::class
    // ]);

    Route::resource('librarians', LibrarianController::class)->except(['show', 'destroy']);
    Route::resource('institutes', InstituteController::class)->except(['show', 'destroy']);
    Route::resource('resources', ResourceController::class)->except(['show', 'destroy']);
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


require __DIR__.'/auth.php';
