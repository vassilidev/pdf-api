<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use Dompdf\Options;
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

        $domPdf = new Dompdf();
        $options = new Options();

        $options->setIsRemoteEnabled(true);

        $domPdf->setOptions($options);

        $domPdf->setHttpContext([
            'ssl' => [
                'allow_self_signed' => true,
                'verify_peer'       => false,
                'verify_peer_name'  => false,
            ]
        ]);

        $domPdf->loadHtml($html);

        $domPdf->render();


        $domPdf->stream(options: ['Attachment' => false]);

        exit;
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
