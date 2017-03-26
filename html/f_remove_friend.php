<?php
/**
 * Created by PhpStorm.
 * User: andrewmyers
 * Date: 3/25/17
 * Time: 10:36 PM
 */

include 'connection.php';
function remove_friend($follower_id, $friend_id) {
    global $db;
    $query =  'DELETE FROM followers
                  WHERE (follower = :follower AND following = :following)';

    $statement = $db->prepare($query);
    $statement->bindValue(':follower', $follower_id);
    $statement->bindValue(':following', $friend_id);
    $statement->execute();

    $lnames = $statement->fetchAll();

    $statement->closeCursor();

    return $lnames;
}