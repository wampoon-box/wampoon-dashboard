<?php
// Display PHP information with custom styling
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Configuration - PWAMP Dashboard</title>
    <link rel="stylesheet" href="css/tokens.css?v=<?php echo time(); ?>" type="text/css">
    <link rel="stylesheet" href="css/dashboard.css?v=<?php echo time(); ?>" type="text/css">
    <link rel="stylesheet" href="css/phpinfo.css?v=<?php echo time(); ?>" type="text/css">
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-content">
                <div class="header-text">
                    <h1>PHP Configuration Information</h1>
                    <p class="subtitle-bold-first">PWAMP - PHP <?php echo PHP_VERSION; ?></p>
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
        
        <div class="content">
            <a href="index.php" class="back-button">Back to Dashboard</a>
            
            <div class="phpinfo-container">
                <?php                        
                phpinfo();            
                ?>
            </div>
        </div>
    </div>
    
    <script src="js/theme.js?v=<?php echo time(); ?>"></script>
</body>
</html>