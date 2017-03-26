<script type="text/javascript" src="js/regCheck.js"></script>
<?php
/**
 * Created by PhpStorm.
 * User: andrewmyers
 * Date: 3/25/17
 * Time: 3:39 AM
 */
include 'connection.php';
session_start();
if(isset($_SESSION['session_id'])) {
    global $db;
    $query = "SELECT color FROM users WHERE session_id = :session_id";
    $statement = $db->prepare($query);
    $statement->bindValue(":session_id", $_SESSION['session_id']);
    $statement->execute();
    $colorarray = $statement->fetch();
    $statement->closeCursor();
    $_SESSION['color'] = $colorarray['color'];
}
?>



<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>colorMe</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
body {
    padding-top: 70px;
        /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
    }
    </style>
    <link media="screen" href="css/styles.css" rel="stylesheet">
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
    $query = 'UPDATE users SET color = :color, last_change = CURRENT_TIMESTAMP WHERE session_id = :session_id';
    $statement3 = $db->prepare($query);
    $statement3->bindValue(':color', $color);
    $statement3->bindValue(':session_id', $_SESSION['session_id']);
    $statement3->execute();
    $statement3->closeCursor();
    $_SESSION['color'] = $color;
 /*    $_SESSION['color_updated'] = 'yes';
    ?>
    <script>	parent.window.location.reload(); </script>
    <?php */
}
if(isset($_SESSION['color_updated'])) {
    unset($_SESSION['color_updated']);
}
if(isset($_POST['login'])) {
    include 'login_method.php';
/*     $_SESSION['logged_in'] = 'true';
    ?>
    <script>	parent.window.location.reload(); </script>
    <?php */
}
if(isset($_SESSION['logged_in'])) {
    unset($_SESSION['logged_in']);
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
   /*  $_SESSION['logged_out'] = 'true';
    ?>
    <script>	parent.window.location.reload(); </script>
    <?php */
} if(isset($_SESSION['logged_out'])) {
    unset($_SESSION['logged_out']);
    ?><div id="invite_modal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <h4>You have successfully Logged Out!</h4>
        </div>

    </div>

    <script>
        // Get the modal
        var modal = document.getElementById('invite_modal');
        var span = document.getElementsByClassName("close")[0];
        span.onclick = function() {
            modal.style.display = "none";
        }
        function index_modal() {
            modal.style.display = "block";
        }
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>

    <?php
}
if(isset($_POST['phone'])) {
    include 'f_check_user_emails.php';
    $email_check_param = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $email_check = check_user_emails($email_check_param);
    include 'f_check_username.php';
    $username_check_param = filter_input(INPUT_POST, 'lname');
    $username_check = check_username($username_check_param);

    include 'f_check_phone.php';
    $phone_check_param = filter_input(INPUT_POST, 'phone');
    $phone_check = check_phone($phone_check_param);


    if ($email_check == TRUE) {
        echo "<br><div class='row'><div class='col-sm-4'></div><div class='col-sm-4'><div class='alert alert-danger'>That email has already been registered. Try Logging in.</div></div><div class='col-sm-4'></div></div>";
    } elseif ($username_check == TRUE) {
            $username_error = "That username has already been registered.";
        echo "<br><div class='row'><div class='col-sm-4'></div><div class='col-sm-4'><div class='alert alert-danger'>That username has already been registered.</div></div><div class='col-sm-4'></div></div>";
    } elseif ($phone_check == TRUE) {
        $phone_error = "That username has already been registered.";
        echo "<br><div class='row'><div class='col-sm-4'></div><div class='col-sm-4'><div class='alert alert-danger'>That phone number has already been registered.</div></div><div class='col-sm-4'></div></div>";
    } elseif ($_POST['password'] == $_POST['v_password']) {
        include 'register_method.php';
        include 'login_method.php';
/*         $_SESSION['registered'] = 'true';
        ?>
        <script>	parent.window.location.reload(); </script>
        <?php */
    }
}
if($_SESSION['registered'] == 'true') {
    unset($_SESSION['registered']);
    ?>

    <div id="invite_modal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <h4>You have successfully Registered!</h4>
        </div>

    </div>

    <script>
        // Get the modal
        var modal = document.getElementById('invite_modal');
        var span = document.getElementsByClassName("close")[0];
        span.onclick = function() {
            modal.style.display = "none";
        }
        function index_modal() {
            modal.style.display = "block";
        }
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>

    <?php
}
if(isset($_POST['register'])) {
?>
<div id="invite_modal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
        <span class="close">&times;</span>
        <h4>Complete Registration</h4>
        <form action="<?=$_SERVER['PHP_SELF'];?>" method="post" class="form-horizontal" role="form" id="main_form">
            <div class="form-group">
                <label for="email">Email</label>
                <input class="form-control" type="email" value='<?php echo $_POST["email"]; ?>' name="email" id="email" onblur="checkEmail('email')">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input class="form-control" type="password" value='<?php echo $_POST["password"]; ?>' name="password" id="password" onblur="checkPassword('password')">
            </div>

            <div class="form-group">
                <label for="v_password">Verify Password</label>
                <input class="form-control" type="password" value='' name="v_password" id="v_password" onblur="vCheckPassword('password' , 'v_password')">
            </div>

            <div class="form-group">
                <label for="fname">First Name</label>
                <input class="form-control" type="text" value='' name="fname" id="fname" onblur="checkFname('fname')">
            </div>

            <div class="form-group">
                <label for="lname">User Name</label>
                <input class="form-control" type="text" value='' name="lname" id="lname" onblur="checkLname('lname')">
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input class="form-control" type="text" value='' name="phone" id="phone" onblur="checkPhone('phone')">
            </div>

            <button type="button" class="btn btn-default" name="modal_register" onclick="submissionCheck('email','password','v_password','fname','lname','phone')">Register</button>
        </form>
    </div>

</div>

<script>
    // Get the modal
    var modal = document.getElementById('invite_modal');
    var span = document.getElementsByClassName("close")[0];
    span.onclick = function() {
        modal.style.display = "none";
    }
    function index_modal() {
        modal.style.display = "block";
    }
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script> <?php
} ?>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" style="background-color: #<?php echo $_SESSION['color']; ?>">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div style="display:flex;justify-content:center;align-items:center;">
                <h1 id="title">colorMe</h1>
                <form action="<?=$_SERVER['PHP_SELF'];?>" method="post" class="form-horizontal form-nav" role="form">
                    <button type="submit" class="white btn" name="logout">Logout</button>
                </form>
            </div>

        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">

        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-5 above">
                <h3>How are your friends?</h3>
                <hr>
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#live">Live Feed</a></li>
                    <li><a data-toggle="tab" href="#friends">Friends</a></li>
                    <button type="button" class="btn btn-default refresh" aria-label="Left Align" onclick="refreshFeed'>
                        <span class="glyphicon glyphicon-refresh refresh-span" aria-hidden="true"></span>
                    </button>
                </ul>


                <div class="tab-content" id="auto_load_div">
                    <div id="live" class="tab-pane fade in active">
                        <table class="table table-hover">
                            <thead class="no-margins">
                            <form id="live-search" action="" class="styled" method="post">
                                <fieldset>
                                    <input type="text" class="text-input search" id="filter" value="" placeholder="Search..." />
                                    <span id="filter-count"></span>
                                </fieldset>
                            </form>
                            </thead>
                            <tbody>

                            <?php include 'live_feed.php';
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <div id="friends" class="tab-pane fade">
                        <table class="table table-hover">
                            <thead>

                            </thead>
                            <tbody>
                            <?php include 'friend_feed.php';
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="col-md-4 above">

                <?php
                if(isset($_SESSION['session_id'])) {
                ?>
                <h3>How do you feel?</h3>
                    <hr>
<!--                <table class="table">-->
<!--                    <thead>-->
<!---->
<!--                    </thead>-->
<!--                    <tbody>-->
<!--                    <tr>-->
<!--                        <td>-->
                            <div id="snippet-block" class="snippet">
                                <p>
                                <form action="<?=$_SERVER['PHP_SELF'];?>" method="post" class="form-horizontal" role="form">

                                    <input type="text" value='<?php echo $_SESSION['color']; ?>' data-wheelcolorpicker data-wcp-layout="block" data-wcp-sliders="wvp" data-wcp-cssClass="color-block" data-wcp-autoResize="false" name="color"/>
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
<!--                        </td>-->
<!--                    </tr>-->
<!--                    </tbody>-->
<!--                </table>-->

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