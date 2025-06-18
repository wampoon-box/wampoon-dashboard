<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PWAMP Dashboard - Portable Windows Apache MySQL PHP</title>
    <link rel="stylesheet" href="css/dashboard.css" type="text/css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>PWAMP Dashboard</h1>
            <p>Portable Windows Apache MySQL PHP</p>
        </div>

        <div class="navigation">
            <div class="nav-links">
                <a href="../phpmyadmin/" class="nav-link" target="_blank" style="background-color: green;">phpMyAdmin</a>                
                <a href="phpinfo.php" class="nav-link" >PHP Info</a>
            </div>
        </div>

        <div class="main-content">

            <div class="quick-links">
                <h3>Quick Links</h3>
                <div class="links-grid" id="htdocs-links">
                    <?php
                    $htdocsPath = '../../htdocs';
                    $root_hostname = 'http://localhost/';
                    if (is_dir($htdocsPath)) {
                        $items = scandir($htdocsPath);
                        $items = array_filter($items, function($item) {
                            return $item !== '.' && $item !== '..';
                        });
                        
                        if (count($items) > 0) {
                            foreach ($items as $item) {
                                $itemPath = $htdocsPath . '/' . $item;
                                $isDir = is_dir($itemPath);
                                $iconClass = $isDir ? 'icon-folder' : 'icon-file';
                                $href = $root_hostname.urlencode($item);                                
                                echo '<a href="' . htmlspecialchars($href) . '" class="btn btn-primary ' . $iconClass . '" target="_blank">' . htmlspecialchars($item) . '</a>';
                            }
                        } else {
                            echo '<p style="color: #6c757d;">Document root is empty</p>';
                        }
                    } else {
                        echo '<p style="color: #dc3545;">Unable to access document root</p>';
                    }
                    ?>
                </div>
            </div>

            <div class="system-info">
                <h3>System Information</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">PWAMP Version</div>
                        <div class="info-value">1.0.0</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Installation Path</div>
                        <div class="info-value" id="install-path">Loading...</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Apache Version</div>
                        <div class="info-value" id="apache-version">Loading...</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">MySQL Version</div>
                        <div class="info-value" id="mysql-version">Loading...</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">PHP Version</div>
                        <div class="info-value" id="php-version">Loading...</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Platform</div>
                        <div class="info-value">Windows</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer">
            <p>PWAMP &dash; Portable Windows Apache MySQL PHP stack. <br>
            &copy; 2025 &dash; present            
                <a class="footer-link" href="https://github.com/frostybee" target="_blank">FrostyBee </a> 
            </p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', ()=> {
        
            // Load system information
            document.getElementById('install-path').textContent = window.location.pathname.replace('/apps/pwamp-dashboard/index.html', '');
            
            // These would be loaded from actual system queries
            document.getElementById('apache-version').textContent = 'Apache/2.4.63';
            document.getElementById('mysql-version').textContent = 'MariaDB 11.7.2';
            document.getElementById('php-version').textContent = 'PHP 8.4.7';
        
        });        
    </script>
</body>
</html>