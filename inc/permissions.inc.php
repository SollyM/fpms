<?php
include_once "../inc/sessions.php";

require_once '../classes/classes.php';
include_once '../inc/config.inc.php';

$pagePath = $_SERVER["REQUEST_URI"];

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
    $_SESSION["Permissions"] = "You don't have access to {$pageName} page. Please check with the System Administrator.";
    header('location:../dashboard');
}