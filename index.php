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
    <script>document.documentElement.setAttribute('data-theme', localStorage.getItem('theme') || 'dark');</script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wampoon Dashboard - Portable Windows, Apache, MySQL, and PHP</title>
    <link rel="stylesheet" href="assets/css/tokens.css?v=<?=filemtime('assets/css/tokens.css'); ?>" type="text/css">
    <link rel="stylesheet" href="assets/css/dashboard.css?v=<?=filemtime('assets/css/dashboard.css'); ?>" type="text/css">
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
                <a href="../phpmyadmin/" class="nav-link phpmyadmin" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <ellipse cx="12" cy="5" rx="9" ry="3"></ellipse>
                        <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path>
                        <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path>
                    </svg>
                    <span>phpMyAdmin</span>
                </a>
                <a href="phpinfo.php" class="nav-link phpinfo">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M12 16v-4"></path>
                        <path d="M12 8h.01"></path>
                    </svg>
                    <span>PHP Info</span>
                </a>
            </div>
        </div>

        <div class="main-content">

            <div class="quick-links">
                <div class="quick-links-header">
                    <div class="quick-links-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                    </div>
                    <div>
                        <h3>Deployed Apps</h3>
                        <p class="quick-links-subtitle">Projects and files in your htdocs directory</p>
                    </div>
                </div>
                <div class="links-grid" id="htdocs-links">
                    <?php
                    // Generate the quick links.
                    echo $quickLinksGenerator->generateQuickLinks();
                    ?>
                </div>
            </div>


        </div>

        <div class="footer">
            <div class="footer-content">
                <div class="footer-brand">
                    <span class="footer-logo">Wampoon</span>
                    <span class="footer-tagline">A portable Windows Apache MySQL PHP stack</span>
                </div>
                <div class="footer-links">
                    <a class="footer-link" href="https://github.com/frostybee" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path>
                        </svg>
                        FrostyBee
                    </a>
                    <span class="footer-divider"></span>
                    <a class="footer-link" href="https://github.com/wampoon-box/wampoon-dashboard/issues" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                        Report Issue
                    </a>
                </div>
                <div class="footer-copyright">
                    &copy; 2025 &dash; present
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/theme.js?v=<?=filemtime('assets/js/theme.js'); ?>"></script>
    <script>
        
    </script>
</body>
</html>