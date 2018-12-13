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
        $sql = "delete from VerticalShooter_entity_user where username = '$user'";
        if (mysqli_query($connection, $sql)) {
            mysqli_close($connection);
            header("location: admin.php"); // Redirecting to home page with success
        }
    }
    if ($action == "edit") {
        $sql = mysqli_query($connection, "select * from VerticalShooter_entity_user where username='$user'");
    }
    $error = '';
    if ($action == "update") {

        $pass = $_GET['pswd1'];
        $pass2 = $_GET['pswd2'];
        if ($pass != "") {
			$regexPass = '/((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%!]).{6,20})/';
            if ($pass != $pass2)
                $error = "Passwords don't match";
			if(!preg_match($regexPass, $pass))
				$error = "You have entered an invalid password!";
            $pass = sha1($pass);
        } else {
            $sql = mysqli_query($connection, "select * from VerticalShooter_entity_user where username='$user'");
            while ($row = mysqli_fetch_array($sql)) {
                $pass = $row["password"];
            }
        }
        $regexEmail = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
        if (!preg_match($regexEmail, $email)) {
            $error = "You have entered an invalid email address!";
        }

        if ($error == '') {
            $sql = "update VerticalShooter_entity_user set password = '$pass' , where username = '$user'";
            if (mysqli_query($connection, $sql)) {
                mysqli_close($connection);
                header("location: admin.php"); // Redirecting to home page with success
            }
        }
    }
}
?>

<!DOCTYPE html>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Update account</title>
        <link rel="stylesheet" type="text/css" href="style.css"/>
        <script type="text/javascript" src="sha1.js"></script>
        <script>
            function checkForm() {
                var re = /((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%!]).{6,20})/;
                var pswd1 = document.myForm.pswd1.value;
                var pswd2 = document.myForm.pswd2.value;
                alert(pswd1);
                if (pswd1 != "") {
                    if (pswd1.match(re) === null) {
                        //Password not valid
                        var x = document.getElementById("error");
                        x.style.display = "block";
                        x.innerHTML = "Password not valid";
                        return false;
                    } else if (pswd1 != pswd2) {
                        //Passwords don't match
                        var x = document.getElementById("error");
                        x.style.display = "block";
                        x.innerHTML = "Passwords don't match";
                        return false;
                    }
                }

                var emailregex = /((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%!]).{6,20})/;
                var email = form.email.value;
                if (email.match(emailregex) === null)
                {
                    alert("You have entered an invalid email address!")
                    return false;
                }
                return true;

        </script>
    </head>

    <body>
        <div class="topright">
            <a href="index.php">
                <div id="logout">Back to Homepage</div>
            </a>      
        </div>              


        <br>
        <h1 id="title">Update an Account</h1><br>       
        <br>
 <div id="createprompt">    
            <h1 id="error" style='color: red;'><?php echo $error; ?></h1>
        </div> 
        <div id="create">  
            <form name="myForm" action="useredit.php" method="GET" onsubmit="return(checkForm());">
                <div class="container">
                    <label for="username">Username</label>
                    <input id="username" type="text" readonly="true" placeholder="Enter Username" name="username" value="<?php echo $user; ?>">

                    <label for="password">Password (Blank if password does not change)</label>
                    <input id="pswd1" type="password" placeholder="Enter Password" name="pswd1">

                    <label for="password">Confirm Password</label>
                    <input id="pswd2" type="password" placeholder="Confirm Password" name="pswd2">

                    <input type="hidden" id="action" name="action" value="update"/>
                    <button id="submit" type="submit">Submit</button><br>  
                </div>   
            </form>
        </div>  


         

        <br>
        <div id="passreqs">
            <i>Password must contain:</i>
            <ul>
                <li>6 to 20 characters</li>
                <li>1 capital letter</li>
                <li>1 lower case letter</li>
                <li>1 of @#$%!</li>
            </ul>
        </div>

    </body>
</html>