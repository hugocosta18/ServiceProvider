<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use App\Http\Controllers\PostController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('posts', [PostController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('posts.index');

Route::post('posts', [PostController::class, 'store'])
    ->middleware(['auth', 'verified'])
    ->name('posts.store');


Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/redirect', function (Request $request) {
    $request->session()->put('state', $state = Str::random(40));
 
    $query = http_build_query([
        'client_id' => config('services.passport.client_id'),
        'redirect_uri' => config('services.passport.redirect_uri'),
        'response_type' => 'code',
        'scope' => '',
        'state' => $state,
        // 'prompt' => '', // "none", "consent", or "login"
    ]);

    return redirect (config('services.passport.url') . '/oauth/authorize?' . $query);
});


Route::get('/callback', function (Request $request) {
    $state = $request->session()->pull('state');
 
    /*throw_unless(
        strlen($state) > 0 && $state === $request->state,
        InvalidArgumentException::class,
        'Invalid state value.'
    );*/
 
    $response = Http::asForm()->post(config('services.passport.url') . '/oauth/token', [
        'grant_type' => 'authorization_code',
        'client_id' => config('services.passport.client_id'),
        'client_secret' => config('services.passport.client_secret'),
        'redirect_uri' => config('services.passport.redirect_uri'),
        'code' => $request->code,
    ]);

    $token = $response->json()['access_token'];

    $userResponse = Http::withToken($token)->get(config('services.passport.url') . '/api/user');
    $userData = $userResponse->json();

    $user = User::updateOrCreate(
        
        ['email' => $userData['email']],
        [
            'name' => $userData['name'],
            'password' => Hash::make(Str::random(24)),
        ],
    
    );

  
    Auth::login($user);

    return redirect('/posts');
});

require __DIR__.'/auth.php';
