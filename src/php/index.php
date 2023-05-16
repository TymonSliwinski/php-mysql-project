
<?php
$user = $_ENV['DB_USER'] ? $_ENV['DB_USER'] : 'root';
$pass = $_ENV['DB_PASSWORD'];

try {
    $dbh = new PDO('mysql:host=db;port=3306;dbname=public', $user, $pass);
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>
