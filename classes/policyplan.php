<?php
class PolicyPlan extends ActionLog {
    public function Create($planName, $defaultPremium, $activeFrom, $activeTo, $userId) {
        $check = $this->GetByName($planName);

        if ($check["PlanName"] == NULL) {
            $stmt = $this->conn->prepare("INSERT INTO tblpolicyplans 
                                                    (PlanName, DefaultPremium, ActiveFrom, ActiveTo, CreatedBy, CreatedDate) 
                                            VALUES (:planname, :defaultpremium, :activefrom, :activeto, :userId, now())");
            $stmt->bindParam(':planname', $planName);
            $stmt->bindParam(':defaultpremium', $defaultPremium);
            $stmt->bindParam(':activefrom', ($activeFrom == '' ? NULL : $activeFrom));
            $stmt->bindParam(':activeto', ($activeTo == '' ? NULL : $activeTo));
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();

            $result = $this->GetByName($planName);

            $this->CreateAction('tblPolicyPlans', $result["PolicyPlanId"], $userId);
        
            return 1;
        }
        else
            return 0;
    }

    public function Read($planId) {
        $stmt = $this->conn->prepare("SELECT * FROM tblpolicyplans WHERE PolicyPlanId = :planId");
        $stmt->bindParam(':planId', $planId);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    public function GetByName($planName) {
        $stmt = $this->conn->prepare("SELECT * FROM tblpolicyplans WHERE PlanName = :planName");
        $stmt->bindParam(':planName', $planName);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function GetAll() {
        $stmt = $this->conn->prepare("SELECT T.*, P.InUse FROM `tblpolicyplans` T 
                                      LEFT JOIN (SELECT PolicyPlanId, COUNT(PolicyPlanId) InUse 
                                      FROM tblpolicies GROUP BY PolicyPlanId
                                      ) P ON P.PolicyPlanId = T.PolicyPlanId");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function PolicyList() {
        $stmt = $this->conn->prepare("SELECT PolicyId, PolicyNumber, PolicyPremium FROM tblpolicies ORDER BY PolicyNumber");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function Update($planId, $planName, $defaultPremium, $activeFrom, $activeTo, $userId) {
        $check = $this->GetByName($planName);

        if (isnull($check["PolicyPlanId"],$planId) == $planId) {
            $stmt = $this->conn->prepare("UPDATE tblpolicyplans 
                                         SET PlanName = :planName, 
                                             DefaultPremium = :defaultPremuim, 
                                             ActiveFrom = :activeFrom, 
                                             ActiveTo = :activeTo,
                                             ModifiedBy = :userId,
                                             ModifiedDate = now()
                                       WHERE PolicyPlanId = :planId");
            $stmt->bindParam(':planId', $planId);
            $stmt->bindParam(':planName', $planName);
            $stmt->bindParam(':defaultPremuim', $defaultPremium);
            $stmt->bindParam(':activeFrom', ($activeFrom == '' ? NULL : $activeFrom));
            $stmt->bindParam(':activeTo', ($activeTo == '' ? NULL : $activeTo));
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();

            $this->UpdateAction('tblPolicyPlans', $planId, $userId);

            return 1;
        }
        else
            return 0;
    }

    public function Delete($planId, $userId) {
        $stmt = $this->conn->prepare("UPDATE tblpolicyplans 
                                         SET DeletedBy = :userId, 
                                             DeletedDate = now() 
                                       WHERE PolicyPlanId = :planid");
        $stmt->bindParam(':planid', $planId);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();

        $this->DeleteAction('tblpolicyplans', $planId, $userId);
    }

    public function Undelete($planId, $userId) {
        $stmt = $this->conn->prepare("UPDATE tblpolicyplans 
                                         SET DeletedBy = NULL, 
                                             DeletedDate = NULL 
                                       WHERE PolicyPlanId = :planid");
        $stmt->bindParam(':planid', $planId);
        $stmt->execute();

        $this->UndeleteAction('tblpolicyplans', $planId, $userId);
    }

    public function Remove($planId, $userId) {
        $stmt = $this->conn->prepare("DELETE FROM tblpolicyplans 
                                       WHERE PolicyPlanId = :planid");
        $stmt->bindParam(':planid', $planId);
        $stmt->execute();

        $this->RemoveAction('tblpolicyplans', $planId, $userId);
    }
}
?>