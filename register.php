<?php
    session_start();
    $username = $password = $passwordConfirm = "";
    $username_err = $password_err = $passwordConfirm_err = "";
    if(isset($_POST["submit"]))
    {
        include('connect_db.php');
        include('user_service.php');
        $userinfo = array(
        'username'=>$_POST['username'],
        'password'=>$_POST['password'],
        'passwordConfirm'=>$_POST['passwordConfirm']
        );
        $userService = new UserService($pdo, $userinfo);
        $register = $userService->registerNewUser();
        if(is_array($register)){
            extract($register);
        } elseif ($register) {
            header("location: login.php");
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Sign Up</title>
         <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    </head>
    <body>
        <div class="wrapper">
            <h2>Sign Up</h2>
            <p>Please fill this form to create an account.</p>
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
                <div class="form-group <?php echo (!empty($passwordConfirm_err)) ? 'has-error' : ''; ?>">
                    <label>Confirm Password</label>
                    <input type="password" name="passwordConfirm" class="form-control" value="<?php echo $passwordConfirm; ?>">
                    <span class="help-block"><?php echo $passwordConfirm_err; ?></span>
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" class="btn btn-primary" value="Submit">
                    <input type="reset" class="btn btn-default" value="Reset">
                </div>
                <p>Already have an account? <a href="login.php">Login here</a>.</p>
            </form>
        </div>
    </body>
</html>
