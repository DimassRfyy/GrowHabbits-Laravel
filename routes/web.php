<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseVideoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscribeTransactionController;
use App\Http\Controllers\TeacherController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;

Route::get('/',[FrontController::class,'index'])
    ->name('front.index');

Route::get('/details/{course:slug}',[FrontController::class,'details'])
    ->name('front.details');

Route::get('/category/{category:slug}',[FrontController::class,'category'])
    ->name('front.category');

Route::get('/pricing',[FrontController::class,'pricing'])
    ->name('front.pricing');

Route::get('/questions', [FrontController::class, 'showQuestions'])
    ->name('showQuestions');

Route::post('/process-answers', [FrontController::class, 'processAnswers'])
    ->name('processAnswers');
    
Route::get('/recommendations/{personality}', [FrontController::class, 'getRecommendations'])
    ->name('recommendations');

Route::middleware('auth')->group(function () {
    Route::get('/checkout',[FrontController::class,'checkout'])
    ->name('front.checkout')
    ->middleware('role:student');

    Route::post('/checkout/store',[FrontController::class,'checkout_store'])
    ->name('front.checkout.store')
    ->middleware('role:student');

    Route::get('/success-transaction',[FrontController::class,'success_transaction'])
    ->name('front.success-transaction');

    Route::get('/learning/{course}/{courseVideoId}',[FrontController::class,'learning'])
    ->name('front.learning')
    ->middleware('role:student|teacher|owner');

    Route::prefix('admin')->name('admin.')->group(function(){
        Route::resource('categories',CategoryController::class)
        ->middleware('role:owner');

        Route::resource('teachers',TeacherController::class)
        ->middleware('role:owner');

        Route::resource('courses',CourseController::class)
        ->middleware('role:owner|teacher');

        Route::resource('subscribe_transactions',SubscribeTransactionController::class)
        ->middleware('role:owner');

        Route::resource('course_videos',CourseVideoController::class)
        ->middleware('role:owner|teacher');

        Route::get('/add/video/{course:id}',[CourseVideoController::class,'create'])
        ->name('course.add_video')
        ->middleware('role:owner|teacher');

        Route::post('/add/video/save/{course:id}',[CourseVideoController::class,'store'])
        ->name('course.add_video.save')
        ->middleware('role:owner|teacher');
    });

    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard')->middleware(['auth', 'verified']);

    Route::get('/profile', [ProfileController::class, 'edit'])
    ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
    ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
    ->name('profile.destroy');
});



require __DIR__.'/auth.php';
