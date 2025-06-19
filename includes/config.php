<?php
declare(strict_types=1);

// Load version information
$versions = require_once __DIR__ . '/versions.php';

// Get the name of the dashboard's parent directory.
$parent_dir = basename(dirname(__FILE__, 3));

// We need to get the name of the dashboard's parent directory to know where to find the htdocs directory. 
// This allows us to determine whether we are running the dashboard in DEV or PROD.
// If the dashboard's parent directory is 'htdocs', then we are running the dashboard in DEV.
// If the dashboard's parent directory is 'apps', then we are running the dashboard in PROD.
if ($parent_dir === 'htdocs') {
    $htdocs_path = '../../htdocs';
} else if ($parent_dir === 'apps') {
    $htdocs_path = '../../../htdocs';
}

$config = [
    'apache_port_number' => '80',
    'htdocs_path' => $htdocs_path,
    'server_hostname' => 'http://localhost',
    'versions' => $versions
];
