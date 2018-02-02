<?php
class ActionLog extends DBConn {
    private $actionCreate = 1;
    private $actionUpdate = 2;
    private $actionDelete = 3;
    private $actionUndelete = 4;
    private $actionRemove = 5;

    private function Act($tableName, $tableId, $actionId, $actionBy) {
        $stmt = $this->conn->prepare("INSERT INTO tblLog (TableName, TableId, ActionId, ActionBy, ActionDate) VALUES (:tableName, :tableId, :actionId, :userId, :actionDate)");
        $stmt->bindParam(':tableName', $tableName);
        $stmt->bindParam(':tableId', $tableId);
        $stmt->bindParam(':actionId', $actionId);
        $stmt->bindParam(':userId', $actionBy);
        $stmt->bindParam(':actionDate', date("Y-m-d H:m:s"));
        $stmt->execute();
    }
    
    public function CreateAction($tableName, $tableId, $userId) {
        $this->Act($tableName, $tableId, $this->actionCreate, $userId);
    }
    
    public function UpdateAction($tableName, $tableId, $userId) {
        $this->Act($tableName, $tableId, $this->actionUpdate, $userId);
    }
    
    public function DeleteAction($tableName, $tableId, $userId) {
        $this->Act($tableName, $tableId, $this->actionDelete, $userId);
    }
    
    public function UndeleteAction($tableName, $tableId, $userId) {
        $this->Act($tableName, $tableId, $this->actionUndelete, $userId);
    }
    
    public function RemoveAction($tableName, $tableId, $userId) {
        $this->Act($tableName, $tableId, $this->actionRemove, $userId);
    }
}
?>