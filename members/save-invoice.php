<?php
require "../inc/config.inc.php";
require "../classes/classes.php";

$polid = $_POST["policyId"];
$invoiceId = $_POST["invoiceId"];

try {
    
    $err = '';
    
//---   Policy Holder Information   ---//
if ($_POST["invoiceNumber"] != null && $_POST["invoiceAmount"] != null) {
    $db = new DbConn;

    $stmt_per_add   =  "INSERT INTO tblinvoices
                        (InvoiceNumber, InvoiceDate, TotalAmount, PolicyId, RaisedBy, RaisedDate)
                        VALUES
                        (:invoicenumber, :invoicedate, :invoiceamount, :policyid, :userid, now())";
    $stmt_per_edit  =  "UPDATE tblinvoices
                        SET InvoiceNumber = :invoicenumber,
                            InvoiceDate   = :invoicedate,
                            TotalAmount   = :invoiceamount
                        WHERE InvoiceId = :invoiceid AND PolicyId = :policyid";

    $invoiceNumber = $_POST["invoiceNumber"];
    $invoiceDate = $_POST["invoiceDate"];
    $invoiceAmount = $_POST["invoiceAmount"];

    //$stmt = $db->conn->prepare("SELECT * FROM tblinvoices WHERE (InvoiceNumber = :invoicenumber OR InvoiceDate = :invoicedate OR InvoiceId = :invoiceid) AND PolicyId = :policyid");
    $stmt = $db->conn->prepare("SELECT InvoiceId FROM tblinvoices WHERE InvoiceId = :invoiceid AND PolicyId = :policyid");
    //$stmt->bindParam(':invoicenumber', $invoiceNumber);
    //$stmt->bindParam(':invoicedate', $invoiceDate);
    $stmt->bindParam(':invoiceid', $invoiceId);
    $stmt->bindParam(':policyid', $polid);
    $stmt->execute();
    $result = $stmt->fetch();

    if ($result[0] != null) { // record exists
        $invoiceId = $result['InvoiceId'];
        $stmt = $db->conn->prepare($stmt_per_edit);
        $stmt->bindParam(':invoiceid', $invoiceId);
    }
    else { //add new
        $stmt = $db->conn->prepare($stmt_per_add);
        $stmt->bindParam(':userid', $_POST['userId']);
    }
    $stmt->bindParam(':invoicenumber', $invoiceNumber);
    $stmt->bindParam(':invoicedate', $invoiceDate);
    $stmt->bindParam(':invoiceamount', $invoiceAmount);
    $stmt->bindParam(':policyid', $polid);
    $stmt->execute();
}
} catch (PDOException $e) {
    
    $err = "Error: " . $e->getMessage();
    
 }

$_SESSION["MemberSaved"] = "<div class=\"alert alert-success alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>Saved Successfully.</div>";
header("location:details.php?polid=". $polid ."&mode=view");
?>