<?php
/**
 * Created by PhpStorm.
 * User: andrewmyers
 * Date: 3/25/17
 * Time: 3:36 PM
 */

//--------------------
//GETS user DATABASE INFO ON LOGGED IN USER
//saves in array called %user_info['column']
//--------------------

include 'connection.php';

global $db;
$query9 = 'SELECT * FROM users WHERE email = :email';
$statement6 = $db->prepare($query9);
$statement6->bindValue(':email', $_SESSION['email']);
$statement6->execute();

$user_info= $statement6->fetch();
$statement6->closeCursor();