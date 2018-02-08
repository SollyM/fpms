<?php
class UserPermission extends ActionLog {
    private $tblName = "tblUserPermissions";
    public $Id = -1;
    public $CanView = 0;
    public $CanCreate = 0;
    public $CanUpdate = 0;
    public $CanDelete = 0;
    public $CanRemove = 0;
    public $ErrorLevelId = 2;

    public function GetById($permissionId){
        $stmt = $this->conn->prepare("SELECT * FROM tblUserPermissions WHERE UserPermissionId = :permissionId");
        $stmt->bindParam(':permissionId', $permissionId);
        $stmt->execute();

        $results = $stmt->fetch();

        if ($results[0] > 0) {
            $Id = $results["UserPermissionId"];
            $CanView = $results["CanView"];
            $CanCreate = $results["CanCreate"];
            $CanUpdate = $results["CanUpdate"];
            $CanDelete = $results["CanDelete"];
            $CanRemove = $results["CanRemove"];
            $ErrorLevelId = $results["ErrorLevelId"];
        }
        else {
            $CanView = 0;
            $CanCreate = 0;
            $CanUpdate = 0;
            $CanDelete = 0;
            $CanRemove = 0;
            $ErrorLevelId = 2;
        }

        return $results;
    }
    
    public function GetByRoleId($roleId) {
        $stmt = $this->conn->prepare("SELECT * FROM tblUserPermissions WHERE RoleId = :roleId AND PagePath = :pagePath");
        $stmt->bindParam(':roleId', $roleId);
        $stmt->bindParam(':pagePath', $pagePath);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function GetByRolePath($roleId, $pagePath){
        $stmt = $this->conn->prepare("SELECT * FROM tblUserPermissions WHERE RoleId = :roleId AND PagePath = :pagePath");
        $stmt->bindParam(':roleId', $roleId);
        $stmt->bindParam(':pagePath', $pagePath);
        $stmt->execute();
        $results = $stmt->fetch();

        if (!is_null($results[0])) {
            $this->Id = $results["UserPermissionId"];
            $this->CanView = $results["CanView"];
            $this->CanCreate = $results["CanCreate"];
            $this->CanUpdate = $results["CanUpdate"];
            $this->CanDelete = $results["CanDelete"];
            $this->CanRemove = $results["CanRemove"];
            $this->ErrorLevelId = $results["ErrorLevelId"];
        }
        else {
            $this->CanView = 0;
            $this->CanCreate = 0;
            $this->CanUpdate = 0;
            $this->CanDelete = 0;
            $this->CanRemove = 0;
            $this->ErrorLevelId = 2;
        }

        return $results;
    }

    public function GetAll() {
        $stmt = $this->conn->prepare("SELECT UP.*, R.RoleName FROM tblUserPermissions UP LEFT JOIN refRoles R ON R.RoleId = UP.RoleId");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function Create($roleId, $pagePath, $canView, $canCreate, $canUpdate, $canDelete, $canRemove, $errorLevelId, $userId) {
        $check = $this->GetByRolePath($roleId, $pagePath);

        if ($check[0] == NULL) {
            $stmt = $this->conn->prepare("INSERT INTO tblUserPermissions 
                                                    (RoleId, PagePath, CanView, CanCreate, CanUpdate, CanDelete, CanRemove, ErrorLevelId) 
                                             VALUES (:roleId, :pagePath, :canView, :canCreate, :canUpdate, :canDelete, :canRemove, :errorLevelId)");
            $stmt->bindParam(':roleId', $roleId);
            $stmt->bindParam(':pagePath', $pagePath);
            $stmt->bindParam(':canView', $canView);
            $stmt->bindParam(':canCreate', $canCreate);
            $stmt->bindParam(':canUpdate', $canUpdate);
            $stmt->bindParam(':canDelete', $canDelete);
            $stmt->bindParam(':canRemove', $canRemove);
            $stmt->bindParam(':errorLevelId', $errorLevelId);
            $stmt->execute();

            $result = $this->GetByRolePath($roleId, $pagePath);

            $this->CreateAction('tblUserPermissions', $result["UserPermissionId"], $userId);

            return $result["UserPermissionId"];
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
        $stmt = $this->conn->prepare("UPDATE refRoles 
                                         SET DeletedBy = :userId, 
                                             DeletedDate = now() 
                                       WHERE RoleId = :roleId");
        $stmt->bindParam(':roleId', $roleId);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();

        $this->DeleteAction('refRoles', $roleId, $userId);
    }

    public function Undelete($roleId, $userId) {
        $stmt = $this->conn->prepare("UPDATE refRoles 
                                            SET DeletedBy = NULL, 
                                                DeletedDate = NULL 
                                          WHERE RoleId = :roleId");
        $stmt->bindParam(':roleId', $roleId);
        $stmt->execute();

        $this->UndeleteAction('refRoles', $roleId, $userId);
    }

    public function Remove($roleId, $userId) {
        $stmt = $this->conn->prepare("DELETE FROM refRoles 
                                       WHERE RoleId = :roleId");
        $stmt->bindParam(':roleId', $roleId);
        $stmt->execute();

        $this->RemoveAction($this->tblName, $roleId, $userId);
    }
}
?>