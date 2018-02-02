<?php
include_once "../inc/sessions.php";

require "../inc/config.inc.php";
require "../classes/classes.php";

$mode = isset($_POST["mode"]) ? $_POST["mode"] : "view";

try {

    $invoiceId = $_POST["invoiceId"];

    switch ($mode) {
        case "edit":
        case "create":
            $invoiceNumber = $_POST["invoiceNumber"];
            $invoiceDate = $_POST["invoiceDate"];
            $invoiceAmount = $_POST["invoiceAmount"];        
            $polid = $_POST["policyId"];
            break;
        default:
            break;
    }


    $err = '';
    $invoice = new Invoice;

    $result = $invoice->GetById($invoiceId);

    switch ($mode) {
        case "remove":
            $invoice->Remove($invoiceId, $userId);
            $message = "Invoice# {$result["InvoiceNumber"]} was removed successfully.";
            $msgtype = "success";
            break;
        case "undel":
            $invoice->Undelete($invoiceId, $userId);
            $message = "Invoice# {$result["InvoiceNumber"]} was undeleted successfully.";
            $msgtype = "success";
            break;
        case "del":
            $invoice->Delete($invoiceId, $userId);
            $message = "Invoice# {$result["InvoiceNumber"]} was deleted successfully.";
            $msgtype = "success";
            break;
        case "edit":
        case "update":
            $invoice->Update($invoiceNumber, $invoiceDate, $invoiceAmount, $invoiceId, $polid, $userId);
            $message = "Invoice# {$invoiceNumber} was updated successfully.";
            $msgtype = "success";
            break;
        case "create":
        case "new":
            $invoice->Create($invoiceNumber, $invoiceDate, $invoiceAmount, $polid, $userId);
            $message = "Invoice# {$invoiceNumber} was created successfully.";
            $msgtype = "success";
            break;
        default:
            $message = "Unexpected error occured";
            $msgtype = "error";
            break;
    }

} catch (PDOException $e) {
    
    $err = "Error: " . $e->getMessage();
    $messge = $err;
    $msgtype = "error";
 }

$_SESSION["Saved"] = "<div class=\"alert alert-{$msgtype} alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>{$message}</div>";
header("location:invoices.php");
?>