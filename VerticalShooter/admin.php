<?php
    include "../../connect.php";
    include('session.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Admin: <?php echo $login_session; ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
        <body>
            
            <?php          
                // Establishing connection with server (server_name, user_id, password)
                $connection = mysqli_connect($servername, $username, $password);

                // Selecting database
                $db = mysqli_select_db($connection, $dbname);

                // SQL query to fetch information of registerd users and finds user match.
                $query = mysqli_query($connection, "select role from VerticalShooter_entity_user where username='$login_session'");
                
                //Retrieve data and put into a string
                while($row = mysqli_fetch_array($query)) { 
                    $role = $row["role"];
                }
                
                // If role is not admin
                if ($role!="admin"){
                    header("location: profile.php");
                }
                
		// Close connection
                mysqli_close($connection);
            ?>
            
            <div id="profile">
                <div class="topright">
                    <label>Admin: <i><?php echo $login_session; ?></i></label>
                    
                    <a href="logout.php">
                        <div id="logout">Log out</div>
                    </a>      
                </div>
            </div>
            
            <br><br>
            <div id="playertitle"><i>Admin:</i> <b><?php echo $login_session; ?></b></div>
            <br><br>
            
            <div id="admin">
                <p>This is admin page. Options for viewing and modifying the database to be developed.</p>
            </div>
            
        </body>
</html>