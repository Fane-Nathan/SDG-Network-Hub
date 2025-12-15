<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Detect serverless environment and configure writable paths
$isServerless = isset($_ENV['VERCEL']) || isset($_ENV['AWS_LAMBDA_FUNCTION_NAME']) || strpos(__DIR__, '/var/task') !== false;

// Create the application with custom paths for serverless
$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

// Override bootstrap cache path for serverless environments
if ($isServerless) {
    $bootstrapCachePath = '/tmp/bootstrap/cache';
    if (!is_dir($bootstrapCachePath)) {
        mkdir($bootstrapCachePath, 0755, true);
    }
    $app->useBootstrapPath('/tmp/bootstrap');
    $app->useStoragePath('/tmp/storage');
    
    // Create storage subdirectories
    $storageDirs = [
        '/tmp/storage/framework/views',
        '/tmp/storage/framework/cache',
        '/tmp/storage/framework/sessions',
        '/tmp/storage/logs',
    ];
    foreach ($storageDirs as $dir) {
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
    }
}

return $app;
