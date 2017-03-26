<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 6/15/2016
 * Time: 10:16 PM
 */

function check_username($lname) {
    global $db;


    $query =  'SELECT lname FROM users WHERE UPPER(lname) = UPPER(:lname)';

    $statement = $db->prepare($query);
    $statement->bindValue(':lname', $lname);
    $statement->execute();

    $lnames = $statement->fetchAll();

    $statement->closeCursor();

    return $lnames;
}