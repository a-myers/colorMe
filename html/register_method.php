<?php
/**
 * Created by PhpStorm.
 * User: andrewmyers
 * Date: 3/25/17
 * Time: 6:14 AM
 */

include 'connection.php';


$fname = filter_input(INPUT_POST, 'fname');
$lname = filter_input(INPUT_POST, 'lname');
$password = filter_input(INPUT_POST, 'password');
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$phone = filter_input(INPUT_POST, 'phone');

$hpassword = password_hash($password, PASSWORD_DEFAULT);

    global $db;
    $query = "INSERT INTO users (fname, lname, email, password, phone, color)
                  VALUES (:fname, :lname, :email, :password, :phone, :color)";

    $statement = $db->prepare($query);

    $statement->bindValue(':fname', $fname);
$statement->bindValue(':lname', $lname);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':password', $hpassword);
    $statement->bindValue(':phone', $phone);
    $statement->bindValue(':color', "#7aadff");


    $statement->execute();

    $statement->closeCursor();
