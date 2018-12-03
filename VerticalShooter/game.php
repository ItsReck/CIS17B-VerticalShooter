<?php
    include('session.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <title>2d Vertical Shooter</title>
        <meta name="description" content="2d vertical shooter made with Phaser.js">
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" type="text/css" href="style.css"/>
        <style>
          .body {
            text-align: center;
          }
          canvas { 
              margin: 0 auto; 
              display: block;
          }
        </style>
    </head>
    <body>
        <?php     
                include "../../connect.php";
                
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
                
		// Close connection
                mysqli_close($connection);
            ?>
        <div class="gametable">
                <div class="topright">
                    <label>Welcome <?php echo $role ?> <i><?php echo $login_session; ?> !</i></label>
                    <a href="logout.php">
                        <div id="logout">Log out</div>
                    </a>      
                </div>
            <br />
            <br />
            <br />
            <br />
            <br />
            <br />
                <div class ="game">
                    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/phaser/3.12.0/phaser.min.js"></script>-->
                    <script src="http://cdnjs.cloudflare.com/ajax/libs/phaser/2.0.5/phaser.min.js" type="text/javascript"></script>
                    <script src="app.js" type="text/javascript"></script>
                </div>
            </div>
    </body>
</html>