<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 6/15/2016
 * Time: 10:16 PM
 */

function check_user_emails($email) {
    global $db;
    $query =  'SELECT email FROM users WHERE email = :email';

    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->execute();

    $users = $statement->fetchAll();

    $statement->closeCursor();

    return $users;
}