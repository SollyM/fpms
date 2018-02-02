<?php
class PersonType extends ActionLog {
    public function GetById($id){
        $stmt = $this->conn->prepare("SELECT PersonTypeId Id, PersonType Name, IsActive, DeletedDate FROM refPersonTypes WHERE PersonTypeId = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    public function GetByName($name){
        $stmt = $this->conn->prepare("SELECT * FROM refPersonTypes WHERE PersonType = :name");
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function GetAll() {
        $stmt = $this->conn->prepare("SELECT PT.PersonTypeId Id, PT.PersonType Name, IsActive, DeletedDate, P.InUse FROM `refpersontypes` PT LEFT JOIN (SELECT PersonTypeId, COUNT(PersonTypeId) InUse FROM lnkpersonpolicies GROUP BY PersonTypeId) P ON P.PersonTypeId = PT.PersonTypeId");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function Create($name, $isActive, $userId) {
        $check = $this->GetByName($name);

        if ($check[0] == NULL) {
            $stmt = $this->conn->prepare("INSERT INTO refPersonTypes (PersonType, IsActive, CreatedBy, CreatedDate) 
                                               VALUES (:name, :isactive, :userId, now())");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':isactive', $isActive);
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();

            $result = $this->GetByName($name);

            $this->CreateAction('refPersonTypes', $result["PersonTypeId"], $userId);

            return 1;
        }
        else {
            return 0;
        }
    }

    public function Update($id, $name, $isActive, $userId) {
        $check = $this->GetByName($name);
        if ($check["PersonTypeId"] == $id) {
            $stmt = $this->conn->prepare("UPDATE refPersonTypes 
                                                SET PersonType = :name, 
                                                    IsActive = ". $isActive ."
                                            WHERE PersonTypeId = :id");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':name', $name);
            $stmt->execute();

            $this->UpdateAction('refPersonTypes', $id, $userId);

            return 1;
        }
        else {
            return 0;
        }
    }
    
    public function Delete($id, $userId) {
        $stmt = $this->conn->prepare("UPDATE refPersonTypes 
                                         SET DeletedBy = :userId, 
                                             DeletedDate = now() 
                                       WHERE PersonTypeId = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();

        $this->DeleteAction('refPersonTypes', $id, $userId);
    }

    public function Undelete($id, $userId) {
        $stmt = $this->conn->prepare("UPDATE refPersonTypes 
                                         SET DeletedBy = NULL, 
                                             DeletedDate = NULL 
                                       WHERE PersonTypeId = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $this->UndeleteAction('refPersonTypes', $id, $userId);
    }

    public function Remove($id, $userId) {
        $stmt = $this->conn->prepare("DELETE FROM refPersonTypes 
                                       WHERE PersonTypeId = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $this->RemoveAction('refPersonTypes', $id, $userId);
    }
}
?>