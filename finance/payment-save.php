<?php
include_once "../inc/sessions.php";
require "../inc/config.inc.php";
require "../classes/classes.php";


$mode = isset($_POST["mode"]) ? $_POST["mode"] : "view";
$paymentId = $_POST["paymentId"];

try {
    
    $err = '';
    $db = new DbConn;
    $p = new Payment;

    switch ($mode) {
        case "create":
        case "update":
            $polid = $_POST["policyId"];
            $paymentAmount = $_POST["paymentAmount"];
            $paymentDate = $_POST["paymentDate"];
            $result = $p->GetByPaymentDate($polid, $paymentDate);
            break;
    }

    switch ($mode) {
        case "remove":
            $p->Remove($paymentId, $userId);
            $message = "Payment ID# {$paymentId} has been removed successfully.";
            $msgtype = "success";
            break;
        case "undel":
            $p->Undelete($paymentId, $userId);
            $message = "Payment ID# {$paymentId} has been undeleted successfully.";
            $msgtype = "success";
            break;
        case "del":
            $p->Delete($paymentId, $userId);
            $message = "Payment ID# {$paymentId} has been deleted successfully.";
            $msgtype = "success";
            break;
        case "update":
            $p->Update($paymentId, $paymentDate, $paymentAmount, $userId);
            $message = "Payment for Policy# {$polid} has been updated successfully.";
            $msgtype = "success";
            break;
        case "create":
            $p->Create($polid, $paymentDate, $paymentAmount, $userId);
            $message = "Payment for Policy# {$polid} has been created successfully.";
            $msgtype = "success";
            break;
        default:
            break;
    }
/*
//---   Policy Holder Information   ---//
if ($_POST["paymentAmount"] != null && $_POST["paymentDate"] != null) {
    
    $stmt_per_edit  =  "UPDATE tblpayments
                        SET PaymentForDate = :paymentdate,
                                  Amount   = :paymentamount
                        WHERE    PaymentId = :paymentid AND PolicyId = :policyid";


    if ($result[0] != null) { // record exists
        echo "Payment Exists<br/>";
        $paymentId = $result['PaymentId'];
        $stmt = $db->conn->prepare($stmt_per_edit);
        $stmt->bindParam(':paymentid', $paymentId);
    }
    else { //add new
        echo "New Payment <br>";
        $stmt = $db->conn->prepare($stmt_per_add);
        $stmt->bindParam(':userid', $_POST['userId']);
    }
    $stmt->bindParam(':paymentdate', $paymentDate);
    $stmt->bindParam(':paymentamount', $paymentAmount);
    $stmt->bindParam(':policyid', $polid);
    $stmt->execute();
    
} */
} catch (PDOException $e) {
    
    $err = "Error: " . $e->getMessage();
    echo $err;
 }

$_SESSION["Saved"] = "<div class=\"alert alert-{$msgtype} alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>{$message}</div>";
header("location:payments.php");
?>