<?php 
include_once "../inc/sessions.php";

$type = $_REQUEST["type"];

require '../classes/classes.php';
include_once '../inc/config.inc.php';


try {
  
switch ($type) {
    case 'title':
		$pageName = "Title Setup";
        $t = new Title;

        $lblNameColumn = "Title";
        $openMenu = true;
        $menuItem = "menuSettings";
        $subMenuItem = "menuTitles";
        break;
  
    case 'persontype':
        $pageName = "Person Type Setup";
        
        $t = new PersonType;

        $lblNameColumn = "Person Type";
        $openMenu = true;
        $menuItem = "menuSettings";
        $subMenuItem = "menuPersonTypes";
        break;
        
    case 'relationship':
        $pageName = "Relationship Setup";
        
        $t = new Relationship;

        $lblNameColumn = "Relationship";
        $openMenu = true;
        $menuItem = "menuSettings";
        $subMenuItem = "menuRelationships";
        break;

	default:
		$pageName = "Setup Error";
    break;
}

require_once "../inc/header.inc.php";

$results = $t->GetAll();
?>
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title"><?php echo $pageName; ?></h3>
        <button type="button" id="addSetting" class="btn btn-primary pull-right">Add New</button>
      </div>
      <!-- /.box-header -->
      <div class="box-body">        
        <table id="MainTable" role="grid" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th class="sorting"><?php echo $lblNameColumn ?></th>
              <th class="sorting">Active?</th>
              <th class="sorting">In Use?</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // Gets query result
            foreach($results as $result) {
              
              $del = "";
              if (isset($_SESSION["RolePriority"]) && $_SESSION["RolePriority"] >= 9000 && $result["DeletedDate"] != NULL) {
                  $del = "u";
              }
              elseif (isset($_SESSION["RolePriority"]) && $_SESSION["RolePriority"] >= 9000 && $result["InUse"] == NULL) {
                $del = "d";
              }
              elseif (isset($_SESSION["RolePriority"]) && $_SESSION["RolePriority"] < 9000 && $result["DeletedDate"] != NULL) {
                  $del = "s";
              }
              else {
                  $del = "";
              }

              echo "<tr data-setid='".$result["Id"]."'>
                    <td class='setName'>".$result["Name"]."</td>
                    <td class='isActive'>".($result["IsActive"] ? "Yes" : "No")."</td>
                    <td>".($result["InUse"] != NULL ? "Yes" : "No")."</td>
                    <td>
                    [ "; //<a href='#' class='viewDetails'>Details</a>
                    switch($del) {
                      case "s":
                          echo "DELETED";
                          break;
                      case "d":
                          echo "<a href='#' class='details'>Details</a> | <a href='#' class='delete'>Delete</a>";
                          break;
                      case "u":
                          echo "<a href='#' class='details'>Details</a> | <a href='#' class='undelete'>Undelete</a> | <a href='#' class='remove'>Remove</a>";
                          break;
                      default:
                          echo "<a href='#' class='details'>Details</a>";
                          break;
                    }
              echo "] </td>
                    </tr>";
                    //<a href='dropdown.php?id=".$result["PersonTypeId"]."&type=persontype&mode=view'>Details</a> | 
                    //| 
                    //<a href='delete.php?id=".$result["PersonTypeId"]."'>Delete</a> ]
            }
            ?>
          </tbody>
          <tfoot>
            <tr>
              <th><? echo $lblNameColumn ?></th>
              <th>Active?</th>
              <th>In Use?</th>
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
<div class="modal fade" id="modal-dropdown">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="dropdown-save.php">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?php echo $lblNameColumn ?></h4>
                </div>
                <div class="modal-body">
                    <div class="box box-warning">
                        <!-- form start -->
                        <div class="box-body">
                        <input type="hidden" id="settingId" name="settingId" value="0">
                        <input type="hidden" id="type" name="type" value="<?php echo $type ?>">
                        <input type="hidden" id="mode" name="mode" value="create">
                          <div class="row">
                              <div class="form-group col-md-9 col-sm-12">
                                  <label for="name"><?php echo $lblNameColumn ?></label>
                                  <input type="text" class="form-control" id="name" name="name" value="">
                              </div>
                              <div class="form-group col-md-3 col-sm-12">
                                  <label for="isactive">Active?</label>
                                  <select class="form-control" name="isactive" id="isactive">
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
                    <button id="btnSave" type="submit" class="btn btn-primary">Add New</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<div class="modal fade" id="modal-delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="dropdown-save.php">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Delete Plan</h4>
                </div>
                <div class="box-body">
                    <input type="hidden" id="settingId" name="settingId" value="0">
                    <input type="hidden" id="type" name="type" value="<?php echo $type ?>">
                    <input type="hidden" id="mode" name="mode" value="del">
                    <p>Are you sure you want to <span id="action">delete</span> <span id="settingName"></span> <?php echo $type ?>?</p>
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

require_once "../inc/footer.inc.php" ?>
<script>
$(function () {
  $('#MainTable').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true
  });
  $('#MainTable_paginate').addClass("pull-right");
  $('#MainTable_filter').addClass("pull-right");

  $('#addSetting').on('click', function() {
      $('#modal-dropdown #settingId').val(0);
      $('#name').val('');
      $('#isactive').val('');
      $('#modal-dropdown #mode').val('create');
      
      $('#modal-dropdown #btnSave').text("<?php echo ("Add {$lblNameColumn}"); ?>");
      $('#modal-dropdown').find("h4").text("<?php echo ("Add {$lblNameColumn}"); ?>");
      $('#modal-dropdown').modal('show');
  });

  $('.details').on('click', function() {
    var tr = $(this).closest('tr');
    var setid = tr.data('setid'),
        setname = tr.find('.setName').text(),
        isactive = tr.find('.isActive').text();

      $('#settingId').val(setid);
      $('#name').val(setname);
      $("#isactive").find("option:contains("+isactive+")").each(function() {
        var $this = $(this).val();
        $("#isactive").val($this);
      });
      $('#modal-dropdown #mode').val('update');
      
      $('#modal-dropdown #btnSave').text("<?php echo ("Save {$lblNameColumn}"); ?>");
      $('#modal-dropdown').find("h4").text("<?php echo ("Edit {$lblNameColumn}"); ?>");
      $('#modal-dropdown').modal('show');
  });

  $('.delete').on("click", function() {
    var tr = $(this).closest('tr');
    var pid = tr.data('setid'),
        pname = tr.find('.setName').text();

    $('#modal-delete #settingId').val(pid);
    $('#modal-delete #action').text("delete");
    $('#modal-delete #settingName').text(pname);
    $('#modal-delete #mode').val("del");
    $('#modal-delete').find("h4").text("<?php echo ("Delete {$lblNameColumn}"); ?>");
    $('#modal-delete #btnSave').text("Delete");
    $('#modal-delete').modal("show");
    });

  $('.undelete').on("click", function() {
    var tr = $(this).closest('tr');
    var pid = tr.data('setid'),
        pname = tr.find('.setName').text();
    
    $('#modal-delete #settingId').val(pid);
    $('#modal-delete #action').text("undelete");
    $('#modal-delete #settingName').text(pname);
    $('#modal-delete #mode').val("undel");
    $('#modal-delete').find("h4").text("<?php echo ("Undelete {$lblNameColumn}"); ?>");
    $('#modal-delete #btnSave').text("Undelete");
    $('#modal-delete').modal("show");
  });

  $('.remove').on("click", function() {
    var tr = $(this).closest('tr');
    var pid = tr.data('setid'),
        pname = tr.find('.setName').text();
    
    $('#modal-delete #settingId').val(pid);
    $('#modal-delete #action').text("remove");
    $('#modal-delete #settingName').text(pname);
    $('#modal-delete #mode').val("remove");
    $('#modal-delete').find("h4").text("<?php echo ("Remove {$lblNameColumn}"); ?>");
    $('#modal-delete #btnSave').text("Remove");
    $('#modal-delete').modal("show");
  });
});
</script>