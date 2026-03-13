<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleSyncController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/auth/redirect', [AuthController::class, 'redirectToGoogle'])->name('auth.redirect');
Route::get('/auth/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.callback');

Route::middleware('auth')->group(callback: function(): void {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::put('/settings/subjects', [SettingsController::class, 'updateSubjects'])->name('settings.update-subjects');

    Route::get('/students/import', [StudentController::class, 'showImportForm'])->name('students.import.form');
    Route::post('/students/import', [StudentController::class, 'importFromJson'])->name('students.import');

    Route::resource('students', StudentController::class);

    Route::get('/lessons', [LessonController::class, 'index'])->name('lessons.index');
    Route::get('/students/{student}/lessons/create', [LessonController::class, 'create'])->name('lessons.create');
    Route::post('/students/{student}/lessons', [LessonController::class, 'store'])->name('lessons.store');
    Route::get('/lessons/{lesson}', [LessonController::class, 'show'])->name('lessons.show');
    Route::get('/lessons/{lesson}/edit', [LessonController::class, 'edit'])->name('lessons.edit');
    Route::put('/lessons/{lesson}', [LessonController::class, 'update'])->name('lessons.update');
    Route::delete('/lessons/{lesson}', [LessonController::class, 'destroy'])->name('lessons.destroy');

    Route::get('/students/{student}/payments/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/students/{student}/payments', [PaymentController::class, 'store'])->name('payments.store');
    Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
    Route::get('/payments/{payment}/edit', [PaymentController::class, 'edit'])->name('payments.edit');
    Route::put('/payments/{payment}', [PaymentController::class, 'update'])->name('payments.update');
    Route::delete('/payments/{payment}', [PaymentController::class, 'destroy'])->name('payments.destroy');

    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
});

Route::post('/google/sync', [GoogleSyncController::class, 'sync'])->middleware('auth')->name('google.sync');
Route::post('/google/reset', [GoogleSyncController::class, 'reset'])->middleware('auth')->name('google.reset');

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/dashboard');
    }
    return view('welcome');
});
