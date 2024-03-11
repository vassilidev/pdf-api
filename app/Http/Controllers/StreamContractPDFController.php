<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class StreamContractPDFController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Contract $contract)
    {
        return Pdf::loadHTML($contract->content)
            ->stream($contract->name . '.pdf');
    }
}
