<?php
declare(strict_types=1);
require_once 'includes/boostrap.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PWAMP Dashboard - Portable Windows Apache MySQL PHP</title>
    <link rel="stylesheet" href="css/dashboard.css?v=<?=time(); ?>" type="text/css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>PWAMP Dashboard</h1>
            <p class="subtitle-bold-first"><span>P</span>ortable <span>W</span>indows <span>A</span>pache <span>M</span>ySQL <span>P</span>HP</p>
        </div>

        <div class="navigation">
            <div class="nav-links">
                <a href="../phpmyadmin/" class="nav-link phpmyadmin" target="_blank">phpMyAdmin</a>                
                <a href="phpinfo.php" class="nav-link" >PHP Info</a>
            </div>
        </div>

        <div class="main-content">

            <div class="quick-links">
                <h3>Quick Links</h3>
                <div class="links-grid" id="htdocs-links">
                    <?php               
                    // Generate the quick links.
                    echo $quickLinksGenerator->generateQuickLinks();
                    ?>
                </div>
            </div>

            <div class="system-info">
                <h3>System Information</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">PWAMP Version</div>
                        <div class="info-value"><?=hsc($config['versions']['pwamp']); ?></div>
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
            
            // Load versions from PHP config
            document.getElementById('apache-version').textContent = '<?=hsc($config['versions']['apache']); ?>';
            document.getElementById('mysql-version').textContent = '<?=hsc($config['versions']['mysql']); ?>';
            document.getElementById('php-version').textContent = '<?=hsc($config['versions']['php']); ?>';
        
        });        
    </script>
</body>
</html>