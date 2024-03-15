<?php

Route::get('test', function () {
    dd(readfile('https://manu.qwile.com/wp-content/uploads/sites/7/2024/03/Asset-2@4x-8.png'));
});