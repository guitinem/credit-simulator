<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoanController;

Route::post('/loan-simulate', [LoanController::class, 'simulate'])->name('api.loanSimulate.simulate');

Route::fallback(function (){
    return response()->json([
        'message' => 'resource not found.'
    ], 404);
});
