<?php
class Title extends ActionLog {
    public function GetById($titleId){
        $stmt = $this->conn->prepare("SELECT TitleId Id, Title Name, IsActive, DeletedDate FROM reftitles WHERE titleId = :titleId");
        $stmt->bindParam(':titleId', $titleId);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    public function GetByName($name){
        $stmt = $this->conn->prepare("SELECT * FROM refTitles WHERE Title = :name");
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function GetAll() {
        $stmt = $this->conn->prepare("SELECT T.TitleId Id, T.Title Name, IsActive, DeletedDate, P.PTCount InUse FROM `reftitles` T LEFT JOIN (SELECT TitleId, COUNT(TitleId) PTCount FROM tblpersons GROUP BY TitleId) P ON P.TitleId = T.TitleId");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function Create($name, $isActive, $userId) {
        $check = $this->GetByName($name);

        if ($check[0] == NULL) {
            $stmt = $this->conn->prepare("INSERT INTO reftitles (Title, IsActive, CreatedBy, CreatedDate) 
                                               VALUES (:name, :isactive, :userId, now())");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':isactive', $isActive);
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();

            $result = $this->GetByName($name);

            $this->CreateAction('refTitles', $result["TitleId"], $userId);

            return 1;
        }
        else {
            return 0;
        }
    }

    public function Update($id, $name, $isActive, $userId) {
        $check = $this->GetByName($name);
        
        if ($check["TitleId"] == $id) {
            $stmt = $this->conn->prepare("UPDATE refTitles 
                                        SET Title = :name, 
                                            IsActive = ". $isActive ."
                                      WHERE TitleId = :id");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':name', $name);
            $stmt->execute();

            $this->UpdateAction('refTitles', $id, $userId);

            return 1;
        }
        else {
            return 0;
        }
    }
    
    public function Delete($id, $userId) {
        $stmt = $this->conn->prepare("UPDATE refTitles 
                                         SET DeletedBy = :userId, 
                                             DeletedDate = now() 
                                       WHERE TitleId = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();

        $this->DeleteAction('refTitles', $id, $userId);
    }

    public function Undelete($id, $userId) {
        $stmt = $this->conn->prepare("UPDATE refTitles 
                                            SET DeletedBy = NULL, 
                                                DeletedDate = NULL 
                                          WHERE TitleId = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $this->UndeleteAction('refTitles', $id, $userId);
    }

    public function Remove($id, $userId) {
        $stmt = $this->conn->prepare("DELETE FROM refTitles 
                                       WHERE TitleId = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $this->RemoveAction('refTitles', $id, $userId);
    }
}
?>