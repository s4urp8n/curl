<?php
ob_implicit_flush(true);
ini_set('implicit_flush', 1);

echo passthru('php phpunit.phar --bootstrap="tests/bootstrap.php"');