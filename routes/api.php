<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

Route::get('pictures', [ApiController::class, 'pictures']);
Route::post('pictures/{picture}/like', [ApiController::class, 'likePicture']);
Route::get('categories', [ApiController::class, 'categories']);

//Auth routes

Route::post('register', [ApiController::class, 'register']);
Route::post('login', [ApiController::class, 'login']);
