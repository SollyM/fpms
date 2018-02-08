<?php 
$pageName = "Users";
include_once '../inc/permissions.inc.php';

require_once "../inc/header.inc.php";
require_once '../classes/classes.php';
include_once '../inc/config.inc.php';

try {
    $db = new DbConn;
    $stmt = $db->conn->prepare("SELECT U.*, R.RoleName FROM tblusers U LEFT JOIN refroles R ON R.RoleId = U.RoleId");
    $stmt->execute();
?>
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title"><?php echo $pageName ?></h3>
        <?php if ($up->CanCreate) { ?>
        <a href="user-details.php?mode=add" class="btn btn-primary pull-right">Add New</a>
        <?php } ?>
      </div>
      <!-- /.box-header -->
      <div class="box-body">        
        <table id="MainTable" role="grid" class="table table-bordered table-striped">
          <thead>
            <tr>
                <th class="sorting">User ID</th>
                <th class="sorting">User Name</th>
                <th class="sorting">First Name</th>
                <th class="sorting">Last Name</th>
                <th class="sorting">Role</th>
                <th class="sorting">Engaged Date</th>
                <th class="sorting">Is Verified?</th>
                <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // Gets query result
            while($result = $stmt->fetch()) {

              echo "<tr>
                    <td>".$result["id"]."</td>
                    <td>".$result["username"]."</td>
                    <td>".$result["FirstName"]."</td>
                    <td>".$result["LastName"]."</td>
                    <td>".$result["RoleName"]."</td>
                    <td>".$result["DateEngaged"]."</td>
                    <td>".($result["verified"] == 1 ? "Yes" : "No")."</td>
                    <td>
                    [ <a href='user-details.php?uid=".$result["id"]."'>Details</a> ]
                    </td>
                    </tr>";
                    //| 
                    //<a href='delete.php?id=".$result["PolicyId"]."'>Delete</a> ]
            }
            ?>
          </tbody>
          <tfoot>
            <tr>
                <th class="sorting">User ID</th>
                <th class="sorting">User Name</th>
                <th class="sorting">First Name</th>
                <th class="sorting">Last Name</th>
                <th class="sorting">Role</th>
                <th class="sorting">Engaged Date</th>
                <th class="sorting">Is Verified?</th>
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
$menuItem = "menuUsersRoles";
$subMenuItem = "menuUsers";

require_once "../inc/footer.inc.php" ?>
<script>
$(function () {
  $('#MainTable').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true,
      'aaSorting' : [[ 5, 'asc']]
  });
  $('#MainTable_paginate').addClass("pull-right");
  $('#MainTable_filter').addClass("pull-right");
});
</script>