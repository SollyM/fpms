<?php 
include_once "../inc/sessions.php";
$pageName = "User Permissions";
require_once "../inc/permissions.inc.php";

require_once "../inc/header.inc.php";
require_once '../classes/classes.php';
include_once '../inc/config.inc.php';


try {
    $ups = new UserPermission;
    $perms = $ups->GetAll();
?>
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title"><?php echo $pageName; ?></h3>
        <?php if ($up->CanCreate) { ?><button type="button" id="addNew" class="btn btn-primary pull-right">Add New</button><?php } ?>
      </div>
      <!-- /.box-header -->
      <div class="box-body">        
        <table id="MainTable" role="grid" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th class="sorting">Role Name</th>
              <th class="sorting">Page Path</th>
              <th class="sorting">View</th>
              <th class="sorting">Create</th>
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

                $str = '';
                if ($perm["DeletedDate"] != NULL) {
                    if(!$up->CanDelete)
                        $str = "DELETED";
                    
                    if ($up->CanUpdate)
                        $str = "<a href='#' class='details'>Details</a>";
                    
                    if($up->CanDelete)
                        $str = $str . " | <a href='#' class='undelete'>Undelete</a>";
                    
                    if($up->CanRemove)
                        $str = $str . " | <a href='#' class='remove'>Remove</a>";
                }
                else {
                    if ($up->CanUpdate)
                        $str = $str . "<a href='#' class='details'>Details</a>";

                    if ($up->CanDelete) {
                        if ($str != '') $str = $str . " | ";
                        $str = $str . " <a href='#' class='delete'>Delete</a>";
                    }
                }

                echo "<tr data-permid='{$perm["UserPermissionId"]}' data-roleid='{$perm["RoleId"]}'>";
                echo "   <td>{$perm["RoleName"]}</td>";
                echo "   <td class='pagePath'>{$perm["PagePath"]}</td>";
                echo "   <td><input type='checkbox' ". ($perm["CanView"] ? "checked " : "") ."id='chkView'></td>";
                echo "   <td><input type='checkbox' ". ($perm["CanCreate"] ? "checked " : "") ."id='chkCreate'></td>";
                echo "   <td><input type='checkbox' ". ($perm["CanUpdate"] ? "checked " : "") ."id='chkUpdate'></td>";
                echo "   <td><input type='checkbox' ". ($perm["CanDelete"] ? "checked " : "") ."id='chkDelete'></td>";
                echo "   <td><input type='checkbox' ". ($perm["CanRemove"] ? "checked " : "") ."id='chkRemove'></td>";
                echo "   <td>{$perm["ErrorLevelId"]}</td>";
                echo "   <td>";
                    
                    if ($str != '')
                        echo "[ {$str} ]";

                    
                echo "   </td>";
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
            <th>Role Name</th>
            <th>Page Path</th>
            <th>View</th>
            <th>Create</th>
            <th>Update</th>
            <th>Delete</th>
            <th>Remove</th>
            <th>Error Level</th>
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
<div class="modal fade" id="modal-update">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="user-permissions-save.php">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Create User Permission</h4>
                </div>
                <div class="modal-body">
                    <div class="box box-warning">
                        <!-- form start -->
                        <div class="box-body">
                        <input type="hidden" id="userPermissionId" name="userPermissionId" value="0">
                        <input type="hidden" id="mode" name="mode" value="create">
                            <div class="row">
                                <div class="form-group col-md-4 col-sm-12">
                                    <label for="roleId">Role Name</label>
                                    <select class="form-control" name="roleId" id="roleId">
                                    <?php
                                        $clsRoles = new Role;
                                        $roles = $clsRoles->GetAll();

                                        foreach($roles as $role) {
                                            echo "<option value='{$role["RoleId"]}'>{$role["RoleName"]}</option>";
                                        }
                                    ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-8 col-sm-12">
                                  <label for="pagePath">Page Path</label>
                                  <input type="text" class="form-control" id="pagePath" name="pagePath" placeholder="Page Path">
                              </div>
                            </div>
                            <div class="row">
                              <div class="form-group col-md-4 col-sm-6">
                                  <label for="canView">Can View?</label>
                                  <select class="form-control" name="canView" id="canView">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                  </select>
                              </div>
                              <div class="form-group col-md-4 col-sm-6">
                                  <label for="canCreate">Can Create?</label>
                                  <select class="form-control" name="canCreate" id="canCreate">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                  </select>
                              </div>
                              <div class="form-group col-md-4 col-sm-6">
                                  <label for="canUpdate">Can Update?</label>
                                  <select class="form-control" name="canUpdate" id="canUpdate">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                  </select>
                              </div>
                              <div class="form-group col-md-4 col-sm-6">
                                  <label for="isActive">Can Delete?</label>
                                  <select class="form-control" name="canView" id="canView">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                  </select>
                              </div>
                              <div class="form-group col-md-4 col-sm-6">
                                  <label for="isActive">Can Remove?</label>
                                  <select class="form-control" name="canView" id="canView">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                  </select>
                              </div>
                              <div class="form-group col-md-4 col-sm-4">
                                  <label for="errorLevelId">Error Level</label>
                                  <select class="form-control" name="errorLevelId" id="errorLevelId">
                                    <?php 
                                        $clsEL = new ErrorLevel;
                                        $els = $clsEL->GetAll();

                                        foreach($els as $el) {
                                            echo "<option value='{$el["Id"]}'>{$el["Name"]}</option>";
                                        }
                                    ?>
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
                    <button id="btnSave" type="submit" class="btn btn-primary">Create User Permission</button>
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
    echo $err;

}

$openMenu = true;
$menuItem = "menuUsersRoles";
$subMenuItem = "menuUserPermissions";

require_once "../inc/footer.inc.php" ?>
<script>
$(document).ready(function () {
  $('.details').on('click', function() {
    var tr = $(this).closest('tr');
    var roleId = tr.data('roleid'),
        userPermissionId = tr.data('permid'),
        pagePath = tr.find('.pagePath').text(),
        canView = tr.find('checkbox:chkView').is('checked');
        console.log('CanView='+canView);

    $('#modal-update #userPermissionId').val(userPermissionId);
    $('#modal-update #roleId').val(roleId);
    $('#pagePath').val(pagePath);
    //$('#rolePriority').val(rolepriority);
    ///$("#isActive").find("option:contains("+isactive+")").each(function() {
    //  var $this = $(this).val();
    //  $("#isActive").val($this);
    //});
    $('#modal-update #mode').val('update');

    $('#modal-update #btnSave').text("Save User Permission");
    $('#modal-update').find("h4").text("Edit User Permission");
    $('#modal-update').modal('show');
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

  $('#MainTable').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true,
    'aaSorting' : [[ 0, 'asc'], [ 1, 'asc']]
  });
  $('#MainTable_paginate').addClass("pull-right");
  $('#MainTable_filter').addClass("pull-right");

  $('#addNew').on('click', function() {
    $('#modal-update #roleId').val(0);
    $('#pagePath').val('');
    $('#rolePriority').val('');
    $('#isActive').val('');
    $('#modal-update #mode').val('create');

    $('#modal-update').modal("show");
  });
});
</script>