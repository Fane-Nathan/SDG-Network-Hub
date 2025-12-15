<?php
// Configure Laravel for Vercel's serverless environment
// These settings override .env for serverless compatibility

// Create writable directories in /tmp (only writable location on serverless)
$tmpDirs = [
    '/tmp/bootstrap/cache',
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
];

foreach ($tmpDirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Copy bootstrap cache files if they exist (packages.php, services.php)
$bootstrapCacheFiles = ['packages.php', 'services.php'];
$sourceBootstrapCache = __DIR__ . '/../bootstrap/cache';
foreach ($bootstrapCacheFiles as $file) {
    $source = $sourceBootstrapCache . '/' . $file;
    $dest = '/tmp/bootstrap/cache/' . $file;
    if (file_exists($source) && !file_exists($dest)) {
        copy($source, $dest);
    }
}

// Set environment variables for serverless
$_ENV['VIEW_COMPILED_PATH'] = '/tmp/storage/framework/views';
$_ENV['LOG_CHANNEL'] = 'stderr';
$_ENV['SESSION_DRIVER'] = 'cookie';
$_ENV['CACHE_STORE'] = 'array';
$_ENV['QUEUE_CONNECTION'] = 'sync';

// Override the bootstrap cache path by defining the constant before Laravel loads
define('LARAVEL_BOOTSTRAP_CACHE_PATH', '/tmp/bootstrap/cache');

// Forward the request to the Laravel entry point
require __DIR__ . '/../public/index.php';