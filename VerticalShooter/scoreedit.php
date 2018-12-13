<?php
include "../../connect.php";
include('session.php');

// Variable to store an error message
//$error='';
// Check if _GET contains any empty fields
$user = $_GET['username'];
$action = $_GET['action'];
if (empty($user) || empty($action) && ( $action != "edit" || $action != "delete" || $action != "update")) {
    //echo $action . "||" . $user;
    header("location: admin.php");
} else {
    // Define $username and $action
    $user = $_GET['username'];
    $action = $_GET['action'];

    // Used for MySQL injection protection
    $user = stripslashes($user);
    $user = mysqli_real_escape_string($connection, $user);

    if ($action == "delete") {
        $sql = "DELETE FROM VerticalShooter_entity_score ORDER BY score DESC LIMIT 10";
        if (mysqli_query($connection, $sql)) {
            mysqli_close($connection);
            header("location: admin.php"); // Redirecting to home page with success
        }
    }
    $error = '';
}
?>

<!DOCTYPE html>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Update account</title>
        <link rel="stylesheet" type="text/css" href="style.css"/>
        <script type="text/javascript" src="sha1.js"></script>
    </head>

    <body>
        <div class="topright">
            <a href="index.php">
                <div id="logout">Back to Homepage</div>
            </a>      
        </div>                

    </body>
</html>