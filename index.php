<?php
declare(strict_types=1);
require_once 'includes/boostrap.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wampoon Dashboard - Portable Windows, Apache, MySQL, and PHP</title>
    <link rel="stylesheet" href="assets/css/tokens.css?v=<?=time(); ?>" type="text/css">
    <link rel="stylesheet" href="assets/css/dashboard.css?v=<?=time(); ?>" type="text/css">
    <link rel="icon" href="assets/favicon.ico" type="image/x-icon">
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-content">
                <img src="assets/dashboard.png" alt="Wampoon Logo" class="header-logo">
                <div class="header-text">
                    <h1>Wampoon Dashboard</h1>
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


        </div>

        <div class="footer">
            <p>Wampoon &dash; a portable Windows Apache MySQL PHP stack. <br>
            &copy; 2025 &dash; present            
                <a class="footer-link" href="https://github.com/frostybee" target="_blank">FrostyBee </a> 
                &middot; <a class="footer-link" href="https://github.com/frostybee/pwamp/issues" target="_blank">GitHub Issues</a>
            </p>
        </div>
    </div>

    <script src="assets/js/theme.js?v=<?=time(); ?>"></script>
    <script>
        
    </script>
</body>
</html>