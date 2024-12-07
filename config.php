<?php

function tt($str){
    echo "<pre>";
        print_r($str);
    echo "</pre>";
}
function tte($str){
    echo "<pre>";
        print_r($str);
    echo "</pre>";
    exit();
}
// config.php

define('APP_BASE_PATH', '');

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'root');
define('DB_NAME', 'mini_crm');

define('START_ROLE', 1);

