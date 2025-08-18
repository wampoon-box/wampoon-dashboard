<?php
declare(strict_types=1);
require_once 'includes/boostrap.php';

// Get actual server version
$apacheVersion = isset($_SERVER['SERVER_SOFTWARE']) ? $_SERVER['SERVER_SOFTWARE'] : 'Apache (Unknown)';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wampoon Dashboard - Portable Windows, Apache, MySQL, and PHP</title>
    <link rel="stylesheet" href="assets/css/tokens.css?v=<?=time(); ?>" type="text/css">
    <link rel="stylesheet" href="assets/css/dashboard.css?v=<?=time(); ?>" type="text/css">
    <!-- Favicon links -->  
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon-16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicon-32.png">
    <link rel="icon" type="image/png" sizes="48x48" href="assets/images/favicon-48.png">
    
    <!-- Apple Touch Icon -->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/apple-touch-icon.png">
    
    <!-- Android Chrome Icon -->
    <link rel="icon" type="image/png" sizes="512x512" href="assets/images/android-chrome-512.png">
    
    <!-- Optional: Add a fallback favicon.ico -->    
    <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-content">
                <img src="assets/images/dashboard.png" alt="Wampoon Logo" class="header-logo">
                <div class="header-text">
                    <h1>Wampoon Dashboard</h1>
                    <p class="subtitle-bold-first"><span>P</span>ortable <span>W</span>indows&comma; <span>A</span>pache&comma; <span>M</span>ySQL&comma; and <span>P</span>HP</p>
                    <p class="version-info"><?php echo htmlspecialchars($apacheVersion); ?></p>
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
                <h3>Deployed Apps</h3>
                <div class="links-grid" id="htdocs-links">
                    <?php               
                    // Generate the quick links.
                    echo $quickLinksGenerator->generateQuickLinks();
                    ?>
                </div>
            </div>


        </div>

        <div class="footer">
            <p>Wampoon &dash; A portable Windows Apache MySQL PHP stack. <br>
            &copy; 2025 &dash; present            
                <a class="footer-link" href="https://github.com/frostybee" target="_blank">FrostyBee </a> 
                &middot; <a class="footer-link" href="https://github.com/wampoon-box/wampoon-dashboard/issues" target="_blank">GitHub Issues</a>
            </p>
        </div>
    </div>

    <script src="assets/js/theme.js?v=<?=time(); ?>"></script>
    <script>
        
    </script>
</body>
</html>