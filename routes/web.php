<?php

use App\Models\User;
use App\Http\Controllers\StudentController;
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

    Route::resource('students', StudentController::class);

    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/');
    })->name('logout');
});

Route::get('/', function () {
    return view('welcome');
});
