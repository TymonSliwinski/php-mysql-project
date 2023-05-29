<?php
$db_name = $_ENV['DB_NAME'] ? $_ENV['DB_NAME'] : 'public';
$user = $_ENV['DB_USER'] ? $_ENV['DB_USER'] : 'root';
$pass = $_ENV['DB_PASSWORD'];

session_start();

define('ROOT_PATH', realpath(dirname(__FILE__)));
define('BASE_URL', 'http://localhost:8000');
define('ASSETS_ROOT', '/assets');

try {
    $dbh = new PDO("mysql:host=db;port=3306;dbname=$db_name", $user, $pass);
    $GLOBALS['DB'] = $dbh;
    return $dbh;
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>
