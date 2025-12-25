<?php
declare(strict_types=1);
// Get configuration from server environment
$htdocs_path = $_SERVER['DOCUMENT_ROOT'] ?? '..';
$server_port = $_SERVER['SERVER_PORT'] ?? '80';
$server_name = $_SERVER['SERVER_NAME'] ?? 'localhost';
$is_https = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') || 
            (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] === '443');
$protocol = $is_https ? 'https' : 'http';

return [
    'apache_port_number' => $server_port,
    'htdocs_path' => $htdocs_path,
    'server_hostname' => $protocol . '://' . $server_name,
];
