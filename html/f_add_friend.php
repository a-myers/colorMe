<?php
/**
 * Created by PhpStorm.
 * User: andrewmyers
 * Date: 3/25/17
 * Time: 10:36 PM
 */

include 'connection.php';
function add_friend($follower_id, $friend_id) {
    global $db;
    $query =  'INSERT INTO followers (follower, following)
                  VALUES (:follower, :following)';

    $statement = $db->prepare($query);
    $statement->bindValue(':follower', $follower_id);
    $statement->bindValue(':following', $friend_id);
    $statement->execute();

    $lnames = $statement->fetchAll();

    $statement->closeCursor();

    return $lnames;
}