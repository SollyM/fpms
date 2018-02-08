<?php 
include_once "../inc/sessions.php";

$pageName = "Policy Plan Setup";
include_once '../inc/permissions.inc.php';

require_once "../inc/header.inc.php";
require_once '../classes/classes.php';
include_once '../inc/config.inc.php';


try {

    $p = new PolicyPlan;
    $policies = $p->GetAll();
    
?>
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title"><?php echo $pageName; ?></h3>
        <button type="button" id="add" class="btn btn-primary pull-right">Add New</a>
      </div>
      <!-- /.box-header -->
      <div class="box-body">        
        <table id="MainTable" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Plan Name</th>
              <th>Default Premium</th>
              <th>Active From</th>
              <th>Active To</th>
              <th>In Use?</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // Gets query result
            
            foreach($policies as $result) {

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

              echo "<tr data-pid='".$result["PolicyPlanId"]."' data-action='". $del ."'>
                    <td class='pname'>".$result["PlanName"]."</td>
                    <td>R<span class='pprem'>".formatCurrency('', $result["DefaultPremium"], '')."</span></td>
                    <td class='activefrom'>".$result["ActiveFrom"]."</td>
                    <td class='activeto'>".$result["ActiveTo"]."</td>
                    <td>".($result["InUse"] != NULL ? "Yes" : "No")."</td>
                    <td>
                    [ ";
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
//                    ($result["InUse"] == NULL ? "| <a href='#' class='delete'>Delete</a> " : "")
              echo " ]
                    </td>
                    </tr>";
                    //<a href='dropdown.php?id=".$result["PolicyPlanId"]."&type=persontype&mode=view'>Details</a> | 
                    //| 
                    //<a href='delete.php?id=".$result["PolicyPlanId"]."'>Delete</a> ]
            }
            ?>
          </tbody>
          <tfoot>
            <tr>
              <th>Plan Name</th>
              <th>Default Premium</th>
              <th>Active From</th>
              <th>Active To</th>
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
<div class="modal fade" id="modal-plan">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="plans-save.php">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add Plan</h4>
                </div>
                <div class="box-body">
                    <input type="hidden" id="policyPlanId" name="policyPlanId" value="0">
                    <input type="hidden" id="mode" name="mode" value="view">
                    <div class="row">
                        <div class="form-group col-md-8 col-sm-12">
                            <label for="name">Plan Name</label>
                            <input type="text" class="form-control" id="planName" name="planName">
                        </div>
                        <div class="form-group col-md-4 col-sm-12">
                            <label for="name">Default Premium</label>
                            <div class="input-group">
                              <span class="input-group-addon">R</span>
                              <input class="form-control" id="defaultPremium" name="defaultPremium">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="activeFrom">Active From</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="text" class="form-control datetime" id="activeFrom" name="activeFrom">
                                <a id="clearActiveFrom" href="#" class="input-group-addon"><i class="fa fa-close"></i></a>
                            </div>
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="activeTo">Active To</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="text" class="form-control datetime" id="activeTo" name="activeTo">
                                <a id="clearActiveTo" href="#" class="input-group-addon"><i class="fa fa-close"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning pull-left" data-dismiss="modal">Cancel</button>
                    <button id="btnSave" type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<div class="modal fade" id="modal-plan-delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="plans-save.php">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Delete Plan</h4>
                </div>
                <div class="box-body">
                    <input type="hidden" id="deletePolicyPlanId" name="policyPlanId" value="0">
                    <input type="hidden" id="mode" name="mode" value="del">
                    <p>Are you sure you want to <span id="action">delete</span> <span id="deletePlanName"></span> plan?</p>
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
$menuItem = "menuPolicySetup";
$subMenuItem = "menuPolicyPlans";

require_once "../inc/footer.inc.php" ?>
<script>
$(function () {
  $('#MainTable').DataTable({
      'aaSorting' : [[ 1, 'asc']]
  });
  $('#MainTable_paginate').addClass("pull-right");
  $('#MainTable_filter').addClass("pull-right");
  
$('.datetime').daterangepicker({
    timePicker: true,
    timePickerIncrement: 1,
    autoUpdateInput: true,
    locale: {
        format: "YYYY-MM-DD H:mm",
        cancelLabel: 'Clear'
    },
    singleDatePicker: true,
    timePicker24Hour: true
});

  $('#add').on('click', function() {
      $('#PolicyPlanId').val('0');
      $('#planName').val('');
      $('#defaultPremium').val('');
      $('#activeFrom').val('');
      $('#activeTo').val('');
      $('#modal-plan #mode').val('add');
      
      $('#btnSave').text("Add Plan");
      $('#modal-plan').modal('show');
  });

  $('.details').on('click', function() {
      var tr = $(this).closest('tr');
      var pid = tr.data('pid'),
          act = tr.data('action'),
          pname = tr.find('.pname').text(),
          pprem = tr.find('.pprem').text(),
          activefrom = tr.find('.activefrom').text();
          activeto = tr.find('.activeto').text();

      $('#policyPlanId').val(pid);
      $('#planName').val(pname);
      $('#defaultPremium').val(pprem);
      $('#activeFrom').val(activefrom);
      $('#activeTo').val(activeto);
      $('#modal-plan #mode').val('edit');

      if (act == 'u') {
        $('#planName').attr("disabled", "disabled");
        $('#defaultPremium').attr("disabled", "disabled");
        $('#activeFrom').attr("disabled", "disabled");
        $('#activeTo').attr("disabled", "disabled");
        $('#clearActiveFrom').addClass("hidden");
        $('#clearActiveTo').addClass("hidden");
        $('#modal-plan #btnSave').addClass("hidden");
      }

      $('#modal-plan #btnSave').text("Save Plan");
      $('#modal-plan').find("h4").text("Edit Plan");
      $('#modal-plan').modal('show');
  });

  $('.delete').on("click", function() {
    var tr = $(this).closest('tr');
    var pid = tr.data('pid'),
        pname = tr.find('.pname').text();
    
    $('#deletePolicyPlanId').val(pid);
    $('#action').text("delete");
    $('#deletePlanName').text(pname);
    $('#modal-plan-delete #mode').val("del");
    $('#modal-plan-delete #btnSave').text("Delete");
    $('#modal-plan-delete').modal("show");
  });

  $('.undelete').on("click", function() {
    var tr = $(this).closest('tr');
    var pid = tr.data('pid'),
        pname = tr.find('.pname').text();
    
    $('#deletePolicyPlanId').val(pid);
    $('#action').text("undelete");
    $('#deletePlanName').text(pname);
    $('#modal-plan-delete #mode').val("undel");
    $('#modal-plan-delete #btnSave').text("Undelete");
    $('#modal-plan-delete').modal("show");
  });

  $('.remove').on("click", function() {
    var tr = $(this).closest('tr');
    var pid = tr.data('pid'),
        pname = tr.find('.pname').text();
    
    $('#deletePolicyPlanId').val(pid);
    $('#action').text("remove");
    $('#deletePlanName').text(pname);
    $('#modal-plan-delete #mode').val("remove");
    $('#modal-plan-delete #btnSave').text("Remove");
    $('#modal-plan-delete').modal("show");
  });

  $('#clearActiveFrom').on("click", function(v) {
    $('#activeFrom').val('');
  });

  $('#clearActiveTo').on("click", function(v) {
    $('#activeTo').val('');
  });
});
</script>