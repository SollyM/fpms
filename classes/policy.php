<?php

class Policy extends ActionLog {

    public function Create($policyNumber, $manualPolicyNumber, $policyPlanId, $policyPremium, $policyStartDate, $policyEndDate, $agentName, $agentCode, $userId) {

        $check = $this->GetByPolicyNumber($policyNumber);

        if ($check["PolicyId"] == NULL) {
            $stmt = $this->conn->prepare("INSERT INTO tblpolicies
                                            (PolicyNumber, ManualPolicyNumber, PolicyPlanId, PolicyPremium, StartDate, EndDate, AgentName, AgentCode)
                                            VALUES
                                            (:policynumber, :manualpolicynumber, :policyplanid, :policypremium, :startdate, :enddate, :agentname, :agentcode)");

            $stmt->bindParam(':policynumber', $policyNumber);
            $stmt->bindParam(':agentname', $agentName);
            $stmt->bindParam(':agentcode', $agentCode);
            $stmt->bindParam(':manualpolicynumber', $manualPolicyNumber);
            $stmt->bindParam(':policyplanid', $policyPlanId);
            $stmt->bindParam(':policypremium', $policyPremium);
            $stmt->bindParam(':startdate', ($policyStartDate == '' ? NULL : $policyStartDate));
	        $stmt->bindParam(':enddate', ($policyEndDate == '' ? NULL : $policyEndDate));
            $stmt->execute();

            $check = $this->GetByPolicyNumber($policyNumber);

            $policyId = $check["PolicyId"];

            $this->CreateAction('tblpolicies', $policyId, $userId);

            return $policyId;
        }
        else {
            return $check["PolicyId"];
        }

    }

    public function GetById($policyId) {

        $stmt = $this->conn->prepare("SELECT * FROM tblpolicies WHERE PolicyId = :policyId");
        $stmt->bindParam(':policyId', $policyId);
        $stmt->execute();

        return $stmt->fetch();

    }

    public function GetByPolicyNumber($policyNumber) {

        $stmt = $this->conn->prepare("SELECT * FROM tblpolicies WHERE PolicyNumber = :policyNumber");
        $stmt->bindParam(":policyNumber", $policyNumber);
        $stmt->execute();
        return $stmt->fetch();

    }

    public function GetAll() {

    }

    public function Update($policyId, $manualPolicyNumber, $policyPlanId, $policyPremium, $policyStartDate, $policyEndDate, $userId) {
        $stmt = $this->conn->prepare("UPDATE tblpolicies
                                         SET ManualPolicyNumber = :manualpolicynumber,
                                             PolicyPlanId = :policyplanid,
                                             PolicyPremium = :policypremium,
                                             StartDate = :startdate,
                                             EndDate = :enddate
                                       WHERE PolicyId = :policyid");

        $stmt->bindParam(':policyid', $policyId);
        $stmt->bindParam(':manualpolicynumber', $manualPolicyNumber);
        $stmt->bindParam(':policyplanid', $policyPlanId);
        $stmt->bindParam(':policypremium', $policyPremium);
        $stmt->bindParam(':startdate', $policyStartDate);
        $stmt->bindParam(':enddate', $policyEndDate);
        $stmt->execute();

        $this->CreateAction('tblpolicies', $policyId, $userId);
    }

} 
?>