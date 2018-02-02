<?php
include_once "../inc/sessions.php";

require_once '../classes/classes.php';
include_once '../inc/config.inc.php';

$pagePath = $_SERVER["PHP_SELF"];

$up = new UserPermission;
$permissions = $up->GetByRolePath($roleId, $pagePath);

if (isnull($permissions[0],'') == '') {
    //Create(roleId, pagePath, canView, canCreate, canUpdate, canDelete, canRemove, errorLevel)
    $up->Create($roleId, $pagePath, $up->CanView, 
                                    $up->CanCreate, 
                                    $up->CanUpdate, 
                                    $up->CanDelete, 
                                    $up->CanRemove,
                                    $up->ErrorLevelId,
                                    $userId
                );
}

if ($up->CanView == 0) {
    $_SESSION["Permissions"] = "You don't have access to this page. Please check with the System Administrator.";
    header('location:../dashboard');
    echo $_SESSION["Permissions"];
    echo "<br>Done.<br>";
}