<?php
declare(strict_types=1);

$config = require_once 'config.php';
require_once 'functions.php';
require_once 'AlertHelper.php';
require_once 'QuickLinksGenerator.php';

$quickLinksGenerator = new QuickLinksGenerator($config);

?>
