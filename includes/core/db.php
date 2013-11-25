<?php
define("DB_SERVER", "AtriumCodeShare.db.10636816.hostedresource.com");
define("DB_USER", "AtriumCodeShare");
define("DB_PASS", "Goober0829!2");
define("DB_NAME", "AtriumCodeShare");

$db = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

if ($db->connect_error) {
    trigger_error('Database connection failed: '  . $db->connect_error, E_USER_ERROR);
}
?>