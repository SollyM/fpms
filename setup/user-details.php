<?php 
$pageName = "Users";
require_once "../inc/header.inc.php";
require_once '../classes/classes.php';
include_once '../inc/config.inc.php';

try {
    $db = new DbConn;

    $mode = isset($_REQUEST["mode"]) ? $_REQUEST["mode"] : "view";

    // $stmt_roles = $db->conn->prepare("SELECT * FROM refroles WHERE IsActive = b'1'");
    // $stmt_roles->execute();
    // $roles = $stmt_roles->fetchAll(PDO::FETCH_ASSOC);
    $r = new Role;
    $roles = $r->GetAll();

    switch ($mode) {
        case 'add':
            $pageName = "New User";
            $userId = "";
            $userName = "";
            $firstName = "";
            $lastName = "";
            $jobTitle = "";
            $emailAddress = "";
            $userRole = "";
            $engagedDate = "";
            $verified = 0;
            break;
        
        default:
            $mode = "edit";
            $userId = $_REQUEST["uid"];
            $qry = "SELECT U.*, R.RoleName FROM tblusers U LEFT JOIN refroles R ON R.RoleId = U.RoleId WHERE U.id = :userId";
            $stmt = $db->conn->prepare($qry);
            $stmt->bindParam(":userId", $userId);
            $stmt->execute();
            $user = $stmt->fetch();
            $pageName = $user["FirstName"] .' '. $user["LastName"];

            $userId = $user["id"];
            $userName = $user["username"];
            $firstName = $user["FirstName"];
            $lastName = $user["LastName"];
            $jobTitle = $user["JobTitle"];
            $emailAddress = $user["email"];
            $userRole = $user["RoleId"];
            $engagedDate = $user["DateEngaged"];
            $verified = $user["verified"];
            break;
    }
?>
<form action="user-save.php" method="post" role="form">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-warning">
                <div class="box-header">
                    <h3 class="box-title"><?php echo $pageName ?></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="form-group col-md-3 col-sm-6 col-xs-12">
                            <label for="userId">User ID</label>
                            <input disabled type="text" value="<?php echo $userId ?>" class="form-control" placeholder="Auto Generate">
                            <input type="hidden" id="userId" name="userId" value="<?php echo $userId ?>">
                        </div>
                        <div class="form-group col-md-3 col-sm-6 col-xs-12">
                            <label for="userName">User Name</label>
                            <input<?php echo ($mode =="view" ? " disabled" : "") ?> id="username" name="username" class="form-control" value="<?php echo $userName ?>" type="text" placeholder="User Name">
                        </div>
                        <div class="form-group col-md-3 col-sm-6 col-xs-12">
                            <label for="firstName">First Name</label>
                            <input<?php echo ($mode =="view" ? " disabled" : "") ?> id="firstName" name="firstName" value="<?php echo $firstName ?>" class="form-control" type="text" placeholder="First Name">
                        </div>
                        <div class="form-group col-md-3 col-sm-6 col-xs-12">
                            <label for="lastName">Last Name</label>
                            <input<?php echo ($mode =="view" ? " disabled" : "") ?> id="lastName" name="lastName" value="<?php echo $lastName ?>" class="form-control" type="text" placeholder="Last Name">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6 col-xs-12">
                            <label for="jobTitle">Job Title</label>
                            <input<?php echo ($mode =="view" ? " disabled" : "") ?> id="jobTitle" name="jobTitle" value="<?php echo $jobTitle ?>" class="form-control" type="text" placeholder="Job Title">
                        </div>
                        <div class="form-group col-sm-6 col-xs-12">
                            <label for="emailAddress">Email Address</label>
                            <input<?php echo ($mode =="view" ? " disabled" : "") ?> id="emailAddress" name="emailAddress" value="<?php echo $emailAddress ?>" class="form-control" type="text" placeholder="Email Address">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6 col-xs-12">
                            <label for="role">Role</label>
                            <select id="roleId" name="roleId" class="form-control" <?php echo ($mode=="view" ) ? "disabled" : "" ?>>
                                <option value="">-- User Role --</option>
                                <?php
                                    $now = date("Y-m-d H:m");
                                    foreach ($roles as $item) {
                                        echo "<option value='{$item["RoleId"]}'";
                                        echo ($userRole==$item["RoleId"]) ? " selected" : "";
                                        echo ((isnull($item["ActiveFrom"],$now) > $now) || isnull($item["ActiveTo"],$now) < $now || $item["DeletedDate"] != NULL) ? " disabled='disabled'" : "";
                                        echo ">{$item["RoleName"]}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-sm-3 col-xs-12">
                            <label for="engagedDate">Date Engaged</label>
                            <input<?php echo ($mode =="view" ? " disabled" : "") ?> id="engagedDate" name="engagedDate" value="<?php echo $engagedDate ?>" class="form-control general-date" type="text" placeholder="Engaged Date">
                        </div>
                        <div class="form-group col-sm-3 col-xs-12">
                            <label for="verified">Verified?</label>
                            <select class="form-control" <?php echo ($mode =="view" ? " disabled" : "") ?> id="verified" name="verified">
                                <option value="0"<?php echo ($verified != 1 ? "selected" : "") ?>>No</option>
                                <option value="1"<?php echo ($verified == 1 ? "selected" : "") ?>>Yes</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
            <div class="box box-danger box-solid collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">Password Management</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="form-group col-xs-12">
                            <p>Complete the Password below <strong><em>ONLY</em></strong> if you want to save new password.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6 col-xs-12">
                            <label for="userPassword1">Password</label>
                            <!-- <div class="input-group"> -->
                                <input<?php echo ($mode =="view" ? " disabled" : "") ?> id="userPassword1" name="userPassword1" class="form-control has-warning" type="password" placeholder="Password">
                                <!-- <span class="input-group-addon"><a href="#" class="fa fa-eye showhide-password"></a></span> 
                            </div>-->
                        </div>
                        <div class="form-group col-sm-6 col-xs-12">
                            <label for="userPassword2">Repeat Password</label>
                            <input<?php echo ($mode =="view" ? " disabled" : "") ?> id="userPassword2" name="userPassword2" class="form-control has-warning" type="password" placeholder="Repeat Password">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col -->
        <div class="form-group col-xs-12">
            <div class="btn-group">
                <a href="users.php" class="btn btn-danger">Cancel</a>
                <button type="submit" class="btn btn-success">Save</button>
            </div>
        </div>
    </div>
</form>

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
        $('.general-date').datepicker({ 
            autoclose: true,
            format: 'yyyy-mm-dd',
            orientation: "bottom left",
            todayHighlight: true
        });
    });
</script>