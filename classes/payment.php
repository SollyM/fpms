<?php
class Payment extends ActionLog {
    public function Create($policyId, $paymentDate, $paymentAmount, $userId) {
        echo "PolID2={$policyId}<br>";
        $stmt = $this->conn->prepare("INSERT INTO tblpayments
                                    (PolicyId, PaymentForDate, Amount, CapturedByUserId, CapturedDate)
                             VALUES (:policyid, :paymentdate, :paymentamount, :userid, now())");
        $stmt->bindParam(':userid', $userId);
        $stmt->bindParam(':paymentdate', $paymentDate);
        $stmt->bindParam(':paymentamount', $paymentAmount);
        $stmt->bindParam(':policyid', $policyId);
        $stmt->execute();

        echo "UserId{$userId}<br>";

        $result = $this->GetByPaymentDate($policyId, $paymentDate);

        echo "PayId={$result["PaymentId"]}<br>";

        $this->CreateAction("tblpayments", $result["PaymentId"], $userId);
    }

    public function GetByPaymentDate($policyId, $paymentDate) {
        $stmt = $this->conn->prepare("SELECT * FROM tblpayments WHERE PaymentForDate = :paymentdate AND PolicyId = :policyid");
        $stmt->bindParam(':paymentdate', $paymentDate);
        $stmt->bindParam(':policyid', $policyId);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function GetById($paymentId) {
        $stmt = $this->conn->prepare("SELECT * FROM tblpayments WHERE PaymentId = :paymentId");
        $stmt->bindParam(':paymentId', $paymentId);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function GetAll() {
        $stmt = $this->conn->prepare("SELECT PL.PolicyNumber, P.*, U.FirstName, U.LastName
                                    FROM tblpayments P
                                    LEFT JOIN tblusers U ON U.id = P.CapturedByUserId
                                    LEFT JOIN tblpolicies PL ON PL.PolicyId = P.PolicyId");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function GetByPolicyId($policyId) {
        $stmt = $this->conn->prepare("SELECT P.*, U.FirstName, U.LastName, U.id UserId
                                      FROM tblpayments P
                                      LEFT JOIN tblusers U ON U.id = P.CapturedByUserId
                                      WHERE P.PolicyId = {$policyId}");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function Update($paymentId, $paymentDate, $paymentAmount, $userId) {
        $stmt = $this->conn->prepare("UPDATE tblpayments
                                         SET PaymentForDate = :paymentDate,
                                             Amount = :paymentAmount
                                       WHERE PaymentId = :paymentId");
        $stmt->bindParam(':paymentId', $paymentId);
        $stmt->bindParam(':paymentDate', $paymentDate);
        $stmt->bindParam(':paymentAmount', $paymentAmount);
        $stmt->execute();

        $this->UpdateAction("tblpayments", $paymentId, $userId);
    }

    public function Delete($paymentId, $userId) {
        $stmt = $this->conn->prepare("UPDATE tblpayments
                                        SET DeletedBy = :userId,
                                            DeletedDate = now()
                                        WHERE PaymentId = :paymentId");
        $stmt->bindParam(':paymentId', $paymentId);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();

        $this->DeleteAction("tblpayments", $paymentId, $userId);
    }

    public function Undelete($paymentId, $userId) {
        $stmt = $this->conn->prepare("UPDATE tblpayments
                                        SET DeletedBy = NULL,
                                            DeletedDate = NULL
                                        WHERE PaymentId = :paymentId");
        $stmt->bindParam(':paymentId', $paymentId);
        $stmt->execute();
        $this->UndeleteAction("tblpayments", $paymentId, $userId);
    }
    
    public function Remove($paymentId, $userId) {
        $stmt = $this->conn->prepare("DELETE FROM tblpayments
                                        WHERE PaymentId = :paymentId");
        $stmt->bindParam(':paymentId', $paymentId);
        $stmt->execute();
        $this->RemoveAction("tblpayments", $paymentId, $userId);
    }
}
?>