<?php
// Configure Laravel for Vercel's serverless environment
// The bootstrap/app.php handles path redirection, but we need to set env vars

// Set environment variables for serverless
$_ENV['VERCEL'] = '1';
$_ENV['LOG_CHANNEL'] = 'stderr';
$_ENV['SESSION_DRIVER'] = 'cookie';
$_ENV['CACHE_STORE'] = 'array';
$_ENV['QUEUE_CONNECTION'] = 'sync';

// Forward the request to the Laravel entry point
require __DIR__ . '/../public/index.php';