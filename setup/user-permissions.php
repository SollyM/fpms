<?php 
include_once "../inc/sessions.php";

$pageName = "User Permissions";

require_once "../inc/header.inc.php";
require '../classes/classes.php';
include_once '../inc/config.inc.php';


try {
    $up = new UserPermission;
    $perms = $up->GetAll();
?>
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title"><?php echo $pageName; ?></h3>
        <button type="button" id="addRole" class="btn btn-primary pull-right">Add New</button>
      </div>
      <!-- /.box-header -->
      <div class="box-body">        
        <table id="MainTable" role="grid" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th class="sorting">Role Name</th>
              <th class="sorting">Page Path</th>
              <th class="sorting">View</th>
              <th class="sorting">Add</th>
              <th class="sorting">Update</th>
              <th class="sorting">Delete</th>
              <th class="sorting">Remove</th>
              <th class="sorting">Error Level</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // Gets query result
            
            foreach($perms as $perm) {

            //   $del = "";
            //   if (isset($_SESSION["RolePriority"]) && $_SESSION["RolePriority"] >= 9000 && $role["DeletedDate"] != NULL) {
            //       $del = "u";
            //   }
            //   elseif (isset($_SESSION["RolePriority"]) && $_SESSION["RolePriority"] >= 9000 && $role["InUse"] == NULL) {
            //     $del = "d";
            //   }
            //   elseif (isset($_SESSION["RolePriority"]) && $_SESSION["RolePriority"] < 9000 && $role["DeletedDate"] != NULL) {
            //       $del = "s";
            //   }
            //   else {
            //       $del = "";
            //   }

                echo "<tr data-permid='{$perm["UserPermissionId"]}'>";
                echo "   <td></td>";
                echo "   <td></td>";
                echo "   <td></td>";
                echo "   <td></td>";
                echo "   <td></td>";
                echo "   <td></td>";
                echo "   <td></td>";
                echo "   <td></td>";
                echo "   <td></td>";
                echo "</tr>";
            
            //   echo "<tr data-roleid='".$role["RoleId"]."'>
            //         <td class='rolename'>".$role["RoleName"]."</td>
            //         <td class='rolepriority'>".$role["Priority"]."</td>
            //         <td class='isactive'>".($role["IsActive"] ? "Yes" : "No")."</td>
            //         <td>".($role["InUse"] != NULL ? "Yes" : "No")."</td>
            //         <td>
            //         [ "; //<a class='editRole' href='#'>Details</a> ]
            //         switch($del) {
            //           case "s":
            //               echo "DELETED";
            //               break;
            //           case "d":
            //               echo "<a href='#' class='details'>Details</a> | <a href='#' class='delete'>Delete</a>";
            //               break;
            //           case "u":
            //               echo "<a href='#' class='details'>Details</a> | <a href='#' class='undelete'>Undelete</a> | <a href='#' class='remove'>Remove</a>";
            //               break;
            //           default:
            //               echo "<a href='#' class='details'>Details</a>";
            //               break;
            //       }
            //         echo " ] </td>
            //         </tr>";
            //         //<a href='dropdown.php?id=".$result["PolicyPlanId"]."&type=persontype&mode=view'>Details</a> | 
            //         //| 
            //         //<a href='delete.php?id=".$result["PolicyPlanId"]."'>Delete</a> ]
            }
            ?>
          </tbody>
          <tfoot>
            <tr>
            <th class="sorting">Role Name</th>
            <th class="sorting">Page Path</th>
            <th class="sorting">View</th>
            <th class="sorting">Add</th>
            <th class="sorting">Update</th>
            <th class="sorting">Delete</th>
            <th class="sorting">Remove</th>
            <th class="sorting">Error Level</th>
            <th>Actions</th>
          </tr>
          </tfoot>
        </table>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        <?php
        if (isset($_SESSION["Saved"])) {
            echo $_SESSION["Saved"];
            unset($_SESSION["Saved"]);
        }
        ?>
      </div>
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->
</div>
<div class="modal fade" id="modal-roles">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="roles-save.php">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Create Role</h4>
                </div>
                <div class="modal-body">
                    <div class="box box-warning">
                        <!-- form start -->
                        <div class="box-body">
                          <input type="hidden" id="roleId" name="roleId" value="0">
                          <input type="hidden" id="mode" name="mode" value="create">
                            <div class="row">
                                <div class="form-group col-md-6 col-sm-12">
                                    <label for="roleName">Role Name</label>
                                    <input type="text" class="form-control" id="roleName" name="roleName" placeholder="Role Name">
                                </div>
                                <div class="form-group col-md-3 col-sm-12">
                                  <label for="rolePriority">Priority</label>
                                  <input type="text" class="form-control" id="rolePriority" name="rolePriority" placeholder="Priority">
                              </div>
                              <div class="form-group col-md-3 col-sm-12">
                                  <label for="isActive">Is Active?</label>
                                  <select class="form-control" name="isActive" id="isActive">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                  </select>
                              </div>
                          </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning pull-left" data-dismiss="modal">Cancel</button>
                    <button id="btnSave" type="submit" class="btn btn-primary">Create Role</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<div class="modal fade" id="modal-roles-delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="roles-save.php">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Delete Role</h4>
                </div>
                <div class="box-body">
                    <input type="hidden" id="roleId" name="roleId" value="0">
                    <input type="hidden" id="mode" name="mode" value="del">
                    <p>Are you sure you want to <span id="action">delete</span> <span id="roleName"></span> role?</p>
                </div>
                <!-- /.box-body -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                    <button id="btnSave" type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<?php
} catch (PDOException $e) {
            
    $err = "Error: " . $e->getMessage();
            
}

$openMenu = true;
$menuItem = "menuUsersRoles";
$subMenuItem = "menuRoles";

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
    'aaSorting' : [[ 1, 'asc']]
  });
  $('#MainTable_paginate').addClass("pull-right");
  $('#MainTable_filter').addClass("pull-right");

  $('#addRole').on('click', function() {
    $('#modal-roles #roleId').val(0);
    $('#roleName').val('');
    $('#rolePriority').val('');
    $('#isActive').val('');
    $('#modal-roles #mode').val('create');

    $('#modal-roles').modal("show");
  });

  $('.details').on('click', function() {
    var tr = $(this).closest('tr');
    var roleid = tr.data('roleid'),
        rolename = tr.find('.rolename').text(),
        rolepriority = tr.find('.rolepriority').text(),
        isactive = tr.find('.isactive').text();

    $('#modal-roles #roleId').val(roleid);
    $('#roleName').val(rolename);
    $('#rolePriority').val(rolepriority);
    $("#isActive").find("option:contains("+isactive+")").each(function() {
      var $this = $(this).val();
      $("#isActive").val($this);
    });
    $('#modal-roles #mode').val('update');

    $('#modal-roles #btnSave').text("Save Role");
    $('#modal-roles').find("h4").text("Edit Role");
    $('#modal-roles').modal('show');
  });

  $('.delete').on("click", function() {
    var tr = $(this).closest('tr');
    var pid = tr.data('roleid'),
        pname = tr.find('.rolename').text();

    $('#modal-roles-delete #roleId').val(pid);
    $('#modal-roles-delete #action').text("delete");
    $('#modal-roles-delete #roleName').text(pname);
    $('#modal-roles-delete #mode').val("del");
    $('#modal-roles-delete').find("h4").text("Delete Role");
    $('#modal-roles-delete #btnSave').text("Delete");
    $('#modal-roles-delete').modal("show");
    });

  $('.undelete').on("click", function() {
    var tr = $(this).closest('tr');
    var pid = tr.data('roleid'),
        pname = tr.find('.rolename').text();
    
    $('#modal-roles-delete #roleId').val(pid);
    $('#modal-roles-delete #action').text("undelete");
    $('#modal-roles-delete #roleName').text(pname);
    $('#modal-roles-delete #mode').val("undel");
    $('#modal-roles-delete').find("h4").text("Undelete Role");
    $('#modal-roles-delete #btnSave').text("Undelete");
    $('#modal-roles-delete').modal("show");
  });

  $('.remove').on("click", function() {
    var tr = $(this).closest('tr');
    var pid = tr.data('roleid'),
        pname = tr.find('.rolename').text();
    
    $('#modal-roles-delete #roleId').val(pid);
    $('#modal-roles-delete #action').text("remove");
    $('#modal-roles-delete #roleName').text(pname);
    $('#modal-roles-delete #mode').val("remove");
    $('#modal-roles-delete').find("h4").text("Remove Role");
    $('#modal-roles-delete #btnSave').text("Remove");
    $('#modal-roles-delete').modal("show");
  });
});
</script>