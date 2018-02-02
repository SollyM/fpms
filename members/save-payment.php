<?php
require "../inc/config.inc.php";
require "../classes/classes.php";

$polid = $_POST["policyId"];
$invoiceId = $_POST["paymentId"];

try {
    
    $err = '';
    
//---   Policy Holder Information   ---//
if ($_POST["paymentAmount"] != null && $_POST["paymentDate"] != null) {
    $db = new DbConn;

    $stmt_per_add   =  "INSERT INTO tblpayments
                        (PolicyId, PaymentForDate, Amount, CapturedByUserId, CapturedDate)
                        VALUES
                        (:policyid, :paymentdate, :paymentamount, :userid, now())";
    $stmt_per_edit  =  "UPDATE tblpayments
                        SET PaymentForDate = :paymentdate,
                                  Amount   = :paymentamount
                        WHERE    PaymentId = :paymentid AND PolicyId = :policyid";

    $paymentAmount = $_POST["paymentAmount"];
    $paymentDate = $_POST["paymentDate"];

    $stmt = $db->conn->prepare("SELECT * FROM tblpayments WHERE PaymentForDate = :paymentdate AND Amount = :paymentamount AND PolicyId = :policyid");
    $stmt->bindParam(':paymentdate', $paymentDate);
    $stmt->bindParam(':paymentamount', $paymentAmount);
    $stmt->bindParam(':policyid', $polid);
    $stmt->execute();
    $result = $stmt->fetch();

    if ($result[0] != null) { // record exists
        $paymentId = $result['PaymentId'];
        $stmt = $db->conn->prepare($stmt_per_edit);
        $stmt->bindParam(':paymentid', $paymentId);
    }
    else { //add new
        $stmt = $db->conn->prepare($stmt_per_add);
        $stmt->bindParam(':userid', $_POST['userId']);
    }
    $stmt->bindParam(':paymentdate', $paymentDate);
    $stmt->bindParam(':paymentamount', $paymentAmount);
    $stmt->bindParam(':policyid', $polid);
    $stmt->execute();
}
} catch (PDOException $e) {
    
    $err = "Error: " . $e->getMessage();
    
 }

$_SESSION["MemberSaved"] = "<div class=\"alert alert-success alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>Saved Successfully.</div>";
header("location:details.php?polid=". $polid ."&mode=view");
?>