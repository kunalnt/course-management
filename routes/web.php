<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminCourseController;
use App\Http\Controllers\Admin\AdminSectionController;
use App\Http\Controllers\DashboardController;
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

// Auth
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Student registration
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);


// Admin area
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::resource('courses', AdminCourseController::class);
    Route::get('/courses/{id}', [AdminCourseController::class, 'show'])->name('courses.show');

    // Nested section routes
    Route::get('courses/{course}/sections', [AdminSectionController::class, 'index'])->name('courses.sections.index');
    Route::get('courses/{course}/sections/create', [AdminSectionController::class, 'create'])->name('courses.sections.create');
    Route::post('courses/{course}/sections', [AdminSectionController::class, 'store'])->name('courses.sections.store');

    Route::get('sections/{section}/edit', [AdminSectionController::class, 'edit'])->name('sections.edit');
    Route::put('sections/{section}', [AdminSectionController::class, 'update'])->name('sections.update');
    Route::delete('sections/{section}', [AdminSectionController::class, 'destroy'])->name('sections.destroy');
});

// Student routes (must be logged in)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');
    Route::post('/enroll/course/{course}', [DashboardController::class,'enrollCourse'])->name('enroll.course');
    Route::post('/enroll/section/{section}', [DashboardController::class,'enrollSection'])->name('enroll.section');
    Route::get('/my-enrollments', [DashboardController::class,'myEnrollments'])->name('my.enrollments');
});

