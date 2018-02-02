<?php
include_once "../inc/sessions.php";

require "../inc/config.inc.php";
require "../classes/classes.php";

try {
    
    $mode = (isset($_POST["mode"]) ? $_POST["mode"] : "view");

    $Plan = new PolicyPlan;
    $err = '';
    
    $id = $_POST["policyPlanId"];
    $now = date("Y-m-d H:m");
    
    if ($mode != "remove" && $mode != "del" && $mode != "undel") {
        $name = $_POST["planName"];
        $defaultPremium = $_POST["defaultPremium"];
        $activeFrom = $_POST["activeFrom"];
        $activeTo = $_POST["activeTo"];

        if (isnull($activeFrom,$now) <= $now && isnull($activeTo,$now) >= $now) {
            $isactive = 1;
        }
        else {
            $isactive = 0;
        }
    }

    $result = $Plan->Read($id);

    if ($mode=="remove") { //undelete
        $Plan->Remove($id, $userId);
        $message = $result["PlanName"] ." Removed Successfully.";
        $msgtype = "success";
    }
    elseif ($mode=="undel") { //undelete
        $Plan->Undelete($id, $userId);
        $message = $result["PlanName"] ." Undeleted Successfully.";
        $msgtype = "success";
    }
    elseif ($mode=="del") { //delete
        $Plan->Delete($id, $userId);
        $message = $result["PlanName"] ." Deleted Successfully.";
        $msgtype = "success";
    }
    elseif ($result[0] != null) { //edit
        $c = $Plan->Update($id, $name, $defaultPremium, $activeFrom, $activeTo, $userId);
        if ($c) {
            $message = $name ." Updated Successfully.";
            $msgtype = "success";
        }
        else {
            $message = $name ." already exists.";
            $msgtype = "error";
        }
    }
    else { //add
        $c = $Plan->Create($name, $defaultPremium, $activeFrom, $activeTo, $userId);
        if ($c) {
            $message = $name ." Updated Successfully.";
            $msgtype = "success";
        }
        else {
            $message = $name ." already exists.";
            $msgtype = "error";
        }
    }
    
    $_SESSION["Saved"] = "<div class=\"alert alert-{$msgtype} alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>{$message}</div>";
    header("location:plans-view.php");
    
} catch (PDOException $e) {
    
    $err = "Error: " . $e->getMessage();
    echo $err;
 }

?>