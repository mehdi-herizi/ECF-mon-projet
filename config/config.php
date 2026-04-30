<?php
if (!defined('APP_RUNNING')) {
    header('Location:  /master-gaming/?action=home');
    exit;
}

define('DB_HOST', 'mysql-server');
define('DB_NAME', 'Mastergaming');
define('DB_USER', 'root');
define('DB_PASS', 'root');
define('DB_CHARSET', 'utf8');