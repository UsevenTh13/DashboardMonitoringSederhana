<?php

// Vercel Serverless environment overrides (read-only filesystem workaround)
$_ENV['VIEW_COMPILED_PATH'] = '/tmp';
putenv('VIEW_COMPILED_PATH=/tmp');

$_ENV['APP_CONFIG_CACHE'] = '/tmp/config.php';
putenv('APP_CONFIG_CACHE=/tmp/config.php');

$_ENV['APP_EVENTS_CACHE'] = '/tmp/events.php';
putenv('APP_EVENTS_CACHE=/tmp/events.php');

$_ENV['APP_PACKAGES_CACHE'] = '/tmp/packages.php';
putenv('APP_PACKAGES_CACHE=/tmp/packages.php');

$_ENV['APP_ROUTES_CACHE'] = '/tmp/routes.php';
putenv('APP_ROUTES_CACHE=/tmp/routes.php');

$_ENV['APP_SERVICES_CACHE'] = '/tmp/services.php';
putenv('APP_SERVICES_CACHE=/tmp/services.php');

// Forward Vercel requests to normal index.php
require __DIR__ . '/../public/index.php';
