<?php 
$pageName = "Edit Member";
require_once "../inc/header.inc.php";
require_once '../classes/classes.php';
include_once '../inc/config.inc.php';
?>

<div class="container">

    <?php

try {
    
    $db = new DbConn;
$stmt = $db->conn->prepare("SELECT * FROM tblpersons WHERE PersonId = {$_GET['id']}");
    $stmt->execute();

    echo '<form method="post" action="'. esc_url($_SERVER['REQUEST_URI']).'">';
    echo '<table class="table">';
    
    // Gets query result
    $result = $stmt->fetch();

    echo "  <tr><td>Person Id:</td><td>".$result["PersonId"]."</td></tr>
            <tr><td>First Name:</td><td><input class='form-control' name='firstName' id='firstName' value='".$result["FirstName"]."'></td></tr>
            <tr><td>Middle Names:</td><td><input class='form-control' name='middleNames' id='middleNames' value='".$result["MiddleNames"]."'></td></tr>
            <tr><td>Last Name:</td><td><input class='form-control' name='lastName' id='lastName' value='".$result["LastName"]."'></td></tr>
            <tr><td colspan='2'><a class='btn btn-red' href='./'>Back</a> <button type='submit' class='btn btn-green'>Save</button></td></tr>";

    echo '</table>';
    echo '</form>';
        
} catch (PDOException $e) {
            
    $err = "Error: " . $e->getMessage();
            
}

?>

</div>

<?php require_once "../inc/footer.inc.php" ?>