<?php
/**
 * Created by PhpStorm.
 * User: andrewmyers
 * Date: 3/25/17
 * Time: 6:29 AM
 */

//--------------------
//LOGS IN USER
//--------------------

include 'connection.php';

//grabs info from form
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$password = filter_input(INPUT_POST, 'password');


//verify email matches password, return TRUE if yes, FALSE if no
include 'f_verify_account.php';

//if TRUE, log uer in
if(verify_account($email, $password) == TRUE){

    //create session id and store in _SESSION
    $session_id = uniqid("", TRUE);
    $_SESSION['session_id'] = $session_id;

    // updates session id to database
    global $db;
    $query = 'UPDATE users SET session_id= :session_id WHERE email = :email';
    $statement2 = $db->prepare($query);
    $statement2->bindValue(':session_id', $session_id);
    $statement2->bindValue(':email', $email);
    $statement2->execute();
    $statement2->closeCursor();

    //create session variable of logged in email address
    $_SESSION['email'] = $email;

//    //grab use info to create session variable of first name
    include 'get_user_info.php';
    $_SESSION['fname'] = $user_info['fname'];
    $_SESSION['color'] = $user_info['color'];
    //send logged in user to account page

//iF FALSE, notify user and try again
} else {

    echo "<div class='row'><div class='col-sm-4'></div><div class='col-sm-4'><div class='alert alert-danger'>Login Information is Incorrect, Please Try Again.</div></div><div class='col-sm-4'></div></div>";

}