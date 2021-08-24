<?php

use App\Http\Controllers\Api\CovidController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/covid', [CovidController::class, 'index']);

Route::get('/covid/state/', [CovidController::class, 'show']);
