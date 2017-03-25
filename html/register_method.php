<?php
/**
 * Created by PhpStorm.
 * User: andrewmyers
 * Date: 3/25/17
 * Time: 6:14 AM
 */

include 'connection.php';


$fname = filter_input(INPUT_POST, 'fname');
$password = filter_input(INPUT_POST, 'password');
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$phone = filter_input(INPUT_POST, 'phone');

$hpassword = password_hash($password, PASSWORD_DEFAULT);

    global $db;
    $query = "INSERT INTO users (fname, email, password, phone)
                  VALUES (:fname, :email, :password, :phone)";

    $statement = $db->prepare($query);

    $statement->bindValue(':fname', $fname);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':password', $hpassword);
    $statement->bindValue(':phone', $phone);


    $statement->execute();

    $statement->closeCursor();
