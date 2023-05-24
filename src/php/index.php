
<?php
$db_name = $_ENV['DB_NAME'] ? $_ENV['DB_NAME'] : 'public';
$user = $_ENV['DB_USER'] ? $_ENV['DB_USER'] : 'root';
$pass = $_ENV['DB_PASSWORD'];

try {
    $dbh = new PDO("mysql:host=db;port=3306;dbname=$db_name", $user, $pass);
    echo "Connected to DB!";
    echo "<br/>";
    print_r($dbh->query('SHOW TABLES')->fetchAll());

} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>
