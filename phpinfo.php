<?php
// Display PHP information with custom styling
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Configuration - PWAMP Dashboard</title>
    <link rel="stylesheet" href="css/dashboard.css?v=<?php echo time(); ?>" type="text/css">
    <style>       
        .content {
            padding: 20px;
        }        
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>PHP Configuration Information</h1>
            <p>PWAMP - PHP <?php echo PHP_VERSION; ?></p>
        </div>
        <div class="content">
            <a href="index.php" class="back-button">&larr; Back to Dashboard</a>
            <?php                        
            phpinfo();            
            ?>
        </div>
    </div>
</body>
</html>