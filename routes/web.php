<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/{link:slug}', [App\Http\Controllers\LinkController::class, 'show'])
    ->where('slug', '[a-zA-Z0-9\-_]+')
    ->name('links.show');
