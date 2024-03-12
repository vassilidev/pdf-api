<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StreamContractPDFController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Contract $contract)
    {
        $html = Str::replace(
            search: array_keys($contract->data),
            replace: array_values($contract->data),
            subject: $contract->content,
        );

        return Pdf::loadHTML($html)
            ->stream($contract->name . '.pdf');
    }
}
