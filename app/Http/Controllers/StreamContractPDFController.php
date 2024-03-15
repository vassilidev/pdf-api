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

        $callback = function ($matches) {
            try {
                $imageUrl = $matches[1];
                dump($imageUrl);
                $imageContent = file_get_contents($imageUrl);

                $base64 = base64_encode($imageContent);

                $dataUri = 'data:image/' . $this->getImageMimeType($imageContent) . ';base64,' . $base64;
                dump($dataUri);

//                return '<img src="' . $dataUri . '">';
                echo '<img src="' . $dataUri . '">';

            } catch (\Exception $exception) {
                Log::error($exception->getMessage());
            }

            return '';
        };

        return preg_replace_callback($pattern, $callback, $html);
    }

    private function getBytesFromHexString($hex): string
    {
        $bytes = [];

        for ($count = 0, $countMax = strlen($hex); $count < $countMax; $count += 2) {
            $bytes[] = chr(hexdec(substr($hex, $count, 2)));
        }

        return implode($bytes);
    }

    private function getImageMimeType($base64decoded): ?string
    {
        $imagemimetypes = array(
            "jpeg" => "FFD8",
            "png"  => "89504E470D0A1A0A",
            "gif"  => "474946",
            "bmp"  => "424D",
            "tiff" => "4949",
            "tiff" => "4D4D"
        );

        foreach ($imagemimetypes as $mime => $hexbytes) {
            $bytes = $this->getBytesFromHexString($hexbytes);

            if (str_starts_with($base64decoded, $bytes)) {
                return $mime;
            }
        }

        return NULL;
    }
}
