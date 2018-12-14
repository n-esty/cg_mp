<?php
    session_start();
    $username = $password = $passwordConfirm = "";
    $username_err = $password_err = $passwordConfirm_err = "";
    if(isset($_POST["login"]))
    {
        include('includes/connect_db.php');
        include('includes/user_service.php');
        $userinfo = array(
        'username'=>$_POST['username'],
        'password'=>$_POST['password'],
        );
        $userService = new UserService($pdo, $userinfo);
        $login = $userService->login();
        if(is_array($login)){
            extract($login);
        } elseif ($login) {
            header("location: index.php#user=" . $_SESSION['user_id']);
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Log In</title>
         <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    </head>
    <body>
        <div class="wrapper">
            <h2>Log In</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                    <span class="help-block"><?php echo $username_err; ?></span>
                </div>
                <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                    <span class="help-block"><?php echo $password_err; ?></span>
                </div>
                <div class="form-group">
                    <input type="submit" name="login" class="btn btn-primary" value="Log In"> <a href="register.php" name="register" class="btn btn-default">Registreer</a>
                </div>
            </form>
        </div>
    </body>
</html>
