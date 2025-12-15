<?php
// Configure Laravel for Vercel's serverless environment
// These settings override .env for serverless compatibility

// Set to /tmp which is writable on serverless
$_ENV['VIEW_COMPILED_PATH'] = '/tmp/views';
$_ENV['LOG_CHANNEL'] = 'stderr';
$_ENV['SESSION_DRIVER'] = 'cookie';
$_ENV['CACHE_STORE'] = 'array';
$_ENV['QUEUE_CONNECTION'] = 'sync';

// Create view cache directory if it doesn't exist
if (!is_dir('/tmp/views')) {
    mkdir('/tmp/views', 0755, true);
}

// Forward the request to the Laravel entry point
require __DIR__ . '/../public/index.php';