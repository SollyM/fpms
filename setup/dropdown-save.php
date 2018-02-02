<?php
include_once "../inc/sessions.php";
require "../inc/config.inc.php";
require "../classes/classes.php";

$type = $_POST["type"];

try {
    
    $err = '';
    
    $id = $_POST["settingId"];
    $mode = isset($_POST["mode"]) ? $_POST["mode"] : "view";

    switch ($type) {
        case 'title':
            $d = new Title;
            break;
        case 'persontype':
            $d = new PersonType;
            break;
        case 'relationship':
            $d = new Relationship;
            break;
        default:
            header("location:../index.php");
            break;
    }

    $result = $d->GetById($id);
    
    switch ($mode) {
        case "del":
            $d->Delete($id, $userId);
            $message = $result["Name"] ." Deleted Successfully.";
            break;
        case "undel":
            $d->Undelete($id, $userId);
            $message = $result["Name"] ." Undeleted Successfully.";
            break;
        case "remove":
            $d->Remove($id, $userId);
            $message = $result["Name"] ." Removed Successfully.";
            break;
        case "update":
            $name = $_POST["name"];
            $isactive = $_POST["isactive"];
            $c = $d->Update($id, $name, $isactive, $userId);
            if ($c) {
                $message = $name ." Updated Successfully.";
                $msgtype = "success";
            }
            else {
                $message = $name ." already exists.";
                $msgtype = "error";
            }
            break;
        case "create":
            $name = $_POST["name"];
            $isactive = $_POST["isactive"];
            $c = $d->Create($name, $isactive, $userId);
            if ($c) {
                $message = $name ." Created Successfully.";
                $msgtype = "success";
            }
            else {
                $message = $name ." already exists.";
                $msgtype = "error";
            }
            break;
        default:
            break;
    }

    $_SESSION["Saved"] = "<div class=\"alert alert-{$msgtype} alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>{$message}</div>";
    header("location:dropdown-view.php?type=". $type);
    
} catch (PDOException $e) {
    
    $err = "Error: " . $e->getMessage();
    echo $err;
 }

?>