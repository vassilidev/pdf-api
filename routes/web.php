<?php

Route::get('test', function () {
    $url = "https://manu.qwile.com/wp-content/uploads/sites/7/2024/03/Asset-2@4x-8.png";

    function get_contents($url, $ua = 'Mozilla/5.0 (Windows NT 5.1; rv:2.0.1) Gecko/20100101 Firefox/4.0.1', $referer = 'http://www.google.com/') {
        if (function_exists('curl_exec')) {
            $header[0] = "Accept-Language: en-us,en;q=0.5";
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_USERAGENT, $ua);
            curl_setopt($curl, CURLOPT_REFERER, $referer);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_TIMEOUT, 10);
            $content = curl_exec($curl);
            curl_close($curl);
        }
        else {
            $content = file_get_contents($url);
        }
        return $content;
    }

    dump(get_contents($url));
});