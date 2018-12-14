<?php
    session_start();
  //  echo $_SESSION['loggedin'] . "<br>";
  //  echo $_SESSION['user_id'] . "<br>";
  //  echo $_SESSION['username'] . "<br>";
  //  echo $_SESSION['account_type'] . "<br>";
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Welkom, <?php echo $_SESSION['username']?></title>
         <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    </head>
    <body>
        <div class="wrapper">
            <h2>Welkom, <?php echo $_SESSION['username']?></h2>
            <a href="logout.php" name="logout" class="btn btn-primary">Log uit</a>
        </div>
    </body>
</html>