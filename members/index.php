<?php 
$pageName = "Policy Holders";
include_once '../inc/permissions.inc.php';
require_once "../inc/header.inc.php";
require_once '../classes/classes.php';
include_once '../inc/config.inc.php';


try {
    
    $db = new DbConn;
    $stmt = $db->conn->prepare("SELECT P.*, PL.PolicyId, PL.PolicyNumber, POL.PlanName PolicyPlan, PL.StartDate, PL.EndDate 
                                FROM tblpolicies PL
                                LEFT JOIN tblpolicyplans POL ON POL.PolicyPlanId = PL.PolicyPlanId
                                LEFT JOIN (SELECT * FROM lnkpersonpolicies WHERE PersonTypeId = 1) PP ON PL.PolicyId = PP.PolicyId
                                LEFT JOIN tblpersons P ON PP.PersonId = P.PersonId");
    $stmt->execute();
?>
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Policy Holders</h3>
        <a href="details.php?mode=add" class="btn btn-primary pull-right">Add New</a>
      </div>
      <!-- /.box-header -->
      <div class="box-body">        
        <table id="MainTable" class="table table-bordered table-striped dataTable">
          <thead>
            <tr>
              <th>First Name</th>
              <th>Middle Names</th>
              <th>Last Name</th>
              <th>Policy Number</th>
              <th>Policy Plan</th>
              <th>Start Date</th>
              <th>End Date</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // Gets query result
            while($result = $stmt->fetch()) {

              echo "<tr>
                    <td>".$result["FirstName"]."</td>
                    <td>".$result["MiddleNames"]."</td>
                    <td>".$result["LastName"]."</td>
                    <td>".$result["PolicyNumber"]."</td>
                    <td>".$result["PolicyPlan"]."</td>
                    <td>".$result["StartDate"]."</td>
                    <td>".$result["EndDate"]."</td>
                    <td>
                    [ <a href='details.php?polid=".$result["PolicyId"]."&mode=view'>Details</a> ]
                    </td>
                    </tr>";
                    //| 
                    //<a href='delete.php?id=".$result["PolicyId"]."'>Delete</a> ]
            }
            ?>
          </tbody>
          <tfoot>
            <tr>
              <th>First Name</th>
              <th>Middle Names</th>
              <th>Last Name</th>
              <th>Policy Number</th>
              <th>Policy Plan</th>
              <th>Start Date</th>
              <th>End Date</th>
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
$menuItem = "menuPolicyHolders";
$subMenuItem = "menuListPolicyHolders";

require_once "../inc/footer.inc.php" ?>
<script>
$(function () {
  $('#MainTable').DataTable({
    'aaSorting' : [[ 5, 'asc']]
  });
  $('.dataTable_paginate').addClass("pull-right");
  $('.dataTable_filter').addClass("pull-right");
});
</script>