<?php
include_once "../inc/sessions.php";
require "../inc/config.inc.php";
require "../classes/classes.php";

$err = '';

try {
    
    $r = new Role;
    
    $mode = (isset($_POST["mode"]) ? $_POST["mode"] : "view");
    
    $roleId = $_POST["roleId"];

    if ($mode != "remove" && $mode != "undel" && $mode != "del") {
        $roleName = $_POST["roleName"];
        $rolePriority = $_POST["rolePriority"];
        $isActive = $_POST["isActive"];
    }

    $result = $r->GetById($roleId);

    switch ($mode) {
        case "remove":
            $r->Remove($roleId, $userId);
            $action = $result["RoleName"] ." Removed Successfully.";
            break;
        case "undel":
            $r->Undelete($roleId, $userId);
            $action = $result["RoleName"] ." Undeleted Successfully.";
            break;
        case "del":
            $r->Delete($roleId, $userId);
            $action = $result["RoleName"] ." Deleted Successfully.";
            break;
        case "update":
            $c = $r->Update($roleId, $roleName, $rolePriority, $isActive, $userId);
            if ($c) {
                $message = $roleName ." Updated Successfully.";
                $msgtype = "success";
            }
            else {
                $message = $roleName ." already exists.";
                $msgtype = "error";
            }
            break;
        case "create":
            $c = $r->Create($roleName, $rolePriority, $isActive, $userId);
            if ($c) {
                $message = $roleName ." Created Successfully.";
                $msgtype = "success";
            }
            else {
                $message = $roleName ." already exists.";
                $msgtype = "error";
            }
            break;
        default:
            $message = "Ooops! Something is not right with ". $id;
            $msgtype = "error";
            break;
    }

    $_SESSION["Saved"] = "<div class=\"alert alert-{$msgtype} alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>{$message}</div>";
} catch (PDOException $e) {
    
    $err = "Error: " . $e->getMessage();
    echo $err;
}

if ($err == "") header("location:roles.php");

?>