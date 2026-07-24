<?php

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// تحديد نوع الـ MIME الصحيح للملفات المادية
if ($uri !== '/' && file_exists(__DIR__ . '/public' . $uri)) {
    $filePath = __DIR__ . '/public' . $uri;
    $extension = pathinfo($filePath, PATHINFO_EXTENSION);

    $mimeTypes = [
        'js'   => 'text/javascript',
        'mjs'  => 'text/javascript',
        'css'  => 'text/css',
        'png'  => 'image/png',
        'jpg'  => 'image/jpeg',
        'svg'  => 'image/svg+xml',
        'ico'  => 'image/x-icon',
        'woff' => 'font/woff',
        'woff2'=> 'font/woff2',
    ];

    if (isset($mimeTypes[$extension])) {
        header("Content-Type: {$mimeTypes[$extension]}");
        readfile($filePath);
        exit;
    }

    return false;
}

// باقي الطلبات تمر مباشرة لـ Laravel
require_once __DIR__ . '/public/index.php';
