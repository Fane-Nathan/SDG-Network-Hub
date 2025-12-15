<?php
// Configure Laravel for Vercel's serverless environment
// The bootstrap/app.php handles path redirection, but we need to set env vars

// Helper function to set environment variables in all locations Laravel checks
function setEnvVar($key, $value) {
    $_ENV[$key] = $value;
    $_SERVER[$key] = $value;
    putenv("$key=$value");
}

// Mark as serverless
setEnvVar('VERCEL', '1');

// Serverless-compatible settings
setEnvVar('LOG_CHANNEL', 'stderr');
setEnvVar('SESSION_DRIVER', 'cookie');
setEnvVar('CACHE_STORE', 'array');
setEnvVar('QUEUE_CONNECTION', 'sync');

// Database connection - use Vercel env vars or defaults
// These ensure pgsql is used even if .env has sqlite
if (getenv('DB_CONNECTION') === false || getenv('DB_CONNECTION') === 'sqlite') {
    // Force pgsql if DB_HOST is set (Vercel env vars)
    if (isset($_SERVER['DB_HOST']) && !empty($_SERVER['DB_HOST'])) {
        setEnvVar('DB_CONNECTION', 'pgsql');
    }
}

// Forward the request to the Laravel entry point
require __DIR__ . '/../public/index.php';