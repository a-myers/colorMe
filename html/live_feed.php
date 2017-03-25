<?php
/**
 * Created by PhpStorm.
 * User: andrewmyers
 * Date: 3/25/17
 * Time: 1:38 PM
 */


global $db;
$query = "SELECT * FROM users ORDER BY last_change DESC";
$statement = $db->prepare($query);
$statement->execute();
$feed= $statement->fetchAll();
$statement->closeCursor();

//var_dump($feed);
//echo $feed[0];
//echo $feed[1];





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

<!--        <td>--><?php //echo $row['color'];?><!--<span class="glyphicon glyphicon-one-fine-red-dot"></span></td>-->

        <td><div class="circle" style="background-color: #<?php echo $row['color']; ?>"><span class="circle glyphicon glyphicon-remove-sign" style="visibility: hidden;"></span></div></td>
        <td><?php echo $row['fname']; echo ' '; echo $row['lname'];?></td>
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
<!--        <td>--><?php //echo $row['last_change'];?><!--</td>-->
    </tr> <?php
}