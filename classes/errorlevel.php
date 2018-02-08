<?php
class ErrorLevel extends ActionLog {
    public function GetById($id){
        $stmt = $this->conn->prepare("SELECT ErrorLevelId Id, ErrorLevelName Name, IsActive, DeletedDate FROM referrorlevels WHERE ErrorLevelId = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    public function GetByName($name){
        $stmt = $this->conn->prepare("SELECT * FROM referrorlevels WHERE ErrorLevelName = :name");
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function GetAll() {
        $stmt = $this->conn->prepare("SELECT T.ErrorLevelId Id, T.ErrorLevelName Name, IsActive, DeletedDate, P.PTCount InUse FROM `referrorlevels` T LEFT JOIN (SELECT ErrorLevelId, COUNT(ErrorLevelId) PTCount FROM tbluserpermissions GROUP BY ErrorLevelId) P ON P.ErrorLevelId = T.ErrorLevelId");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function Create($name, $isActive, $userId) {
        $check = $this->GetByName($name);
        if ($check[0] == NULL) {
            $stmt = $this->conn->prepare("INSERT INTO referrorlevels (ErrorLevelName, IsActive, CreatedBy, CreatedDate) 
                                               VALUES (:name, :isactive, :userId, now())");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':isactive', $isActive);
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();

            $result = $this->GetByName($name);

            $this->CreateAction('referrorlevels', $result["ErrorLevelId"], $userId);

            return 1;
        }
        else {
            return 0;
        }
    }

    public function Update($id, $name, $isActive, $userId) {
        $check = $this->GetByName($name);
        if ($check["ErrorLevelId"] == NULL || $check["ErrorLevelId"] == $id) {
            $stmt = $this->conn->prepare("UPDATE referrorlevels 
                                        SET ErrorLevelName = :name, 
                                            IsActive = ". $isActive ."
                                      WHERE ErrorLevelId = :id");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':name', $name);
            $stmt->execute();

            $this->UpdateAction('referrorlevels', $id, $userId);

            return 1;
        }
        else {
            return 0;
        }
    }
    
    public function Delete($id, $userId) {
        $stmt = $this->conn->prepare("UPDATE referrorlevels 
                                         SET DeletedBy = :userId, 
                                             DeletedDate = now() 
                                       WHERE ErrorLevelId = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();

        $this->DeleteAction('referrorlevels', $id, $userId);
    }

    public function Undelete($id, $userId) {
        $stmt = $this->conn->prepare("UPDATE referrorlevels 
                                            SET DeletedBy = NULL, 
                                                DeletedDate = NULL 
                                          WHERE ErrorLevelId = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $this->UndeleteAction('referrorlevels', $id, $userId);
    }

    public function Remove($id, $userId) {
        $stmt = $this->conn->prepare("DELETE FROM referrorlevels 
                                       WHERE ErrorLevelId = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $this->RemoveAction('referrorlevels', $id, $userId);
    }
}
?>