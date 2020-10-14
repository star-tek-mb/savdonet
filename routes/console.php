<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('register:admin', function() {
    $name = $this->ask('Name');
    $email = $this->ask('Email');
    $password = $this->secret('Password');
    $user = new App\Models\User;
    $user->forceFill([
        'name' => $name,
        'email' => $email,
        'password' => Hash::make($password),
        'role' => 'admin'
    ]);
    $user->save();
});
