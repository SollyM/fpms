<?php 
		$pageName = "Policy Number Setup";
//		$qryGet = "SELECT T.PolicyPlanId, T.PlanName, DefaultPremium, IsActive, P.InUse FROM `tblpolicyplans` T LEFT JOIN (SELECT PolicyPlanId, COUNT(PolicyPlanId) InUse FROM tblpolicies GROUP BY PolicyPlanId) P ON P.PolicyPlanId = T.PolicyPlanId";
//		$lblNameColumn = "Title";

require_once "../inc/header.inc.php";
require '../classes/classes.php';
include_once '../inc/config.inc.php';


try {
    
//    $db = new DbConn;
//    $stmt = $db->conn->prepare($qryGet);
//    $stmt->execute();
?>
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title"><?php echo $pageName; ?></h3>
        <a href="#" disabled class="btn btn-primary pull-right">Add New</a>
      </div>
      <!-- /.box-header -->
      <div class="box-body">        
        <table id="MainTable" role="grid" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>&nbsp;</th>
              <th class="sorting">Policy Number Format</th>
              <th class="sorting">Example</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // Gets query result
            
           // while($result = $stmt->fetch()) {

              echo "<tr>
                    <td>1</td>
                    <td>DK + date(\"Y\") + / + rand(1000,9999) + / + 01 (daily increment)</td>
                    <td>".generatePolicyNumber()."</td>
                    <td>
                    [ <a href='#' disabled>Edit</a> ]
                    </td>
                    </tr>";
                    //<a href='dropdown.php?id=".$result["PolicyPlanId"]."&type=persontype&mode=view'>Details</a> | 
                    //| 
                    //<a href='delete.php?id=".$result["PolicyPlanId"]."'>Delete</a> ]
         //   }
            ?>
          </tbody>
          <tfoot>
            <tr>
              <th>&nbsp;</th>
              <th class="sorting">Policy Number Format</th>
              <th class="sorting">Example</th>
              <th>Actions</th>
            </tr>
          </tfoot>
        </table>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->
</div>

<?php
} catch (PDOException $e) {
            
    $err = "Error: " . $e->getMessage();
            
}

$openMenu = true;
$menuItem = "menuPolicySetup";
$subMenuItem = "menuPolicyNumberFormat";

require_once "../inc/footer.inc.php" ?>