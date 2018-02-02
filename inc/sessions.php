<?php 
include_once "systeminfo.inc.php";

session_start();

$userFullName = $_SESSION['fullName'];
$userId = $_SESSION['UserId'];
$roleId = $_SESSION['RoleId'];

$pagePath = $_SERVER["PHP_SELF"];

if (!isset($_SESSION['username'])) {
    header("location:". $baseUrl ."/auth");
}
?>