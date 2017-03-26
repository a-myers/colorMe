<?php
/**
 * Created by PhpStorm.
 * User: andrewmyers
 * Date: 3/25/17
 * Time: 7:01 AM
 */

//--------------------
//VERIFIES PASSWORD MATCHES STORED PWD
//returns FALSE if not, TRUE if yes
//--------------------

function verify_account($email, $password){
    global $db;

    $query = "SELECT * FROM users WHERE email = :email";

    $statement = $db->prepare($query);
    $statement->bindValue(":email", $email);
    $statement->execute();

    $account = $statement->fetch();

    $statement->closeCursor();

    $is_verified = password_verify($password, $account['password']);

    return $is_verified;
}