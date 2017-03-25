<?php
/**
 * Created by PhpStorm.
 * User: andrewmyers
 * Date: 3/25/17
 * Time: 3:39 AM
 */

include 'connection.php';

session_start();


?>



<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Bare - Start Bootstrap Template</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
body {
    padding-top: 70px;
        /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
    }
    </style>
    <link href="css/styles.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/themes.css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="js/jquery.wheelcolorpicker.js"></script>
    <link type="text/css" rel="stylesheet" href="css/wheelcolorpicker.css" />

</head>

<body>
<?php
if(isset($_POST['color_update'])) {
    $color = $_POST['color'];
    global $db;
    $query = 'UPDATE users SET color = :color WHERE session_id = :session_id';
    $statement3 = $db->prepare($query);
    $statement3->bindValue(':color', $color);
    $statement3->bindValue(':session_id', $_SESSION['session_id']);
    $statement3->execute();
    $statement3->closeCursor();

}
if(isset($_POST['login'])) {
    include 'login_method.php';

}
if(isset($_POST['logout'])) {
    global $db;
    $query = 'UPDATE users SET session_id = :new_sess WHERE session_id = :session_id';
    $statement3 = $db->prepare($query);
    $statement3->bindValue(':session_id', $_SESSION['session_id']);
    $statement3->bindValue(':new_sess', NULL);
    $statement3->execute();
    $statement3->closeCursor();

    unset($_SESSION['session_id']);

    header('Location: index.php');
}
if(isset($_POST['modal_register'])) {
    if($_POST['password'] == $_POST['v_password']) {
        include 'register_method.php';

        include 'login_method.php';
    }
}
if(isset($_POST['register'])) {
echo'hi';?>
<div id="invite_modal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
        <span class="close">&times;</span>
        <h4>Complete Registration</h4>
        <form action="<?=$_SERVER['PHP_SELF'];?>" method="post" class="form-horizontal" role="form">
            <div class="form-group">
                <label for="email">Email</label>
                <input class="form-control" type="email" value='<?php echo $_POST["email"]; ?>' name="email" id="email">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input class="form-control" type="password" value='<?php echo $_POST["password"]; ?>' name="password" id="password">
            </div>

            <div class="form-group">
                <label for="v_password">Verify Password</label>
                <input class="form-control" type="password" value='' name="v_password" id="v_password">
            </div>

            <div class="form-group">
                <label for="fname">Name</label>
                <input class="form-control" type="text" value='' name="fname" id="fname">
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input class="form-control" type="text" value='' name="phone" id="phone">
            </div>

            <button type="submit" class="btn btn-default" name="modal_register">Register</button>
        </form>
    </div>

</div>

<script>
    // Get the modal
    var modal = document.getElementById('invite_modal');

    //            // Get the button that opens the modal
    //            var btn = document.getElementById("invite_submit_btn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];
    //
    //            // When the user clicks the button, open the modal
    //            btn.onclick = function() {
    //                modal.style.display = "block";
    //            }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    function index_modal() {
        modal.style.display = "block";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script> <?php

} ?>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div style="display:flex;justify-content:center;align-items:center;"><h1 id="title">colorMe</h1></div>

        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">

        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-5 above">
                <h3>Feed</h3>
                <table class="table table-hover">
                    <thead>

                    </thead>
                    <tbody>
                        <tr>
                            <td>o</td>
                            <td>Andrew Myers</td>
                            <td>updated 10 mins ago</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-4 above">

                <?php
                if(isset($_SESSION['session_id'])) {
                ?>
                <h3>How do you feel?</h3>
                <table class="table">
                    <thead>

                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <div id="snippet-block" class="snippet">
                                <p>
                                <form action="<?=$_SERVER['PHP_SELF'];?>" method="post" class="form-horizontal" role="form">

                                    <input type="text" value="#ff8800" data-wheelcolorpicker data-wcp-layout="block" data-wcp-sliders="ws" data-wcp-cssClass="color-block" data-wcp-autoResize="false" name="color"/>
                                    <button type="submit" class="btn btn-default" name="color_update">Update Color</button>
                                </form>
                                </p>
                                <style type="text/css">
                                    .color-block {
                                        max-width: 340px;
                                        width: 100%;
                                        box-sizing: border-box;
                                    }
                                </style>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                    <form action="<?=$_SERVER['PHP_SELF'];?>" method="post" class="form-horizontal" role="form">
                        <button type="submit" class="btn btn-default" name="logout">Logout</button>
                    </form>
                <?php } else { ?>



                <h3>Login or Register</h3>
                <table class="table">
                    <thead></thead>
                    <tbody>
                    <tr>
                        <td>
                            <form action="<?=$_SERVER['PHP_SELF'];?>" method="post" class="form-horizontal" role="form">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input class="form-control" type="email" value='<?php echo $_POST["email"]; ?>' name="email" id="email">
                                </div>

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input class="form-control" type="password" value="" name="password" id="password">
                                </div>

                                <button type="submit" class="btn btn-default" name="login">Log In</button>
                                <button type="submit" class="btn btn-default" name="register">Register</button>
                            </form>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <?php } ?>

            </div>
            <div class="col-md-1"></div>
        </div>

    </div>
    <!-- /.container -->

    <!-- jQuery Version 1.11.1 -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
