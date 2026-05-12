<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Hash;

require __DIR__.'/vendor/autoload.php';

$app = Application::configure(basePath: __DIR__)
    ->withRouting(
        web: __DIR__.'/routes/web.php',
        commands: __DIR__.'/routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectUsersTo('dashboard');
        $middleware->redirectGuestsTo('login');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== Test: Register a new user ===\n";

// Create a fake POST request to test registration
$request = Illuminate\Http\Request::create('/register', 'POST', [
    'name' => 'John Doe',
    'username' => 'johndoe',
    'password' => 'secretpass123',
    'password_confirmation' => 'secretpass123',
]);
$request->headers->set('Accept', 'text/html');

try {
    $response = $app->handle($request);
    echo "Response status: " . $response->getStatusCode() . "\n";
    echo "Redirect location: " . ($response->headers->get('Location') ?? 'none') . "\n";

    if ($response->getStatusCode() == 302) {
        $location = $response->headers->get('Location');
        if (strpos($location, 'login') !== false) {
            echo "PASS: User redirected to login after successful registration\n";
        } else {
            echo "FAIL: Unexpected redirect location\n";
        }
    }
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}

// Verify user exists
$user = \App\Models\User::where('username', 'johndoe')->first();
echo "User in DB: " . ($user ? "YES (id={$user->id})" : "NO") . "\n";

if ($user) {
    echo "Password hash set: " . (strlen($user->password) > 0 ? "YES" : "NO") . "\n";
    echo "Password verify: " . (Hash::check('secretpass123', $user->password) ? "YES" : "NO") . "\n";
}

echo "\n=== Test: Login ===\n";

$loginRequest = Illuminate\Http\Request::create('/login', 'POST', [
    'username' => 'johndoe',
    'password' => 'secretpass123',
]);
$loginRequest->headers->set('Accept', 'text/html');

$response = $app->handle($loginRequest);
echo "Response status: " . $response->getStatusCode() . "\n";
echo "Redirect location: " . ($response->headers->get('Location') ?? 'none') . "\n";

if ($response->getStatusCode() == 302) {
    $location = $response->headers->get('Location');
    if (strpos($location, 'dashboard') !== false || strpos($location, 'dashboard') !== false) {
        echo "PASS: User redirected to dashboard after login\n";
    } else {
        echo "INFO: Redirected to: $location\n";
    }
}

echo "\n=== All Tests Complete ===\n";