<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class StreamContractPDFController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Contract $contract)
    {
        $html = $contract->content;

        if ($contract->data) {
            $html = Str::replace(
                search: array_keys($contract->data),
                replace: array_values($contract->data),
                subject: $html,
            );
        }

        $html = $this->embedImages($html);

        return Pdf::loadHTML($html)
            ->stream($contract->name . '.pdf');
    }

    /**
     * Embed images in HTML content as base64-encoded data.
     */
    private function embedImages($html)
    {
        $pattern = '/<img[^>]+src="([^"]+)"[^>]*>/i';

        $callback = static function ($matches) {
            try {
                $imageUrl = $matches[1];

                $imageContent = Http::get($imageUrl)->body();

                $base64 = base64_encode($imageContent);

                $dataUri = 'data:image/' . pathinfo($imageUrl, PATHINFO_EXTENSION) . ';base64,' . $base64;

                return '<img src="' . $dataUri . '">';
            } catch (\Exception $exception) {
                Log::error($exception->getMessage());
            }

            return '';
        };

        return preg_replace_callback($pattern, $callback, $html);
    }
}
