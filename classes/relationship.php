<?php
class Relationship extends ActionLog {
    public function GetById($id){
        $stmt = $this->conn->prepare("SELECT RelationshipId Id, Relationship Name, IsActive, DeletedDate FROM refrelationships WHERE relationshipId = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    public function GetByName($name){
        $stmt = $this->conn->prepare("SELECT * FROM refrelationships WHERE Relationship = :name");
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function GetAll() {
        $stmt = $this->conn->prepare("SELECT T.RelationshipId Id, T.Relationship Name, IsActive, DeletedDate, P.PTCount InUse FROM `refrelationships` T LEFT JOIN (SELECT RelationshipId, COUNT(RelationshipId) PTCount FROM lnkpersonpolicies GROUP BY RelationshipId) P ON P.RelationshipId = T.RelationshipId");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function Create($name, $isActive, $userId) {
        $check = $this->GetByName($name);
        if ($check[0] == NULL) {
            $stmt = $this->conn->prepare("INSERT INTO refrelationships (Relationship, IsActive, CreatedBy, CreatedDate) 
                                               VALUES (:name, :isactive, :userId, now())");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':isactive', $isActive);
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();

            $result = $this->GetByName($name);

            $this->CreateAction('refRelationships', $result["RelationshipId"], $userId);

            return 1;
        }
        else {
            return 0;
        }
    }

    public function Update($id, $name, $isActive, $userId) {
        $check = $this->GetByName($name);
        if ($check["RelationshipId"] == NULL || $check["RelationshipId"] == $id) {
            $stmt = $this->conn->prepare("UPDATE refrelationships 
                                        SET Relationship = :name, 
                                            IsActive = ". $isActive ."
                                      WHERE RelationshipId = :id");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':name', $name);
            $stmt->execute();

            $this->UpdateAction('refRelationships', $id, $userId);

            return 1;
        }
        else {
            return 0;
        }
    }
    
    public function Delete($id, $userId) {
        $stmt = $this->conn->prepare("UPDATE refrelationships 
                                         SET DeletedBy = :userId, 
                                             DeletedDate = now() 
                                       WHERE RelationshipId = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();

        $this->DeleteAction('refRelationships', $id, $userId);
    }

    public function Undelete($id, $userId) {
        $stmt = $this->conn->prepare("UPDATE refrelationships 
                                            SET DeletedBy = NULL, 
                                                DeletedDate = NULL 
                                          WHERE RelationshipId = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $this->UndeleteAction('refRelationships', $id, $userId);
    }

    public function Remove($id, $userId) {
        $stmt = $this->conn->prepare("DELETE FROM refrelationships 
                                       WHERE RelationshipId = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $this->RemoveAction('refRelationships', $id, $userId);
    }
}
?>