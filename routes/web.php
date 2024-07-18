<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;

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

Route::get('/redirect', function (Request $request) {
    $request->session()->put('state', $state = Str::random(40));
 
    $query = http_build_query([
        'client_id' => '9c8c04b6-79c1-4333-a47a-6424c4850b37',
        'redirect_uri' => 'http://127.0.0.1:8001/callback',
        'response_type' => 'code',
        'scope' => '',
        'state' => $state,
        // 'prompt' => '', // "none", "consent", or "login"
    ]);
 
    return redirect('http://127.0.0.1:8000/oauth/authorize?'.$query);
});


Route::get('/callback', function (Request $request) {
    $state = $request->session()->pull('state');
 
    /*throw_unless(
        strlen($state) > 0 && $state === $request->state,
        InvalidArgumentException::class,
        'Invalid state value.'
    );*/
 
    $response = Http::asForm()->post('http://127.0.0.1:8000/oauth/token', [
        'grant_type' => 'authorization_code',
        'client_id' => '9c8c04b6-79c1-4333-a47a-6424c4850b37',
        'client_secret' => 'oM7rUqtBj5F9kmLVv7hjox8qbhPVBo1bPWDmL1xl',
        'redirect_uri' => 'http://127.0.0.1:8001/callback',
        'code' => $request->code,
    ]);

    $token = $response->json()['access_token'];

    $userResponse = Http::withToken($token)->get('http://127.0.0.1:8000/api/user');
    $userData = $userResponse->json();

    $user = User::updateOrCreate(
        ['email' => $userData['email']], 
        ['name' => $userData['name']],
    );

    // Fazer login do usuário
    Auth::login($user);
 
    return redirect('/');
 
    //return $response->json();
});