<?php
class PolicyPerson extends ActionLog {
    public function GetByPolicyId ($policyId, $personTypeId) {
        $stmt = $this->conn->prepare("SELECT * FROM lnkpersonpolicies WHERE policyid = :policyid AND persontypeid = :persontypeid");
        $stmt->bindParam(':policyid', $policyId);
        $stmt->bindParam(':persontypeid', $personTypeId);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function GetByPersonId ($policyId, $personId) {
        $stmt = $this->conn->prepare("SELECT * FROM lnkPersonPolicies WHERE policyId = :policyId AND personId = :personId");
        $stmt->bindParam(':policyId', $policyId);
        $stmt->bindParam(':personId', $personId);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function Create($policyId, $personId, $personTypeId, $relationshipId, $userId) {
        $check = $this->GetByPersonId($policyId, $personId);
        $personPolicyId = $check["PersonPolicyId"];

        if ($personPolicyId == NULL) {
            $stmt = $this->conn->prepare("INSERT INTO lnkpersonpolicies (PolicyId, PersonId, PersonTypeId, RelationshipId, DateAdded)
                                        VALUES (:policyid, :personid, :persontypeid, :relationshipId, now())");
            $stmt->bindParam(':policyid', $policyId);
            $stmt->bindParam(':personid', $personId);
            $stmt->bindParam(':persontypeid', $personTypeId);
            $stmt->bindParam(':relationshipId', $relationshipId);
            $stmt->execute();

            $check = $this->GetByPersonId($policyId, $personId);
            $personPolicyId = $check["PersonPolicyId"];

            $this->CreateAction('lnkPersonPolicies', $personPolicyId, $userId);
        }

        return $personPolicyId;
    }
    
    public function Update($policyId, $personId, $personTypeId, $relationshipId, $userId) {
        $check = $this->GetByPersonId($policyId, $personId);
        $personPolicyId = $check["PersonPolicyId"];

        echo " [ Update->PersonPolicyId={$personPolicyId}..";

        if ($personPolicyId > 0) {
            echo ".start.";
            $stmt = $this->conn->prepare("UPDATE lnkpersonpolicies 
                                        SET PolicyId = :policyid, 
                                        PersonId = :personid, 
                                        PersonTypeId = :persontypeid, 
                                        RelationshipId = :relationshipId
                                        WHERE PersonPolicyId = :personPolicyId");
            $stmt->bindParam(':policyid', $policyId);
            $stmt->bindParam(':personid', $personId);
            $stmt->bindParam(':persontypeid', $personTypeId);
            $stmt->bindParam(':relationshipId', $relationshipId);
            $stmt->bindParam(':personPolicyId', $personPolicyId);
            $stmt->execute();

            echo "..done ] ";
            
            $this->UpdateAction('lnkPersonPolicies', $personPolicyId, $userId);

            return 1;
        }

        return 0;
    }
}
?>