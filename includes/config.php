<?php
declare(strict_types=1);

// Load version information
$versions = require_once __DIR__ . '/versions.php';

// Determine environment - default to DEV
// This can be set to 'PROD' or 'DEV' based on your deployment.
$environment = 'DEV';

// Set htdocs path based on environment
if ($environment === 'DEV') {
    $htdocs_path = '..';  // We're in htdocs/wampoon-dashboard, so htdocs is parent
} else if ($environment === 'PROD') {
    $htdocs_path = '../../htdocs';  // We're in apps/wampoon-dashboard
} else {
    // Default fallback
    $htdocs_path = '..';
}

$config = [
    'apache_port_number' => '80',
    'htdocs_path' => $htdocs_path,
    'server_hostname' => 'http://localhost',
    'versions' => $versions
];
