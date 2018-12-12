<?php
// Initialize the session
session_start();
include('connect_db.php');
include('user_service.php');
$userService = new UserService($pdo, $userinfo);
if($userService->logout()){
    header("location: login.php");
    exit;
}
?>