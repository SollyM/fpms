<?php 
include_once "../inc/sessions.php";

$pageName = "Invoice Management";
include_once '../inc/permissions.inc.php';
require_once "../inc/header.inc.php";
require_once '../classes/classes.php';
include_once '../inc/config.inc.php';

$mode = isset($_POST['mode']) ? $_POST['mode'] : "view";

try {
    
    $invoice = new Invoice;
    $invoices = $invoice->GetAll();
?>
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title"><?php echo $pageName ?></h3>
        <button type="button" id="addInvoice" class="btn btn-primary pull-right <?php echo ($mode=="view") ? "" : "hidden" ?>">Create Invoice</button>
      </div>
      <!-- /.box-header -->
      <div class="box-body">        
        <table id="MainTable" role="grid" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Policy Number</th>
              <th>Invoice Number</th>
              <th>Invoice Date</th>
              <th>Total Amount</th>
              <th>Raised By</th>
              <th>Raised Date</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // Gets query result
            foreach($invoices as $result) {

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

              echo "<tr data-invid='".$result["InvoiceId"]."' data-polid='".$result["PolicyId"]."' data-polnum='".$result["PolicyNumber"]."'>
                    <td><a href='{$baseUrl}/members/details.php?polid=".$result["PolicyId"]."&mode=view'>".$result["PolicyNumber"]."</a></td>
                    <td class='invnum'>".$result["InvoiceNumber"]."</td>
                    <td class='invdate'>".$result["InvoiceDate"]."</td>
                    <td>R <span class='invamt'>".$result["TotalAmount"]."</span></td>
                    <td class='raisedby'>".$result["FirstName"]. ' ' .$result["LastName"]."</td>
                    <td class='raiseddate'>".$result["RaisedDate"]."</td>
                    <td>
                    "; //<a href='#' class='editInvoice'>Details</a>
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
                echo "
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
              <th>Invoice Number</th>
              <th>Invoice Date</th>
              <th>Total Amount</th>
              <th>Raised By</th>
              <th>Raised Date</th>
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
<div class="modal fade" id="modal-invoice">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="invoice-save.php">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Invoice</h4>
                </div>
                <div class="modal-body">
                    <div class="box box-warning">
                        <!-- form start -->
                        <div class="box-body">
                        <input type="hidden" id="mode" name="mode" value="create">
                        <input type="hidden" id="invoiceId" name="invoiceId" value="0">
                        <input type="hidden" id="policyId" name="policyId" value="0">
                        <div class="row">
                                <div class="form-group col-md-6 col-sm-12">
                                    <label for="policy">Policy Number</label>
                                    <select id="policy" name="policy" class="form-control">
                                        <option value=""> -- Policy Number --</option>
                                        <?php
                                            $p = new PolicyPlan;
                                            $policies = $p->PolicyList();

                                            foreach ($policies as $policy) {
                                                echo "<option value='{$policy["PolicyId"]}' data-premium='{$policy["PolicyPremium"]}'";
                                                echo ">{$policy["PolicyNumber"]}</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-6 col-sm-12">
                                    <label for="invoiceNumber">Invoice Number</label>
                                    <input <?php echo ($mode!="view") ? "disabled" : "" ?> type="text" class="form-control" id="invoiceNumber" name="invoiceNumber" placeholder="Invoice Number">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 col-sm-12">
                                    <label for="invoiceAmount">Total Amount</label>
                                    <a href="#" id="premiumAmount" class="pull-right"><em>(premium amount)</em></a>
                                    <div class="input-group">
                                        <span class="input-group-addon">R</span>
                                        <input <?php echo ($mode!="view") ? "disabled" : "" ?> type="text" class="form-control" id="invoiceAmount" name="invoiceAmount" placeholder="Total Amount">
                                    </div>
                                </div>
                                <div class="form-group col-md-6 col-sm-12">
                                    <label for="invoiceDate">Invoice Date</label>
                                    <input <?php echo ($mode!="view") ? "disabled" : "" ?> type="text" class="form-control general-date" id="invoiceDate" name="invoiceDate" placeholder="Invoice Date">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 col-sm-12">
                                    <label for="invoiceRaisedBy">Raised By</label>
                                    <input disabled type="text" class="form-control" id="invoiceRaisedBy" name="invoiceRaisedBy" placeholder="Raised By">
                                </div>
                                <div class="form-group col-md-6 col-sm-12">
                                    <label for="invoiceRaisedDate">Date Raised</label>
                                    <input disabled type="text" class="form-control general-date" id="invoiceRaisedDate" name="invoiceRaisedDate" placeholder="Date Raised">
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning pull-left" data-dismiss="modal">Cancel</button>
                    <button id="btnSave" type="submit" class="btn btn-primary<?php echo ($mode=="view") ? "" : " hidden" ?>">Create Invoice</button>
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
            <form method="post" action="invoice-save.php">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Delete Plan</h4>
                </div>
                <div class="box-body">
                    <input type="hidden" id="invoiceId" name="invoiceId" value="0">
                    <input type="hidden" id="mode" name="mode" value="del">
                    <p>Are you sure you want to <span id="action">delete</span> invoice# <span id="invoiceNumber"></span>?</p>
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
$subMenuItem = "menuInvoices";

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

    $('.general-date').datepicker({ 
        autoclose: true,
        format: 'yyyy-mm-dd',
        orientation: "bottom left",
        todayHighlight: true
    });

    $('#addInvoice').on('click', function() {
        $('#policyId').val('');
        $('#policy').val('');
        $('#policy').attr("disabled", false);
        $('#invoiceId').val('0');
        $('#invoiceNumber').val('');
        $('#invoiceDate').val('');
        $('#invoiceAmount').val('');
        $('#invoiceRaisedBy').val('<?php echo $userFullName ?>');
        $('#invoiceRaisedDate').val('<?php echo date("Y-m-d") ?>');
        $('#mode').val('create');
        
        $('#btnSave').text("Create Invoice");
        $('#modal-invoice').find("h4").text("Create Invoice");
        $('#modal-invoice').modal('show');
    });

    $('.details').on('click', function() {
        var tr = $(this).closest('tr');
        var invid = tr.data('invid'),
            polid = tr.data('polid'),
            polnum = tr.data('polnum'),
            invnum = tr.find('.invnum').text(),
            invamt = tr.find('.invamt').text(),
            invdate = tr.find('.invdate').text(),
            raisedby = tr.find('.raisedby').text(),
            raiseddate = tr.find('.raiseddate').text();

        $('#invoiceId').val(invid);
        $("#policyId").val(polid);
        $("#policy").val(polid);
        $("#policy").attr("disabled", true);
        $('#invoiceNumber').val(invnum);
        $('#invoiceAmount').val(invamt);
        $('#invoiceDate').val(invdate);
        $('#invoiceRaisedBy').val(raisedby);
        $('#invoiceRaisedDate').val(raiseddate);
        
        $('#mode').val('edit');
        $('#btnSave').text("Save Invoice");
        $('#modal-invoice').find("h4").text("Edit Invoice");
        $('#modal-invoice').modal('show');
    });

  $('.delete').on("click", function() {
    var tr = $(this).closest('tr');
    var invid = tr.data('invid'),
        invnum = tr.find('.invnum').text();

    $('#modal-delete #invoiceId').val(invid);
    $('#modal-delete #action').text("delete");
    $('#modal-delete #invoiceNumber').text(invnum);
    $('#modal-delete #mode').val("del");
    $('#modal-delete').find("h4").text("Delete Invoice");
    $('#modal-delete #btnSave').text("Delete");
    $('#modal-delete').modal("show");
    });

  $('.undelete').on("click", function() {
    var tr = $(this).closest('tr');
    var invid = tr.data('invid'),
        invnum = tr.find('.invnum').text();
    
    $('#modal-delete #invoiceId').val(invid);
    $('#modal-delete #action').text("undelete");
    $('#modal-delete #invoiceNumber').text(invnum);
    $('#modal-delete #mode').val("undel");
    $('#modal-delete').find("h4").text("Undelete Invoice");
    $('#modal-delete #btnSave').text("Undelete");
    $('#modal-delete').modal("show");
  });

  $('.remove').on("click", function() {
    var tr = $(this).closest('tr');
    var invid = tr.data('invid'),
        invnum = tr.find('.invnum').text();
    
    $('#modal-delete #invoiceId').val(invid);
    $('#modal-delete #action').text("remove");
    $('#modal-delete #invoiceNumber').text(invnum);
    $('#modal-delete #mode').val("remove");
    $('#modal-delete').find("h4").text("Remove Invoice");
    $('#modal-delete #btnSave').text("Remove");
    $('#modal-delete').modal("show");
  });

    $('#premiumAmount').on('click', function() {
        var premium = $('#policy option:selected').data('premium');
        $('#invoiceAmount').val(premium);
    });

    $('#policy').on('change', function(){
        var policyId = $('#policy option:selected').val();
        console.log(policyId);
        $("#policyId").val(policyId);
    });
});
</script>