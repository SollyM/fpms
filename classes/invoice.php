<?php
class Invoice extends ActionLog {
    public function Create($invoiceNumber, $invoiceDate, $invoiceAmount, $policyId, $userId) {
        $stmt = $this->conn->prepare("INSERT INTO tblinvoices
                                                  (InvoiceNumber, InvoiceDate, TotalAmount, PolicyId, RaisedBy, RaisedDate)
                                           VALUES (:invoicenumber, :invoicedate, :invoiceamount, :policyid, :userid, now())");
        $stmt->bindParam(':invoicenumber', $invoiceNumber);
        $stmt->bindParam(':invoicedate', $invoiceDate);
        $stmt->bindParam(':invoiceamount', $invoiceAmount);
        $stmt->bindParam(':policyid', $policyId);
        $stmt->bindParam(':userid', $userId);
        $stmt->execute();

        $result = $this->Read($invoiceNumber, $invoiceDate, $policyId);
        $invoiceId = $result["InvoiceId"];

        $this->CreateAction("tblInvoices", $invoiceId, $userId);
    }

    public function GetById($invoiceId) {
        $stmt = $this->conn->prepare("SELECT * FROM tblinvoices WHERE InvoiceId = :invoiceId");
        $stmt->bindParam(':invoiceId', $invoiceId);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function Read($invoiceNumber, $invoiceDate, $policyId) {
        $stmt = $this->conn->prepare("SELECT * FROM tblinvoices WHERE InvoiceNumber = :invoicenumber AND InvoiceDate = :invoicedate AND PolicyId = :policyid");
        $stmt->bindParam(':invoicenumber', $invoiceNumber);
        $stmt->bindParam(':invoicedate', $invoiceDate);
        $stmt->bindParam(':policyid', $policyId);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function GetAll() {
        $stmt = $this->conn->prepare("SELECT InvoiceId, PolicyNumber, P.PolicyId, InvoiceNumber, InvoiceDate, TotalAmount, RaisedDate, DeletedDate, FirstName, LastName 
                                    FROM tblinvoices I LEFT JOIN tblusers U ON U.id = I.RaisedBy
                                                    LEFT JOIN tblpolicies P ON P.PolicyId = I.PolicyId");
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function GetByPolicyId($policyId) {
        $stmt = $this->conn->prepare("SELECT InvoiceId, InvoiceNumber, InvoiceDate, TotalAmount, RaisedDate, FirstName, LastName, U.id UserId 
                                      FROM tblinvoices I LEFT JOIN tblusers U ON U.id = I.RaisedBy
                                      WHERE PolicyId = {$policyId}");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function Update($invoiceNumber, $invoiceDate, $invoiceAmount, $invoiceId, $policyId, $userId) {
        $stmt = $this->conn->prepare("UPDATE tblinvoices
                                         SET InvoiceNumber = :invoicenumber,
                                             InvoiceDate = :invoicedate,
                                             TotalAmount = :invoiceamount, 
                                             PolicyId = :policyid
                                       WHERE InvoiceId = :invoiceid");
        $stmt->bindParam(':invoicenumber', $invoiceNumber);
        $stmt->bindParam(':invoicedate', $invoiceDate);
        $stmt->bindParam(':invoiceamount', $invoiceAmount);
        $stmt->bindParam(':invoiceid', $invoiceId);
        $stmt->bindParam(':policyid', $policyId);
        $stmt->execute();

        $this->UpdateAction("tblInvoices", $invoiceId, $userId);
    }

    public function Delete($invoiceId, $userId) {
        $stmt = $this->conn->prepare("UPDATE tblInvoices
                                        SET DeletedBy = :userId,
                                            DeletedDate = now()
                                        WHERE InvoiceId = :invoiceId");
        $stmt->bindParam(':invoiceId', $invoiceId);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        $this->DeleteAction("tblInvoices", $invoiceId, $userId);
    }

    public function Undelete($invoiceId, $userId) {
        $stmt = $this->conn->prepare("UPDATE tblInvoices
                                        SET DeletedBy = NULL,
                                            DeletedDate = NULL
                                        WHERE InvoiceId = :invoiceId");
        $stmt->bindParam(':invoiceId', $invoiceId);
        $stmt->execute();
        $this->UndeleteAction("tblInvoices", $invoiceId, $userId);
    }
    
    public function Remove($invoiceId, $userId) {
        $stmt = $this->conn->prepare("DELETE FROM tblInvoices
                                        WHERE InvoiceId = :invoiceId");
        $stmt->bindParam(':invoiceId', $invoiceId);
        $stmt->execute();
        $this->RemoveAction("tblInvoices", $invoiceId, $userId);
    }
}
?>