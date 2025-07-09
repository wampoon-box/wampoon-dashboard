<?php
declare(strict_types=1);
require_once 'includes/boostrap.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WAMPoon Dashboard - Portable Windows, Apache, MySQL, and PHP</title>
    <link rel="stylesheet" href="assets/css/tokens.css?v=<?=time(); ?>" type="text/css">
    <link rel="stylesheet" href="assets/css/dashboard.css?v=<?=time(); ?>" type="text/css">
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-content">
                <div class="header-text">
                    <h1>WAMPoon Dashboard</h1>
                    <p class="subtitle-bold-first"><span>P</span>ortable <span>W</span>indows&comma; <span>A</span>pache&comma; <span>M</span>ySQL&comma; and <span>P</span>HP</p>
                </div>
                <button class="theme-toggle" id="themeToggle" aria-label="Toggle theme">
                    <svg class="theme-icon sun-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="5"></circle>
                        <path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"></path>
                    </svg>
                    <svg class="theme-icon moon-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                    </svg>
                </button>
            </div>
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
                        <div class="info-label">WAMPoon Version</div>
                        <div class="info-value"><?=hsc($config['versions']['wampoon']); ?></div>
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
            <p>WAMPoon &dash; Portable Windows Apache MySQL PHP stack. <br>
            &copy; 2025 &dash; present            
                <a class="footer-link" href="https://github.com/frostybee" target="_blank">FrostyBee </a> 
            </p>
        </div>
    </div>

    <script src="assets/js/theme.js?v=<?=time(); ?>"></script>
    <script>
        document.addEventListener('DOMContentLoaded', ()=> {
            // Load system information
            document.getElementById('install-path').textContent = window.location.pathname.replace('/apps/wampoon-dashboard/index.html', '');
            
            // Load versions from PHP config
            document.getElementById('apache-version').textContent = '<?=hsc($config['versions']['apache']); ?>';
            document.getElementById('mysql-version').textContent = '<?=hsc($config['versions']['mysql']); ?>';
            document.getElementById('php-version').textContent = '<?=hsc($config['versions']['php']); ?>';
        });        
    </script>
</body>
</html>