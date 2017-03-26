<?php
/**
 * Created by PhpStorm.
 * User: andrewmyers
 * Date: 3/25/17
 * Time: 10:36 PM
 */

include 'connection.php';
function add_friend_search($follower_id, $friend_name) {

    global $db;

    $querys = 'SELECT id FROM users WHERE lname = :lname';
    $statements = $db->prepare($querys);
    $statements->bindValue(':lname', $friend_name);
    $statements->execute();

    $friend_id = $statements->fetch();
    $statements->closeCursor();


    $query =  'INSERT INTO followers (follower, following)
                  VALUES (:follower, :following)';

    $statement = $db->prepare($query);
    $statement->bindValue(':follower', $follower_id);
    $statement->bindValue(':following', $friend_id['id']);
    $statement->execute();

    $lnames = $statement->fetchAll();

    $statement->closeCursor();

    return $lnames;
}