



<?php
/**
 * Created by PhpStorm.
 * User: andrewmyers
 * Date: 3/25/17
 * Time: 1:38 PM
 */

include 'get_user_info.php';
if(isset($_POST['remove-friend'])) {
    include 'get_user_info.php';
    $follower = $user_info['id'];
    include 'f_remove_friend.php';
    $following = $_POST['friend_id'];
    remove_friend($follower, $following);
}

global $db;
$query = "SELECT following FROM followers WHERE follower = :follower";
$statement = $db->prepare($query);
$statement->bindValue(':follower', $user_info['id']);
$statement->execute();
$friends= $statement->fetchAll();
$statement->closeCursor();
//echo $user_info['id'];
//echo $friends;
//var_dump($friends);
//var_dump($feed);
//echo $feed[0];
//echo $feed[1];
$array = array();

foreach($friends as $a){
    array_push($array, $a[0]);
}

$sql = "SELECT * FROM users WHERE id IN (" . implode(',', array_map('intval', $array)).") ORDER BY last_change DESC";
$statement = $db->prepare($sql);
$statement->execute();
$feed = $statement->fetchAll();
$statement->closeCursor();


foreach($feed as $row){

    $delta_time = time() - strtotime($row['last_change']);
    $hours = floor($delta_time / 3600);
    $hours -= 5;
    $d_seconds = $delta_time;
    $delta_time %= 3600;
    $minutes = floor($delta_time / 60);
    $d_seconds %= 86400;
    $seconds = floor($delta_time / 60);
    ?> <tr>

        <td><div class="circle" style="background-color: #<?php echo $row['color']; ?>"><span class="circle glyphicon glyphicon-remove-sign" style="visibility: hidden;"></span></div></td>
        <td><?php echo $row['lname'];?></td>
        <td>
            <?php
            if($hours == 1) {
                echo "updated 1 hour ago";
            } elseif($hours > 1) {
                echo "updated {$hours} hours ago";
            }  elseif($minutes == 1) {
                echo "updated 1 minute ago";
            } elseif($minutes > 1) {
                echo "updated {$minutes} minutes ago";
            } elseif($seconds <= 10) {
                echo "updated just now";
            } else {
                echo "updated {$seconds} seconds ago";
            }
            ?>
        </td>

        <td><form class="no-margins" action="<?=$_SERVER['PHP_SELF'];?>" method="post" role="form">
                <input type=hidden id="category" name="friend_id" value="<?php echo $row['id']; ?>">
                <button type="submit" class="button-feed" name="remove-friend"><span class="glyphicon glyphicon-minus-sign button-f-glyph" aria-hidden="true"></span></button>
            </form></td>
    </tr> <?php
}