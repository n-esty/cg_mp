<?php
// Initialize the session
session_start();
include('includes/connect_db.php');
include('includes/user_service.php');
$userService = new UserService($pdo, $userinfo);
if($userService->logout()){
    header("location: login.php");
    exit;
}
?>