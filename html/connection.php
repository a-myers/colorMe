<?php
/**
 * Created by PhpStorm.
 * User: andrewmyers
 * Date: 3/25/17
 * Time: 5:42 AM
 */


$dsn = 'mysql:host=localhost;dbname=colorMe';
$username= 'colorMe';
$password = 'wOI^HH1!l3xx';
try {
    $db = new PDO($dsn, $username, $password);
//    echo '<p>You are connected to the database!</p>';
} catch(PDOException $e) {
    $error_message = $e->getMessage();
    echo "<p>An error occurred while connecting to the database: $error_message</p>";
}