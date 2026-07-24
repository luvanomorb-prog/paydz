<?php

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// 1. إذا كان طلب ملف مادي ملموس داخل public (js, css, images) أرجعه مباشرة
if ($uri !== '/' && file_exists(__DIR__ . '/public' . $uri)) {
    return false;
}

// 2. توجيه بيئة PHP لمجلد public حتى تتعرف جميع الـ Routes (سواء GET أو POST) على index.php
chdir(__DIR__ . '/public');
require_once __DIR__ . '/public/index.php';
