<?php

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// إذا كان الطلب يستهدف ملفاً حقيقياً داخل public (مثل js, css, images) أرجعه مباشرة
if ($uri !== '/' && file_exists(__DIR__ . '/public' . $uri)) {
    return false;
}

// بالنسبة لباقي المسارات، وجه كافة الطلبات إلى index.php الخاص بـ Laravel
require_once __DIR__ . '/public/index.php';
