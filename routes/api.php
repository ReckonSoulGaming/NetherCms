<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MCCMSController;

Route::prefix('mccms')
    ->middleware(['server.verify', 'throttle:500,1'])
    ->group(function () {
        Route::get('add', [MCCMSController::class, 'add']);
        Route::get('pending', [MCCMSController::class, 'pending']);
        Route::get('done', [MCCMSController::class, 'done']);
        Route::post('log', [MCCMSController::class, 'log']);
    });


Route::get('mccms/debug', function (Request $r) {
    return response()->json([
        'headers_received' => $r->headers->all(),
        'server_id' => $r->header('X-SERVER-ID'),
        'api_key' => $r->header('X-API-KEY'),
        'status' => 'debug_ok'
    ]);
});

Route::post('/run', [MCCMSController::class, 'run']);
