<?php 
include_once "../inc/sessions.php";
$pageName = "Payments Management";
include_once '../inc/permissions.inc.php';
require_once "../inc/header.inc.php";
require_once '../classes/classes.php';
include_once '../inc/config.inc.php';

$mode = isset($_POST['mode']) ? $_POST['mode'] : "view";

try {
    
    $db = new DbConn;
    $p = new Payment;
    $payments = $p->GetAll();
?>
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title"><?php echo $pageName ?></h3>
        <button type="button" id="addPayment" class="btn btn-primary pull-right <?php echo ($mode=="view") ? "" : "hidden" ?>">Record Payment</button>
      </div>
      <!-- /.box-header -->
      <div class="box-body">        
        <table id="MainTable" role="grid" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Policy Number</th>
              <th>Payment Amount</th>
              <th>Payment Date</th>
              <th>Captured By</th>
              <th>Captured Date</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // Gets query result
            foreach($payments as $result) {

                $del = "";
                if (isset($_SESSION["RolePriority"]) && $_SESSION["RolePriority"] >= 9000 && $result["DeletedDate"] != NULL) {
                    $del = "u";
                }
                elseif (isset($_SESSION["RolePriority"]) && $_SESSION["RolePriority"] >= 9000 && $result["DeletedDate"] == NULL) {
                    $del = "d";
                }
                elseif (isset($_SESSION["RolePriority"]) && $_SESSION["RolePriority"] < 9000 && $result["DeletedDate"] != NULL) {
                    $del = "s";
                }
                else {
                    $del = "";
                }

              echo "<tr data-payid='".$result["PaymentId"]."' data-polnum='".$result["PolicyNumber"]."'>
                    <td><a href='{$baseUrl}/members/details.php?polid=".$result["PaymentId"]."&mode=view'>".$result["PolicyNumber"]."</a></td>
                    <td>R <span class='payamt'>".$result["Amount"]."</span></td>
                    <td class='paydate'>".$result["PaymentForDate"]."</td>
                    <td class='capby'>".$result["FirstName"]. ' ' .$result["LastName"]."</td>
                    <td class='capdate'>".$result["CapturedDate"]."</td>
                    <td>
                    [ "; //<a href='#' class='editPayment'>Details</a>

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

                echo " ]
                    </td>
                    </tr>";
                    //| 
                    //<a href='delete.php?id=".$result["PolicyId"]."'>Delete</a> ]
            }
            ?>
          </tbody>
          <tfoot>
            <tr>
              <th>Policy Number</th>
              <th>Payment Amount</th>
              <th>Payment Date</th>
              <th>Captured By</th>
              <th>Captured Date</th>
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
<div class="modal fade" id="modal-payment">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="payment-save.php">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Record Payment</h4>
                </div>
                <div class="modal-body">
                    <div class="box box-warning">
                        <!-- form start -->
                        <div class="box-body">
                        <input type="hidden" id="mode" name="mode" value="create">
                        <input type="hidden" id="paymentId" name="paymentId" value="0">
                            <div class="row">
                                <div class="form-group col-md-12 col-sm-12">
                                    <label for="policyId">Policy Number</label>
                                    <select id="policyId" name="policyId" class="form-control">
                                        <option value=""> -- Policy Number --</option>
                                        <?php
                                            $pp = new PolicyPlan;
                                            $policies = $pp->PolicyList();

                                            foreach ($policies as $policy) {
                                                echo "<option value='{$policy["PolicyId"]}' data-premium='{$policy["PolicyPremium"]}'";
                                                echo ">{$policy["PolicyNumber"]}</option>";
                                            }
                                        ?>
                                    </select>
                                    <input type="text" id="policyNumber" name="policyNumber" class="form-control hidden" disabled />
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 col-sm-12">
                                    <label for="paymentAmount">Payment Amount</label>
                                    <a href="#" id="premiumAmount" class="pull-right"><em>(premium amount)</em></a>
                                    <div class="input-group">
                                    <span class="input-group-addon">R</span>
                                    <input <?php echo ($mode!="view") ? "disabled" : "" ?> type="text" class="form-control" id="paymentAmount" name="paymentAmount" placeholder="Payment Amount">
                                    </div>
                                </div>
                                <div class="form-group col-md-6 col-sm-12">
                                    <label for="paymentDate">Payment For</label>
                                    <input <?php echo ($mode!="view") ? "disabled" : "" ?> type="text" class="form-control general-date" id="paymentDate" name="paymentDate" placeholder="Payment For">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 col-sm-12">
                                    <label for="paymentCapturedBy">Captured By</label>
                                    <input disabled type="text" class="form-control" id="paymentCapturedBy" name="paymentCapturedBy" placeholder="Captured By">
                                </div>
                                <div class="form-group col-md-6 col-sm-12">
                                    <label for="paymentCapturedDate">Captured Date</label>
                                    <input disabled type="text" class="form-control general-date" id="paymentCapturedDate" name="paymentCapturedDate" placeholder="Captured Date" value="<?php echo date(); ?>">
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning pull-left" data-dismiss="modal">Cancel</button>
                    <button id="btnSave" type="submit" class="btn btn-primary<?php echo ($mode=="view") ? "" : " hidden" ?>">Record Payment</button>
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
            <form method="post" action="payment-save.php">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Delete Payment</h4>
                </div>
                <div class="box-body">
                    <input type="hidden" id="paymentId" name="paymentId" value="0">
                    <input type="hidden" id="mode" name="mode" value="del">
                    <p>Are you sure you want to <span id="action">delete</span> payment for policy# <span id="policyNumber"></span>?</p>
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
$menuItem = "menuFinances";
$subMenuItem = "menuPayments";

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
        'aaSorting' : [[ 0, 'asc'], [4, 'desc']]
    });
    $('#MainTable_paginate').addClass("pull-right");
    $('#MainTable_filter').addClass("pull-right");

    $('.general-date').datepicker({ 
        autoclose: true,
        format: 'yyyy-mm-dd',
        orientation: "bottom left",
        todayHighlight: true
    });

    $('#addPayment').on('click', function() {
        $('#paymentId').val('0');
        $('#policyId').val('');
        $('#policyId').removeClass('hidden');
        $('#policyNumber').addClass('hidden');
        $('#paymentAmount').val('');
        $('#paymentDate').val('');
        $('#modal-payment #mode').val('create');
        $('#paymentCapturedDate').val('<?php echo date("Y-m-d") ?>');
        $('#paymentCapturedBy').val('<?php echo $userFullName ?>');
        
        $('#btnSavePayment').text("Record Payment");
        $('#modal-payment').modal('show');
    });

    $('.details').on('click', function() {
        var tr = $(this).closest('tr');
        var payid = tr.data('payid'),
            polnum = tr.data('polnum'),
            payamt = tr.find('.payamt').text(),
            paydate = tr.find('.paydate').text(),
            capby = tr.find('.capby').text(),
            capdate = tr.find('.capdate').text();

        $('#paymentId').val(payid);
        $("#policyId").find("option:contains("+polnum+")").each(function() {
            var $this = $(this).val();
            $("#policyId").val($this);
        });
        $("#policyId").addClass("hidden");
        $('#policyNumber').val(polnum);
        $('#policyNumber').removeClass("hidden");
        $('#paymentAmount').val(payamt);
        $('#paymentDate').val(paydate);
        $('#paymentCapturedBy').val(capby);
        $('#paymentCapturedDate').val(capdate);
        $('#modal-payment #mode').val('update');
        
        $('#btnSave').text("Save Payment");
        $('#modal-payment').find("h4").text("Edit Payment");
        $('#modal-payment').modal('show');
    });

  $('.delete').on("click", function() {
    var tr = $(this).closest('tr');
    var payid = tr.data('payid'),
        polnum = tr.data('polnum');

    $('#modal-delete #paymentId').val(payid);
    $('#modal-delete #action').text("delete");
    $('#modal-delete #policyNumber').text(polnum);
    $('#modal-delete #mode').val("del");
    $('#modal-delete').find("h4").text("Delete Payment");
    $('#modal-delete #btnSave').text("Delete");
    $('#modal-delete').modal("show");
    });

  $('.undelete').on("click", function() {
    var tr = $(this).closest('tr');
    var payid = tr.data('payid'),
        polnum = tr.data('polnum');

    $('#modal-delete #paymentId').val(payid);
    $('#modal-delete #action').text("undelete");
    $('#modal-delete #policyNumber').text(polnum);
    $('#modal-delete #mode').val("undel");
    $('#modal-delete').find("h4").text("Undelete Payment");
    $('#modal-delete #btnSave').text("Undelete");
    $('#modal-delete').modal("show");
  });

  $('.remove').on("click", function() {
    var tr = $(this).closest('tr');
    var payid = tr.data('payid'),
        polnum = tr.data('polnum');

    $('#modal-delete #paymentId').val(payid);
    $('#modal-delete #action').text("remove");
    $('#modal-delete #policyNumber').text(polnum);
    $('#modal-delete #mode').val("remove");
    $('#modal-delete').find("h4").text("Remove Payment");
    $('#modal-delete #btnSave').text("Remove");
    $('#modal-delete').modal("show");
  });

    $('#premiumAmount').on('click', function() {
        var premium = $('#policyId option:selected').data('premium');
        $('#paymentAmount').val(premium);
    });
});
</script>