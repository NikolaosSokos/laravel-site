<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;

Route::get('/event/{event_id}', [EventController::class, 'show']);
