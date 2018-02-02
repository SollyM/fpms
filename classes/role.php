<?php
class Role extends ActionLog {
    private $tblName = "refRoles";

    public function GetById($roleId){
        $stmt = $this->conn->prepare("SELECT * FROM refroles WHERE roleId = :roleid");
        $stmt->bindParam(':roleid', $roleId);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    public function GetByName($roleName){
        $stmt = $this->conn->prepare("SELECT * FROM refroles WHERE RoleName = :roleName");
        $stmt->bindParam(':roleName', $roleName);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function GetAll() {
        $stmt = $this->conn->prepare("SELECT R.*, U.InUse FROM `refroles` R LEFT JOIN (SELECT RoleId, COUNT(RoleId) InUse FROM tblusers GROUP BY RoleId) U ON U.RoleId = R.RoleId ORDER BY Priority");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function Create($roleName, $rolePriority, $isActive, $userId) {
        $check = $this->GetByName($roleName);

        if ($check[0] == NULL) {
            $stmt = $this->conn->prepare("INSERT INTO refroles 
                                                    (RoleName, Priority, IsActive, CreatedBy, CreatedDate) 
                                             VALUES (:roleName, :rolePriority, ". $isActive .", :userId, now())");
            $stmt->bindParam(':roleName', $roleName);
            $stmt->bindParam(':rolePriority', $rolePriority);
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();

            $result = $this->GetByName($roleName);

            $this->CreateAction('refRoles', $result["RoleId"], $userId);

            return 1;
        }
        else
            return 0;
    }

    public function Update($roleId, $roleName, $rolePriority, $isActive, $userId) {
        $check = $this->GetByName($roleName);
        
        if ($check["RoleId"] == $roleId) {
            $stmt = $this->conn->prepare("UPDATE refroles 
                                         SET RoleName = :roleName, 
                                             Priority = :rolePriority, 
                                             IsActive = ". $isActive ." 
                                       WHERE RoleId = :roleId");
            $stmt->bindParam(':roleId', $roleId);
            $stmt->bindParam(':roleName', $roleName);
            $stmt->bindParam(':rolePriority', $rolePriority);
            $stmt->execute();

            $this->UpdateAction('refRoles', $roleId, $userId);

            return 1;
        }
        else
            return 0;
    }
    
    public function Delete($roleId, $userId) {
        $stmt = $this->conn->prepare("UPDATE refroles 
                                         SET DeletedBy = :userId, 
                                             DeletedDate = now() 
                                       WHERE RoleId = :roleId");
        $stmt->bindParam(':roleId', $roleId);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();

        $this->DeleteAction('refRoles', $roleId, $userId);
    }

    public function Undelete($roleId, $userId) {
        $stmt = $this->conn->prepare("UPDATE refroles 
                                            SET DeletedBy = NULL, 
                                                DeletedDate = NULL 
                                          WHERE RoleId = :roleId");
        $stmt->bindParam(':roleId', $roleId);
        $stmt->execute();

        $this->UndeleteAction('refRoles', $roleId, $userId);
    }

    public function Remove($roleId, $userId) {
        $stmt = $this->conn->prepare("DELETE FROM refroles 
                                       WHERE RoleId = :roleId");
        $stmt->bindParam(':roleId', $roleId);
        $stmt->execute();

        $this->RemoveAction($this->tblName, $roleId, $userId);
    }
}
?>