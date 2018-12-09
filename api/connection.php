<?php
$servername = "localhost";
$username = "root";
$password = "khadkasu2200";

try {
    $conn = new PDO("mysql:host=$servername;dbname=Big_data", $username, $password);
echo "Conncted";
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
?>
