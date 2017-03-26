<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 6/15/2016
 * Time: 10:16 PM
 */

function check_phone($phone) {
    global $db;
    $query =  'SELECT phone FROM users WHERE phone = :phone';

    $statement = $db->prepare($query);
    $statement->bindValue(':phone', $phone);
    $statement->execute();

    $lnames = $statement->fetchAll();

    $statement->closeCursor();

    return $lnames;
}