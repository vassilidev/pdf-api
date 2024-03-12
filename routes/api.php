<?php

use App\Http\Controllers\Api\ContractController;
use App\Http\Controllers\StreamContractPDFController;
use Illuminate\Support\Facades\Route;

Route::apiResource('contracts', ContractController::class);

Route::get('stream/{contract}', StreamContractPDFController::class)->name('stream.contract');