<?php 
$pageName = "Dashboard";
include_once "../inc/sessions.php";

require_once "../inc/header.inc.php";
require_once '../classes/classes.php';
include_once '../inc/config.inc.php';

$db = new DbConn;
$stmt = $db->conn->prepare("SELECT COUNT(DISTINCT P.PolicyId) ActivePolicies, COUNT(DISTINCT PP.PersonId) MembersAlive 
                            FROM tblpolicies P LEFT JOIN lnkpersonpolicies PP ON PP.PolicyId = P.PolicyId
                            WHERE 
                            CASE WHEN PP.DateRemoved IS NULL THEN now() ELSE PP.DateRemoved END >= now()
                            AND 
                            now() BETWEEN CASE WHEN P.StartDate IS NULL THEN now() ELSE P.StartDate END 
                            AND CASE WHEN P.EndDate IS NULL THEN now() ELSE P.EndDate END ");
$stmt->execute();
$results = $stmt->fetch();
$totalPolicies = $results["ActivePolicies"];
$totalUsers = $results["MembersAlive"];
$stmt = $db->conn->prepare("SELECT SUM(TotalAmount) TotalInvoices FROM tblinvoices");
$stmt->execute();
$results = $stmt->fetch();
$totalInvoices = $results["TotalInvoices"];
$stmt = $db->conn->prepare("SELECT SUM(Amount) TotalPayments FROM tblpayments");
$stmt->execute();
$results = $stmt->fetch();
$totalPayments = $results["TotalPayments"];
?>
  
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php echo $totalPolicies ?></h3>

              <p>Total Active Policies</p>
            </div>
            <div class="icon">
              <i class="fa fa-file-text"></i>
            </div>
            <a href="<?php echo "{$baseUrl}/members" ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><sup style="font-size: 20px">R</sup><?php echo formatcurrency("",$totalInvoices,"") ?></h3>

              <p>Total Invoices</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="<?php echo "{$baseUrl}/finance/invoices.php" ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><sup style="font-size: 20px">R</sup><?php echo formatcurrency("",$totalPayments,"") ?></h3>

              <p>Total Payments</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="<?php echo "{$baseUrl}/finance/payments.php" ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $totalUsers; ?></h3>

              <p>Total Covered Individuals</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-people"></i>
            </div>
            <a href="<?php echo "{$baseUrl}/members" ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
    
<?php require_once "../inc/footer.inc.php" ?>

<?php
      if (isset($_SESSION["Permissions"])) {
    ?>
    <script>
      $(document).ready(function(){
        $('#modal-permissions').modal("show");
      });
    </script>
    <div class="modal modal-danger fade" id="modal-permissions">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Access Denied</h4>
        </div>
        <div class="modal-body">
          <p><?php echo $_SESSION["Permissions"] ?></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
    <?php
      unset($_SESSION["Permissions"]);
      }
    ?>