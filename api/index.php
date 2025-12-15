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

// Force PostgreSQL database connection for Neon
// These override any .env settings
setEnvVar('DB_CONNECTION', 'pgsql');
setEnvVar('DB_HOST', 'ep-muddy-bread-ah8zkeoz-pooler.c-3.us-east-1.aws.neon.tech');
setEnvVar('DB_PORT', '5432');
setEnvVar('DB_DATABASE', 'neondb');
setEnvVar('DB_USERNAME', 'neondb_owner');
setEnvVar('DB_PASSWORD', 'npg_oJADg6GxR3MT');
setEnvVar('DB_SSLMODE', 'require');

// Forward the request to the Laravel entry point
require __DIR__ . '/../public/index.php';