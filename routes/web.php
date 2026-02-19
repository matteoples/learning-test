<?php

use App\Models\User;
use Carbon\Carbon;
use App\Models\Lesson;
use App\Models\Student;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Services\GoogleAccountService;

// Redirect a Google
Route::get('/auth/redirect', function () {

    $client = new \Google\Client();
    $client->setClientId(config('services.google.client_id'));
    $client->setClientSecret(config('services.google.client_secret'));
    $client->setRedirectUri(route('auth.callback'));
    
    $client->setAccessType('offline'); // per ottenere refresh token
    $client->setPrompt('consent');     // forza consenso ogni volta

    $client->setScopes([
        'openid',
        'profile',
        'email',
        'https://www.googleapis.com/auth/calendar', // Calendar
    ]);

    // Crea URL di autorizzazione
    $authUrl = $client->createAuthUrl();

    return redirect($authUrl);
})->name('auth.redirect');

// Callback da Google
Route::get('/auth/callback', function () {

    $client = new \Google\Client();
    $client->setClientId(config('services.google.client_id'));
    $client->setClientSecret(config('services.google.client_secret'));
    $client->setRedirectUri(route('auth.callback'));
    $client->setAccessType('offline');
    $client->setPrompt('consent');
    $client->setScopes([
        'openid',
        'profile',
        'email',
        \Google\Service\Calendar::CALENDAR,
    ]);

    // Otteniamo il token con il code che Google ha passato
    $token = $client->fetchAccessTokenWithAuthCode(request('code'));

    if (isset($token['error'])) {
        dd('Errore durante OAuth: ', $token);
    }

    // Imposta il token sul client
    $client->setAccessToken($token);

    // Recupera le info dell'utente
    $oauth = new \Google\Service\Oauth2($client);
    $googleUser = $oauth->userinfo->get();

    // Salva o aggiorna l'utente
    $user = User::updateOrCreate([
        'google_id' => $googleUser->id,
    ], [
        'name' => $googleUser->name,
        'email' => $googleUser->email,
        'google_token' => $token['access_token'],
        'google_refresh_token' => $token['refresh_token'] ?? null,
    ]);

    // Inizializza il service per Calendar (se serve)
    $googleService = new GoogleAccountService($user);
    if (!$user->google_calendar_id) {
        $calendarId = $googleService->createCalendar('Ripetiflow');
        $user->update(['google_calendar_id' => $calendarId]);
    }

    // Login dell'utente
    Auth::login($user);

    return redirect('/dashboard');
})->name('auth.callback');

Route::middleware('auth')->group(callback: function(): void {
     Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/');
    })->name('logout');

    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::put('/settings/subjects', [SettingsController::class, 'updateSubjects'])->name('settings.update-subjects');


    
    // Importa uno studente da file JSON (con lezioni e pagamenti)
    Route::get('/students/import', [StudentController::class, 'showImportForm'])
        ->name('students.import.form');

    Route::post('/students/import', [StudentController::class, 'importFromJson'])
        ->name('students.import');

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


    Route::get('/students/{student}/payments/create', [PaymentController::class, 'create']) ->name('payments.create');;
    Route::post('/students/{student}/payments', [PaymentController::class, 'store']) ->name('payments.store');;
    Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
    Route::get('/payments/{payment}/edit', [PaymentController::class, 'edit'])->name('payments.edit');
    Route::put('/payments/{payment}', [PaymentController::class, 'update'])->name('payments.update');
    Route::delete('/payments/{payment}', [PaymentController::class, 'destroy'])->name('payments.destroy');

    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
   
});


Route::get('/', function () {
    return view('welcome');
});
