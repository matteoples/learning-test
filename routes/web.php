<?php

use App\Models\User;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
 
Route::get('/auth/redirect', function () {
    return Socialite::driver('google')->redirect();
})->name('auth.redirect');

Route::get('/auth/callback', function () {
    $googleUser = Socialite::driver('google')->user();

    $user = User::updateOrCreate([
        'google_id' => $googleUser->id,
    ], [
        'name' => $googleUser->name,
        'email' => $googleUser->email,
        'google_token' => $googleUser->token,
        'google_refresh_token' => $googleUser->refreshToken,
    ]);

    Auth::login($user);

    return redirect('/dashboard');
});


Route::middleware('auth')->group(callback: function(): void {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        return view('dashboard', [
            'user' => $user
        ]);
    });

    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/');
    })->name('logout');


    Route::resource('students', StudentController::class);
    
    Route::get('/lessons', [LessonController::class, 'index'])->name('lessons.index');
    Route::get('/students/{student}/lessons/create', [LessonController::class, 'create'])
    ->name('lessons.create');
    Route::post('/students/{student}/lessons', [LessonController::class, 'store'])
    ->name('lessons.store');
    Route::get('/lessons/{lesson}', [LessonController::class, 'show'])->name('lessons.show');
    Route::get('/lessons/{lesson}/edit', [LessonController::class, 'edit'])->name('lessons.edit');
    Route::put('/lessons/{lesson}', [LessonController::class, 'update'])->name('lessons.update');
    Route::delete('/lessons/{lesson}', [LessonController::class, 'destroy'])->name('lessons.destroy');

    //Route::resource('payments', PaymentController::class);
    Route::get('/students/{student}/payments/create', [PaymentController::class, 'create']) ->name('payments.create');;
    Route::post('/students/{student}/payments', [PaymentController::class, 'store']) ->name('payments.store');;
    Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
    Route::get('/payments/{payment}/edit', [PaymentController::class, 'edit'])->name('payments.edit');
    Route::put('/payments/{payment}', [PaymentController::class, 'update'])->name('payments.update');
    Route::delete('/payments/{payment}', [PaymentController::class, 'destroy'])->name('payments.destroy');


   
});

Route::get('/', function () {
    return view('welcome');
});
