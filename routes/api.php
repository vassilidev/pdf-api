<?php

use App\Http\Controllers\Api\ContractController;
use Illuminate\Support\Facades\Route;

Route::apiResource('contracts', ContractController::class);