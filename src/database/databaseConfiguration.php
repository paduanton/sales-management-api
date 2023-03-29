<?php
$env = parse_ini_file(__DIR__ . '/../../.env');

define('DB_USERNAME', $env["DB_USERNAME"]);
define('DB_PASSWORD', $env["DB_PASSWORD"]);
define('DB_HOST', $env["DB_HOST"]);
define('DB_DATABASE', $env["DB_DATABASE"]);
