<?php
include_once "../inc/sessions.php";
$pageName = "View Member";
require_once "../inc/permissions.inc.php";
require_once "../inc/header.inc.php";
require_once '../classes/classes.php';
include_once '../inc/config.inc.php';

$mode = (isset($_GET["mode"])) ? $_GET["mode"] : "view";

try {
    $db = new DbConn;

    $p = new PolicyPlan;
    $policyPlans = $p->GetAll();

    $t = new Title;
    $titles = $t->GetAll();
    
    $pt = new PersonType;
    $persontypes = $pt->GetAll();
    
    $rel = new Relationship;
    $relationships = $rel->GetAll();

    $pol = new Policy;
    $per = new Person;
    $inv = new Invoice;
    $pay = new Payment;

    if ($mode != "add") {
        $polid = $_GET["polid"];
        $result = $pol->GetById($polid);

        $policyNumber = $result["PolicyNumber"];
        $manualPolicyNumber = $result["ManualPolicyNumber"];
        $mainPolicyPlan = $result["PolicyPlanId"];
        $policyPremium = $result["PolicyPremium"];
        $policyStartDate = $result["StartDate"];
        $policyEndDate = $result["EndDate"];
        $agentName = $result["AgentName"];
        $agentCode = $result["AgentCode"];

        $main = $per->GetByPolicyId($polid, 1);
        $spouse = $per->GetByPolicyId($polid, 2);
        
        $mainPersonId = $main["PersonId"];
        $mainFirstName = $main["FirstName"];
        $mainMiddleNames = $main["MiddleNames"];
        $mainLastName = $main["LastName"];
        $mainTitle = $main["TitleId"];
        $mainIDNumber = $main["IDNumber"];
        $mainBirthDate = $main["DateOfBirth"];
        $mainHomePhone = $main["HomePhone"];
        $mainWorkPhone = $main["WorkPhone"];
        $mainMobilePhone = $main["MobilePhone"];
        $mainHomeEmail = $main["HomeEmail"];
        $mainWorkEmail = $main["WorkEmail"];

        $spousePersonId = $spouse["PersonId"];
        $spouseFirstName = $spouse["FirstName"];
        $spouseMiddleNames = $spouse["MiddleNames"];
        $spouseLastName = $spouse["LastName"];
        $spouseTitle = $spouse["TitleId"];
        $spouseIDNumber = $spouse["IDNumber"];
        $spouseBirthDate = $spouse["DateOfBirth"];
        $spouseHomePhone = $spouse["HomePhone"];
        $spouseWorkPhone = $spouse["WorkPhone"];
        $spouseMobilePhone = $spouse["MobilePhone"];
        $spouseHomeEmail = $spouse["HomeEmail"];
        $spouseWorkEmail = $spouse["WorkEmail"];
    }
    else {
        $policyNumber = generatePolicyNumber();
        $manualPolicyNumber = "";
        $mainPolicyPlan = 0;
        $policyPremium = "";
        $policyStartDate = "";
        $policyEndDate = "";
        $agentName = "";
        $agentCode = "";
        
        $mainPersonId = "";
        $mainFirstName = "";
        $mainMiddleNames = "";
        $mainLastName = "";
        $mainTitle = 0;
        $mainIDNumber = "";
        $mainBirthDate = "";
        $mainHomePhone = "";
        $mainWorkPhone = "";
        $mainMobilePhone = "";
        $mainHomeEmail = "";
        $mainWorkEmail = "";

        $spousePersonId = "";
        $spouseFirstName = "";
        $spouseMiddleNames = "";
        $spouseLastName = "";
        $spouseTitle = 0;
        $spouseIDNumber = "";
        $spouseBirthDate = "";
        $spouseHomePhone = "";
        $spouseWorkPhone = "";
        $spouseMobilePhone = "";
        $spouseHomeEmail = "";
        $spouseWorkEmail = "";
    }
        
} catch (PDOException $e) {
            
    $err = "Error: " . $e->getMessage();
    echo $err;
}
?>
<div class="container">
    <form role="form" action="save.php" method="post">
        <div class="row">
            <div class="col-md-10">
                <!-- Custom Tabs -->
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#policydetails" data-toggle="tab">Policy Details</a></li>
                        <li><a href="#policyholder" data-toggle="tab">Policy Holder</a></li>
                        <li><a href="#spouse" data-toggle="tab">Spouse</a></li>
                        <li<?php echo $mode=="add" ? " class='hidden'" : "" ?>><a href="#addmem" data-toggle="tab">Additional Members</a></li>
                        <li<?php echo $mode=="add" ? " class='hidden'" : "" ?>><a href="#invoices" data-toggle="tab">Invoices</a></li>
                        <li<?php echo $mode=="add" ? " class='hidden'" : "" ?>><a href="#payments" data-toggle="tab">Payments</a></li>
                        <!-- <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            Dropdown <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Action</a></li>
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Another action</a></li>
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Something else here</a></li>
                            <li role="presentation" class="divider"></li>
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Separated link</a></li>
                            </ul>
                        </li>
                        <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li> -->
                    </ul>
                    <input type="hidden" name="polid" value="<?php echo $polid ?>">
                    <input type="hidden" name="mode" value="<?php echo $mode ?>">
                    <div class="tab-content">
                        <div class="tab-pane active" id="policydetails">
                            <div class="box box-warning">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="form-group col-md-3 col-sm-12">
                                            <label for="policyNumber">Policy Number</label>
                                            <input <?php echo ($mode!="add") ? "disabled" : "" ?> type="text" class="form-control" id="policyNumber" name="policyNumber" value="<?php echo $policyNumber ?>">
                                        </div>
                                        <div class="form-group col-md-3 col-sm-12">
                                            <label for="manualPolicyNumber">Manual Policy Number</label>
                                            <input <?php echo ($mode=="view") ? "disabled" : "" ?> type="text" class="form-control" id="manualPolicyNumber" name="manualPolicyNumber" value="<?php echo $manualPolicyNumber ?>">
                                        </div>
                                        <div class="form-group col-md-3 col-sm-12">
                                            <label for="policyPlan">Policy Plan</label>
                                            <select id="policyPlan" name="policyPlan" class="form-control" <?php echo ($mode=="view") ? "disabled" : "" ?>>
                                                <option value="" data-premium=""> -- Policy Plan --</option>
                                                <?php
                                                    $now = date("Y-m-d H:m");
                                                    foreach ($policyPlans as $policyPlan) {
                                                        echo "<option value='{$policyPlan["PolicyPlanId"]}' data-premium='{$policyPlan["DefaultPremium"]}'";
                                                        echo ($mainPolicyPlan==$policyPlan["PolicyPlanId"]) ? " selected" : "";
                                                        echo ((isnull($policyPlan["ActiveFrom"],$now) > $now) || isnull($policyPlan["ActiveTo"],$now) < $now || $policyPlan["DeletedDate"] != NULL) ? " disabled='disabled'" : "";
                                                        echo ">{$policyPlan["PlanName"]} (";
                                                        echo formatCurrency("R",$policyPlan["DefaultPremium"],"");
                                                        echo ")</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3 col-sm-12">
                                            <label for="policyPremium">Policy Premium</label>
                                            <div class="input-group">
                                                <span class="input-group-addon">R</span>
                                                <input <?php echo ($mode=="view") ? "disabled" : "" ?> type="text" class="form-control" id="policyPremium" name="policyPremium" value="<?php echo $policyPremium ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6 col-sm-12">
                                            <label for="policyStartDate">Start Date</label>
                                            <input <?php echo ($mode=="view") ? "disabled" : "" ?> type="text" class="form-control mogen-date" id="policyStartDate" name="policyStartDate" value="<?php echo $policyStartDate ?>">
                                        </div>
                                        <div class="form-group col-md-6 col-sm-12">
                                            <label for="policyEndDate">End Date</label>
                                            <input <?php echo ($mode=="view") ? "disabled" : "" ?> type="text" class="form-control mogen-date" id="policyEndDate" name="policyEndDate" value="<?php echo $policyEndDate ?>">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6 col-sm-12">
                                            <label for="agentName">Agent Name</label>
                                            <input <?php echo ($mode!="add") ? "disabled" : "" ?> type="text" class="form-control" id="agentName" name="agentName" value="<?php echo $agentName ?>">
                                        </div>
                                        <div class="form-group col-md-6 col-sm-12">
                                            <label for="agentCode">Agent Code</label>
                                            <input <?php echo ($mode!="add") ? "disabled" : "" ?> type="text" class="form-control" id="agentCode" name="agentCode" value="<?php echo $agentCode ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="policyholder">
                            <div class="box box-warning">
                                <!-- form start -->
                                <input type="hidden" name="mainPersonId" value="<?php echo $mainPersonId ?>">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="form-group col-md-4 col-sm-12">
                                            <label for="mainFirstName">First Name</label>
                                            <input <?php echo ($mode=="view") ? "disabled" : "" ?> type="text" class="form-control" id="mainFirstName" name="mainFirstName" value="<?php echo $mainFirstName ?>" placeholder="First Name">
                                        </div>
                                        <div class="form-group col-md-4 col-sm-12">
                                            <label for="mainMiddleNames">Middle Names</label>
                                            <input <?php echo ($mode=="view") ? "disabled" : "" ?> type="text" class="form-control" id="mainMiddleNames" name="mainMiddleNames" value="<?php echo $mainMiddleNames ?>" placeholder="Middle Names">
                                        </div>
                                        <div class="form-group col-md-4 col-sm-12">
                                            <label for="mainLastName">Last Name</label>
                                            <input <?php echo ($mode=="view") ? "disabled" : "" ?> type="text" class="form-control" id="mainLastName" name="mainLastName" value="<?php echo $mainLastName ?>" placeholder="Last Name">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4 col-sm-12">
                                            <label for="mainTitle">Title</label>
                                            <select id="mainTitle" name="mainTitle" class="form-control" <?php echo ($mode=="view") ? "disabled" : "" ?>>
                                                <option value=""> -- Title --</option>
                                                <?php
                                                    foreach ($titles as $title) {
                                                        echo "<option value=\"{$title["Id"]}\"";
                                                        echo ($mainTitle==$title["Id"]) ? " selected" : "";
                                                        echo ">{$title["Name"]}</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4 col-sm-12">
                                            <label for="mainIDNumber">ID Number</label>
                                            <input <?php echo ($mode=="view") ? "disabled" : "" ?> type="text" class="form-control" id="mainIDNumber" name="mainIDNumber" value="<?php echo $mainIDNumber ?>" placeholder="ID Number">
                                        </div>
                                        <div class="form-group col-md-4 col-sm-12">
                                            <label for="mainBirthDate">Date of Birth</label>
                                            <input <?php echo ($mode=="view") ? "disabled" : "" ?> type="text" class="form-control general-date" id="mainBirthDate" name="mainBirthDate" value="<?php echo $mainBirthDate ?>" placeholder="Date of Birth">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4 col-sm-12">
                                            <label for="mainHomePhone">Home Phone</label>
                                            <input <?php echo ($mode=="view") ? "disabled" : "" ?> type="text" class="form-control" id="mainHomePhone" name="mainHomePhone" value="<?php echo $mainHomePhone ?>" placeholder="Home Phone">
                                        </div>
                                        <div class="form-group col-md-4 col-sm-12">
                                            <label for="mainWorkPhone">Work Phone</label>
                                            <input <?php echo ($mode=="view") ? "disabled" : "" ?> type="text" class="form-control" id="mainWorkPhone" name="mainWorkPhone" value="<?php echo $mainWorkPhone ?>" placeholder="Work Phone">
                                        </div>
                                        <div class="form-group col-md-4 col-sm-12">
                                            <label for="mainMobilePhone">Mobile Phone</label>
                                            <input <?php echo ($mode=="view") ? "disabled" : "" ?> type="text" class="form-control" id="mainMobilePhone" name="mainMobilePhone" value="<?php echo $mainMobilePhone ?>" placeholder="Mobile Phone">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6 col-sm-12">
                                            <label for="mainHomeEmail">Home Email Address</label>
                                            <input <?php echo ($mode=="view") ? "disabled" : "" ?> type="text" class="form-control" id="mainHomeEmail" name="mainHomeEmail" value="<?php echo $mainHomeEmail ?>" placeholder="Home Email Address">
                                        </div>
                                        <div class="form-group col-md-6 col-sm-12">
                                            <label for="mainWorkEmail">Work Email Address</label>
                                            <input <?php echo ($mode=="view") ? "disabled" : "" ?> type="text" class="form-control" id="mainWorkEmail" name="mainWorkEmail" value="<?php echo $mainWorkEmail ?>" placeholder="Work Email Address">
                                        </div>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                            <!-- END -->
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="spouse">
                            <div class="box box-warning">
                                <!-- form start -->
                                <div class="box-body">
                                    <input type="hidden" name="spousePersonId" value="<?php echo $spousePersonId ?>">
                                    <div class="row">
                                        <div class="form-group col-md-4 col-sm-12">
                                            <label for="spouseFirstName">First Name</label>
                                            <input <?php echo ($mode=="view") ? "disabled" : "" ?> type="text" class="form-control" id="spouseFirstName" name="spouseFirstName" value="<?php echo $spouseFirstName ?>" placeholder="First Name">
                                        </div>
                                        <div class="form-group col-md-4 col-sm-12">
                                            <label for="spouseMiddleNames">Middle Names</label>
                                            <input <?php echo ($mode=="view") ? "disabled" : "" ?> type="text" class="form-control" id="spouseMiddleNames" name="spouseMiddleNames" value="<?php echo $spouseMiddleNames ?>" placeholder="Middle Names">
                                        </div>
                                        <div class="form-group col-md-4 col-sm-12">
                                            <label for="spouseLastName">Last Name</label>
                                            <input <?php echo ($mode=="view") ? "disabled" : "" ?> type="text" class="form-control" id="spouseLastName" name="spouseLastName" value="<?php echo $spouseLastName ?>" placeholder="Last Name">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4 col-sm-12">
                                            <label for="spouseTitle">Title</label>
                                            <select id="spouseTitle" name="spouseTitle" class="form-control" <?php echo ($mode=="view") ? "disabled" : "" ?>>
                                                <option value=""> -- Title --</option>
                                                <?php
                                                    foreach ($titles as $title) {
                                                        echo "<option value=\"{$title["Id"]}\"";
                                                        echo ($spouseTitle==$title["Id"]) ? " selected" : "";
                                                        echo ">{$title["Name"]}</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4 col-sm-12">
                                            <label for="spouseIDNumber">ID Number</label>
                                            <input <?php echo ($mode=="view") ? "disabled" : "" ?> type="text" class="form-control" id="spouseIDNumber" name="spouseIDNumber" value="<?php echo $spouseIDNumber ?>" placeholder="ID Number">
                                        </div>
                                        <div class="form-group col-md-4 col-sm-12">
                                            <label for="spouseBirthDate">Date of Birth</label>
                                            <input <?php echo ($mode=="view") ? "disabled" : "" ?> type="text" class="form-control general-date" id="spouseBirthDate" name="spouseBirthDate" value="<?php echo $spouseBirthDate ?>" placeholder="Date of Birth">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4 col-sm-12">
                                            <label for="spouseHomePhone">Home Phone</label>
                                            <input <?php echo ($mode=="view") ? "disabled" : "" ?> type="text" class="form-control" id="spouseHomePhone" name="spouseHomePhone" value="<?php echo $spouseHomePhone ?>" placeholder="Home Phone">
                                        </div>
                                        <div class="form-group col-md-4 col-sm-12">
                                            <label for="spouseWorkPhone">Work Phone</label>
                                            <input <?php echo ($mode=="view") ? "disabled" : "" ?> type="text" class="form-control" id="spouseWorkPhone" name="spouseWorkPhone" value="<?php echo $spouseWorkPhone ?>" placeholder="Work Phone">
                                        </div>
                                        <div class="form-group col-md-4 col-sm-12">
                                            <label for="spouseMobilePhone">Mobile Phone</label>
                                            <input <?php echo ($mode=="view") ? "disabled" : "" ?> type="text" class="form-control" id="spouseMobilePhone" name="spouseMobilePhone" value="<?php echo $spouseMobilePhone ?>" placeholder="Mobile Phone">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6 col-sm-12">
                                            <label for="spouseHomeEmail">Home Email Address</label>
                                            <input <?php echo ($mode=="view") ? "disabled" : "" ?> type="text" class="form-control" id="spouseHomeEmail" name="spouseHomeEmail" value="<?php echo $spouseHomeEmail ?>" placeholder="Home Email Address">
                                        </div>
                                        <div class="form-group col-md-6 col-sm-12">
                                            <label for="spouseWorkEmail">Work Email Address</label>
                                            <input <?php echo ($mode=="view") ? "disabled" : "" ?> type="text" class="form-control" id="spouseWorkEmail" name="spouseWorkEmail" value="<?php echo $spouseWorkEmail ?>" placeholder="Work Email Address">
                                        </div>
                                    </div>

                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->


                            <!-- END -->
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="addmem">
                            <div class="box box-warning">
                                <div class="box-header">
                                    <button type="button" id="addAdditional" class="btn btn-primary pull-right <?php echo ($mode=="view") ? "" : "hidden" ?>">Add New</button>
                                </div>
                                <div class="box-body">
                                    <table id="tblAdditionalMembers" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Title</th>
                                                <th>Date of Birth</th>
                                                <th>Inception Date</th>
                                                <th>Relationship</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                if ($mode != "add") {
                                                    $members = $per->GetAdditional($polid);

                                                    foreach($members as $addmems) {
                                                        echo "<tr data-pid='{$addmems["PersonId"]}' data-midnames='{$addmems["MiddleNames"]}' data-idnum='{$addmems["IDNumber"]}' data-typeid='{$addmems["PersonTypeId"]}' data-relid='{$addmems["RelationshipId"]}'>
                                                                <td class=\"pfname\">{$addmems["FirstName"]}</td>
                                                                <td class=\"plname\">{$addmems["LastName"]}</td>
                                                                <td class=\"ptitle\">{$addmems["Title"]}</td>
                                                                <td class=\"pdob\">{$addmems["DateOfBirth"]}</td>
                                                                <td class=\"pdadded\">{$addmems["DateAdded"]}</td>
                                                                <td>{$addmems["PersonType"]}</td>
                                                                <td class=\"pactions\">
                                                                <input type=\"hidden\" class=\"phphone\" value=\"{$addmems["HomePhone"]}\">
                                                                <input type=\"hidden\" class=\"pwphone\" value=\"{$addmems["WorkPhone"]}\">
                                                                <input type=\"hidden\" class=\"pmphone\" value=\"{$addmems["MobilePhone"]}\">
                                                                <input type=\"hidden\" class=\"phemail\" value=\"{$addmems["HomeEmail"]}\">
                                                                <input type=\"hidden\" class=\"pwemail\" value=\"{$addmems["WorkEmail"]}\">
                                                                [ <a href='#' class='editAdditional'>Details</a> ]
                                                                </td>
                                                             </tr>";
                                                    }
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="invoices">
                            <div class="box box-warning">
                                <div class="box-header">
                                    <button type="button" id="addInvoice" class="btn btn-primary pull-right <?php echo ($mode=="view") ? "" : "hidden" ?>">Create Invoice</button>
                                </div>
                                <div class="box-body">
                                    <table id="tblInvoices" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
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
                                                if ($mode != "add") {
                                                    $invoices = $inv->GetByPolicyId($polid);

                                                    foreach($invoices as $invoice) {
                                                        echo "<tr>
                                                                <td class=\"invnum\">{$invoice["InvoiceNumber"]}</td>
                                                                <td class=\"invdate\">{$invoice["InvoiceDate"]}</td>
                                                                <td>R <span class=\"invamt\">{$invoice["TotalAmount"]}</span></td>
                                                                <td class=\"raisedby\">{$invoice["FirstName"]} {$invoice["LastName"]}</td>
                                                                <td class=\"raiseddate\">{$invoice["RaisedDate"]}</td>
                                                                <td>
                                                                    <input type='hidden' class='invid' value='{$invoice["InvoiceId"]}'>
                                                                    <input type='hidden' class='raisedid' value='{$invoice["UserId"]}'>
                                                                [ <a href='#' class='editInvoice'>Details</a> ]
                                                                </td>
                                                        </tr>";
                                                    }
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="payments">
                            <div class="box box-warning">
                                <div class="box-header">
                                    <button id="addPayment" type="button" class="btn btn-primary pull-right <?php echo ($mode=="view") ? "" : "hidden" ?>">Record Payment</button>
                                </div>
                                <div class="box-body">
                                    <table id="tblPayments" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Receipt Number</th>
                                                <th>Payment Date</th>
                                                <th>Payment Amount</th>
                                                <th>Captured By</th>
                                                <th>Captured Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                if ($mode != "add") {
                                                    $payments = $pay->GetByPolicyId($polid);

                                                    foreach($payments as $pymt) {
                                                        echo "<tr>
                                                                <td class='receipt'>{$pymt["ReceiptNo"]}</td>
                                                                <td class=\"paydate\">{$pymt["PaymentForDate"]}</td>
                                                                <td>R <span class=\"payamt\">{$pymt["Amount"]}</span></td>
                                                                <td class=\"pcname\">{$pymt["FirstName"]} {$pymt["LastName"]}</td>
                                                                <td class=\"pcdate\">{$pymt["CapturedDate"]}</td>
                                                                <td>
                                                                    <input type='hidden' class='pid' value='{$pymt["PaymentId"]}'>
                                                                    <input type='hidden' class='pcid' value='{$pymt["UserId"]}'>
                                                                [ <a href='#' class='editPayment'>Details</a> ]
                                                                </td>
                                                        </tr>";
                                                    }
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- nav-tabs-custom -->
            </div>
            <!-- /.col -->
        </div>
        <div class="row">
            <div class="col-sm-2">
                <div class="btn-group">
                    <?php if ($mode != "view") { 
                        if (isset($polid)) {
                        ?>
                        <a class="btn btn-danger" href="<?php echo "details.php?polid={$polid}&mode=view"?>">Cancel</a>
                        <?php } else {
                        ?>
                        <a class="btn btn-danger" href="<?php echo "./"?>">Cancel</a>
                        <?php
                        }
                        ?>
                        <button class="btn btn-success" type="submit" id="btnSave">Save</button>
                    <?php }
                        else {
                    ?>
                        <a class="btn btn-default" href="index.php">Back</a>
                        <a class="btn btn-primary" href="<?php echo "details.php?polid={$polid}&mode=edit"?>">Edit</a>
                    <?php } ?>
                </div>
            </div>
            <div class="col-sm-8">
                <?php
                if (isset($_SESSION["Saved"])) {
                    echo ($_SESSION["Saved"]);
                    unset($_SESSION["Saved"]);
                }
                ?>
            </div>
        </div>
    </form>
</div>
<div class="modal fade" id="modal-additional">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="save-additional.php">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Additional Members</h4>
                </div>
                <div class="modal-body">
                    <div class="box box-warning">
                        <!-- form start -->
                        <div class="box-body">
                            <input type="hidden" id="policyId" name="policyId" value="<?php echo $polid ?>">
                            <input type="hidden" id="additionalPersonId" name="additionalPersonId" value="0">
                            <div class="row">
                                <div class="form-group col-md-4 col-sm-12">
                                    <label for="additionalFirstName">First Name</label>
                                    <input type="text" class="form-control" id="additionalFirstName" name="additionalFirstName" placeholder="First Name">
                                </div>
                                <div class="form-group col-md-4 col-sm-12">
                                    <label for="additionalMiddleNames">Middle Names</label>
                                    <input type="text" class="form-control" id="additionalMiddleNames" name="additionalMiddleNames" placeholder="Middle Names">
                                </div>
                                <div class="form-group col-md-4 col-sm-12">
                                    <label for="additionalLastName">Last Name</label>
                                    <input type="text" class="form-control" id="additionalLastName" name="additionalLastName" placeholder="Last Name">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4 col-sm-12">
                                    <label for="additionalTitle">Title</label>
                                    <select id="additionalTitle" name="additionalTitle" class="form-control">
                                        <option value=""> -- Title --</option>
                                        <?php
                                            foreach($titles as $title) {
                                                echo "<option value=\"{$title["Id"]}\">{$title["Name"]}</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4 col-sm-12">
                                    <label for="additionalIDNumber">ID Number</label>
                                    <input type="text" class="form-control" id="additionalIDNumber" name="additionalIDNumber" placeholder="ID Number">
                                </div>
                                <div class="form-group col-md-4 col-sm-12">
                                    <label for="additionalBirthDate">Date of Birth</label>
                                    <input type="text" class="form-control general-date" id="additionalBirthDate" name="additionalBirthDate" placeholder="Date of Birth">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4 col-sm-12">
                                    <label for="additionalHomePhone">Home Phone</label>
                                    <input type="text" class="form-control" id="additionalHomePhone" name="additionalHomePhone" placeholder="Home Phone">
                                </div>
                                <div class="form-group col-md-4 col-sm-12">
                                    <label for="additionalWorkPhone">Work Phone</label>
                                    <input type="text" class="form-control" id="additionalWorkPhone" name="additionalWorkPhone" placeholder="Work Phone">
                                </div>
                                <div class="form-group col-md-4 col-sm-12">
                                    <label for="additionalMobilePhone">Mobile Phone</label>
                                    <input type="text" class="form-control" id="additionalMobilePhone" name="additionalMobilePhone" placeholder="Mobile Phone">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 col-sm-12">
                                    <label for="additionalHomeEmail">Home Email Address</label>
                                    <input type="text" class="form-control" id="additionalHomeEmail" name="additionalHomeEmail" placeholder="Home Email Address">
                                </div>
                                <div class="form-group col-md-6 col-sm-12">
                                    <label for="additionalWorkEmail">Work Email Address</label>
                                    <input type="text" class="form-control" id="additionalWorkEmail" name="additionalWorkEmail" placeholder="Work Email Address">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="additionalPersonType">Person Type</label>
                                    <select id="additionalPersonType" name="additionalPersonType" class="form-control">
                                        <option value=""> -- Person Type --</option>
                                        <?php
                                            foreach($persontypes as $persontype) {
                                                echo "<option "
                                                    . ( (isnull($persontype["DeletedDate"],'') != '' || $persontype["Id"] == 1 || $persontype["Id"] == 2) ? "disabled " : "" )
                                                    ."value='{$persontype["Id"]}'>{$persontype["Name"]}</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="additionalRelationship">Relationship</label>
                                    <select id="additionalRelationship" name="additionalRelationship" class="form-control">
                                        <option value=""> -- Relationship --</option>
                                        <?php
                                            foreach($relationships as $relationship) {
                                                echo "<option value=\"{$relationship["Id"]}\">{$relationship["Name"]}</option>";
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
                    <button id="btnSaveAdditional" type="submit" class="btn btn-primary <?php echo ($mode=="view") ? "" : "hidden" ?>">Add Member</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<div class="modal fade" id="modal-invoice">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="save-invoice.php">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Invoice</h4>
                </div>
                <div class="modal-body">
                    <div class="box box-warning">
                        <!-- form start -->
                        <div class="box-body">
                        <input type="hidden" id="policyId" name="policyId" value="<?php echo $polid ?>">
                        <input type="hidden" id="userId" name="userId" value="<?php echo $userId ?>">
                        <input type="hidden" id="invoiceId" name="invoiceId" value="0">
                            <div class="row">
                                <div class="form-group col-md-4 col-sm-12">
                                    <label for="invoiceNumber">Invoice Number</label>
                                    <input <?php echo ($mode!="view") ? "disabled" : "" ?> type="text" class="form-control" id="invoiceNumber" name="invoiceNumber" placeholder="Invoice Number">
                                </div>
                                <div class="form-group col-md-4 col-sm-12">
                                    <label for="invoiceAmount">Total Amount</label>
                                    <a href="#" id="invGetPremium" class="pull-right"><em>premium</em></a>
                                    <div class="input-group">
                                        <span class="input-group-addon">R</span>
                                        <input <?php echo ($mode!="view") ? "disabled" : "" ?> type="text" class="form-control" id="invoiceAmount" name="invoiceAmount" placeholder="Total Amount">
                                    </div>
                                </div>
                                <div class="form-group col-md-4 col-sm-12">
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
                    <button id="btnSaveInvoice" type="submit" class="btn btn-primary<?php echo ($mode=="view") ? "" : " hidden" ?>">Create Invoice</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<div class="modal fade" id="modal-payment">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="save-payment.php">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Record Payment</h4>
                </div>
                <div class="modal-body">
                    <div class="box box-warning">
                        <!-- form start -->
                        <div class="box-body">
                        <input type="hidden" id="policyId" name="policyId" value="<?php echo $polid ?>">
                        <input type="hidden" id="userId" name="userId" value="<?php echo $userId ?>">
                        <input type="hidden" id="paymentId" name="paymentId" value="0">
                            <div class="row">
                                <div class="form-group col-md-6 col-sm-12">
                                    <label for="paymentAmount">Payment Amount</label>
                                    <a href="#" id="payGetPremium" class="pull-right"><em>premium</em></a>
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
                    <button id="btnSavePayment" type="submit" class="btn btn-primary<?php echo ($mode=="view") ? "" : " hidden" ?>">Record Payment</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<?php 
require_once "../inc/footer.inc.php";

?>
<script type="text/javascript">
    $(function () {
        $('#tblAdditionalMembers').DataTable({
            'order': [[1, 'desc'], [0, 'asc']]
        });
        $('#tblAdditionalMembers_paginate').addClass("pull-right");
        $('#tblAdditionalMembers_filter').addClass("pull-right");

        $('#tblInvoices').DataTable({
            'order': [[1, 'asc']]
        })
        $('#tblInvoices_paginate').addClass("pull-right");
        $('#tblInvoices_filter').addClass("pull-right");
        
        $('#tblPayments').DataTable({
            'order': [[1, 'desc']]
        })
        $('#tblPayments_paginate').addClass("pull-right");
        $('#tblPayments_filter').addClass("pull-right");

        $('.general-date').datepicker({ 
            autoclose: true,
            format: 'yyyy-mm-dd',
            orientation: "bottom left",
            todayHighlight: true
        });

        $('.mogen-date').datepicker({ 
            autoclose: true,
            format: 'yyyy-mm-dd',
            orientation: "bottom left",
            startDate: new Date()
        });

        $('#policyPlan').on('change',function() {
            $('#policyPremium').val($('#policyPlan option:selected').data('premium'));
        });

        $('#addAdditional').on('click', function() {
            $('#additionalPersonId').val('');
            $('#additionalFirstName').val('');
            $('#additionalMiddleNames').val('');
            $('#additionalLastName').val('');
            $('#additionalBirthDate').val('');
            $('#additionalAddedDate').val('');
            $('#additionalIDNumber').val('');
            $('#additionalHomePhone').val('');
            $('#additionalWorkPhone').val('');
            $('#additionalMobilePhone').val('');
            $('#additionalHomeEmail').val('');
            $('#additionalWorkEmail').val('');
            $("#additionalTitle").val('');
            $("#additionalPersonType").val('');
            $("#additionalRelationship").val('');
            
            $('#btnSaveAdditional').text("Add Member");
            $('#modal-additional').modal('show');
        });
        $('.editAdditional').on('click', function() {
            var tr = $(this).closest('tr');
            var pid = tr.data('pid'),
                pfname = tr.find('.pfname').text(),
                pmname = tr.data('midnames'),
                plname = tr.find('.plname').text(),
                ptitle = tr.find('.ptitle').text(),
                pdob   = tr.find('.pdob').text(),
                pdadded = tr.find('.pdadded').text(),
                typeid  = tr.data('typeid'),
                relid   = tr.data('relid'),
                pidnum  = tr.data('idnum'),
                phphone = tr.find('.phphone').val(),
                pwphone = tr.find('.pwphone').val(),
                pmphone = tr.find('.pmphone').val(),
                phemail = tr.find('.phemail').val(),
                pwemail = tr.find('.pwemail').val();

            $('#additionalPersonId').val(pid);
            $('#additionalFirstName').val(pfname);
            $('#additionalMiddleNames').val(pmname);
            $('#additionalLastName').val(plname);
            $('#additionalBirthDate').val(pdob);
            $('#additionalAddedDate').val(pdadded);
            $('#additionalIDNumber').val(pidnum);
            $('#additionalHomePhone').val(phphone);
            $('#additionalWorkPhone').val(pwphone);
            $('#additionalMobilePhone').val(pmphone);
            $('#additionalHomeEmail').val(phemail);
            $('#additionalWorkEmail').val(pwemail);
            $("#additionalTitle").find("option:contains("+ptitle+")").each(function() {
                var $this = $(this);
                if ($this.text() == ptitle) {
                    $("#additionalTitle").val($this.val());
                }
            });
            $("#additionalPersonType").val(typeid);
            $("#additionalRelationship").val(relid);
            console.log('RelID='+relid);
            
            $('#btnSaveAdditional').text("Edit Member");
            $('#modal-additional').modal('show');
        });

        function getPremium() {
            return $('#policyPremium').val();
        }

        $('#invGetPremium').on('click', function() {
            var premium = $('#policyPremium').val();
            $('#invoiceAmount').val(premium);
        });

        $('#payGetPremium').on('click', function() {
            $('#paymentAmount').val(getPremium());
        });

        $('#addInvoice').on('click', function() {
            $('#invoiceId').val('0');
            $('#modal-invoice #userId').val('<?php echo $userId ?>');
            $('#invoiceNumber').val('');
            $('#invoiceDate').val('');
            $('#invoiceAmount').val('');
            $('#invoiceRaisedBy').val('<?php echo $userFullName ?>');
            
            $('#btnSaveInvoice').text("Create Invoice");
            $('#modal-invoice').modal('show');
        });

        $('.editInvoice').on('click', function() {
            var tr = $(this).closest('tr');
            var invid = tr.find('.invid').val(),
                invnum = tr.find('.invnum').text(),
                invdate = tr.find('.invdate').text(),
                invamt = tr.find('.invamt').text(),
                raisedid = tr.find('.raisedid').val(),
                raisedby = tr.find('.raisedby').text(),
                raiseddate = tr.find('.raiseddate').text();

            $('#invoiceId').val(invid);
            $('#modal-invoice #userId').val(raisedid);
            $('#invoiceNumber').val(invnum);
            $('#invoiceDate').val(invdate);
            $('#invoiceAmount').val(invamt);
            $('#invoiceRaisedBy').val(raisedby);
            $('#invoiceRaisedDate').val(raiseddate);
            
            $('#btnSaveInvoice').text("Update Invoice");
            $('#modal-invoice').find('h4').text("Edit Invoice");
            $('#modal-invoice').modal('show');
        });

        $('#addPayment').on('click', function() {
            $('#paymentId').val('0');
            $('#modal-payment #userId').val('<?php echo $userId ?>');
            $('#paymentAmount').val('');
            $('#paymentDate').val('');
            $('#paymentCapturedDate').val('');
            $('#paymentCapturedBy').val('<?php echo $userFullName ?>');
            
            $('#btnSavePayment').text("Record Payment");
            $('#modal-payment').modal('show');
        });

        $('.editPayment').on('click', function() {
            var tr = $(this).closest('tr');
            var pid = tr.find('.pid').val(),
                paydate = tr.find('.paydate').text(),
                payamt = tr.find('.payamt').text(),
                pcid = tr.find('.pcid').val(),
                pcname = tr.find('.pcname').text(),
                pcdate = tr.find('.pcdate').text();

            $('#modal-payment #userId').val(pcid);
            $('#paymentId').val(pid);
            $('#paymentDate').val(paydate);
            $('#paymentAmount').val(payamt);
            $('#paymentCapturedBy').val(pcname);
            $('#paymentCapturedDate').val(pcdate);
            
            $('#btnSavePayment').text("Update Payment");
            $('#modal-payment').find('h4').text("Edit Payment");
            $('#modal-payment').modal('show');
        });
    });
</script>