<?php 
include_once "sessions.php";

$bodyClassAdditional = " skin-black sidebar-mini";
include_once "header-inner.inc.php";
?>
  <div class="wrapper">
  
    <header class="main-header">
  
      <!-- Logo -->
      <a href="<?php echo $baseUrl ?>" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><?php echo $sysLogoShort ?></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><?php echo $sysLogoLong ?></span>
      </a>
  
      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- Messages: style can be found in dropdown.less-->
            <?php
			// <li class="dropdown messages-menu">
            //   <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            //     <i class="fa fa-envelope-o"></i>
            //     <span class="label label-success">4</span>
            //   </a>
            //   <ul class="dropdown-menu">
            //     <li class="header">You have 4 messages</li>
            //     <li>
            //       <!-- inner menu: contains the actual data -->
            //       <ul class="menu">
            //         <li><!-- start message -->
            //           <a href="#">
            //             <div class="pull-left">
            //               <img src="< ?php echo "{$baseUrl}/images/user2-160x160.jpg"; ? >" class="img-circle" alt="User Image">
            //             </div>
            //             <h4>
            //               Support Team
            //               <small><i class="fa fa-clock-o"></i> 5 mins</small>
            //             </h4>
            //             <p>Why not buy a new awesome theme?</p>
            //           </a>
            //         </li>
            //         <!-- end message -->
            //         <li>
            //           <a href="#">
            //             <div class="pull-left">
            //               <img src="< ?php echo "{$baseUrl}/images/user3-128x128.jpg"; ? >" class="img-circle" alt="User Image">
            //             </div>
            //             <h4>
            //               AdminLTE Design Team
            //               <small><i class="fa fa-clock-o"></i> 2 hours</small>
            //             </h4>
            //             <p>Why not buy a new awesome theme?</p>
            //           </a>
            //         </li>
            //         <li>
            //           <a href="#">
            //             <div class="pull-left">
            //               <img src="< ?php echo "{$baseUrl}/images/user4-128x128.jpg"; ? >" class="img-circle" alt="User Image">
            //             </div>
            //             <h4>
            //               Developers
            //               <small><i class="fa fa-clock-o"></i> Today</small>
            //             </h4>
            //             <p>Why not buy a new awesome theme?</p>
            //           </a>
            //         </li>
            //         <li>
            //           <a href="#">
            //             <div class="pull-left">
            //               <img src="< ?php echo "{$baseUrl}/images/user3-128x128.jpg"; ? >" class="img-circle" alt="User Image">
            //             </div>
            //             <h4>
            //               Sales Department
            //               <small><i class="fa fa-clock-o"></i> Yesterday</small>
            //             </h4>
            //             <p>Why not buy a new awesome theme?</p>
            //           </a>
            //         </li>
            //         <li>
            //           <a href="#">
            //             <div class="pull-left">
            //               <img src="< ?php echo "{$baseUrl}/images/user4-128x128.jpg"; ? >" class="img-circle" alt="User Image">
            //             </div>
            //             <h4>
            //               Reviewers
            //               <small><i class="fa fa-clock-o"></i> 2 days</small>
            //             </h4>
            //             <p>Why not buy a new awesome theme?</p>
            //           </a>
            //         </li>
            //       </ul>
            //     </li>
            //     <li class="footer"><a href="#">See All Messages</a></li>
            //   </ul>
			// </li>
			?>
            <!-- Notifications: style can be found in dropdown.less -->
            <?php
			// <li class="dropdown notifications-menu">
            //   <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            //     <i class="fa fa-bell-o"></i>
            //     <span class="label label-warning">10</span>
            //   </a>
            //   <ul class="dropdown-menu">
            //     <li class="header">You have 10 notifications</li>
            //     <li>
            //       <!-- inner menu: contains the actual data -->
            //       <ul class="menu">
            //         <li>
            //           <a href="#">
            //             <i class="fa fa-users text-aqua"></i> 5 new members joined today
            //           </a>
            //         </li>
            //         <li>
            //           <a href="#">
            //             <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
            //             page and may cause design problems
            //           </a>
            //         </li>
            //         <li>
            //           <a href="#">
            //             <i class="fa fa-users text-red"></i> 5 new members joined
            //           </a>
            //         </li>
            //         <li>
            //           <a href="#">
            //             <i class="fa fa-shopping-cart text-green"></i> 25 sales made
            //           </a>
            //         </li>
            //         <li>
            //           <a href="#">
            //             <i class="fa fa-user text-red"></i> You changed your username
            //           </a>
            //         </li>
            //       </ul>
            //     </li>
            //     <li class="footer"><a href="#">View all</a></li>
            //   </ul>
            // </li>
			?>
            <!-- Tasks: style can be found in dropdown.less -->
			<?php 
			// <li class="dropdown tasks-menu">
            //   <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            //     <i class="fa fa-flag-o"></i>
            //     <span class="label label-danger">9</span>
            //   </a>
            //   <ul class="dropdown-menu">
            //     <li class="header">You have 9 tasks</li>
            //     <li>
            //       <!-- inner menu: contains the actual data -->
            //       <ul class="menu">
            //         <li><!-- Task item -->
            //           <a href="#">
            //             <h3>
            //               Design some buttons
            //               <small class="pull-right">20%</small>
            //             </h3>
            //             <div class="progress xs">
            //               <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar"
            //                    aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
            //                 <span class="sr-only">20% Complete</span>
            //               </div>
            //             </div>
            //           </a>
            //         </li>
            //         <!-- end task item -->
            //         <li><!-- Task item -->
            //           <a href="#">
            //             <h3>
            //               Create a nice theme
            //               <small class="pull-right">40%</small>
            //             </h3>
            //             <div class="progress xs">
            //               <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar"
            //                    aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
            //                 <span class="sr-only">40% Complete</span>
            //               </div>
            //             </div>
            //           </a>
            //         </li>
            //         <!-- end task item -->
            //         <li><!-- Task item -->
            //           <a href="#">
            //             <h3>
            //               Some task I need to do
            //               <small class="pull-right">60%</small>
            //             </h3>
            //             <div class="progress xs">
            //               <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar"
            //                    aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
            //                 <span class="sr-only">60% Complete</span>
            //               </div>
            //             </div>
            //           </a>
            //         </li>
            //         <!-- end task item -->
            //         <li><!-- Task item -->
            //           <a href="#">
            //             <h3>
            //               Make beautiful transitions
            //               <small class="pull-right">80%</small>
            //             </h3>
            //             <div class="progress xs">
            //               <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar"
            //                    aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
            //                 <span class="sr-only">80% Complete</span>
            //               </div>
            //             </div>
            //           </a>
            //         </li>
            //         <!-- end task item -->
            //       </ul>
            //     </li>
            //     <li class="footer">
            //       <a href="#">View all tasks</a>
            //     </li>
            //   </ul>
			// </li> 
			?>
            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <!-- <img src="<?php echo "{$baseUrl}/images/user2-160x160.jpg"; ?>" class="user-image" alt="User Image"> -->
                <div class="fa fa-fw fa-stack">
                  <i class="fa fa-fw fa-stack-2x fa-circle-thin"></i>
                  <i class="fa fa-fw fa-stack fa-user-secret"></i>
                </div>
                <span class="hidden-xs"><?php echo $userFullName ?></span>
              </a>
              <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                  <!-- <img src="<?php echo "{$baseUrl}/images/user2-160x160.jpg"; ?>" class="img-circle" alt="User Image"> -->
                  <div class="fa fa-fw fa-3x fa-inverse fa-stack">
                    <i class="fa fa-fw fa-stack-2x fa-circle-thin"></i>
                    <i class="fa fa-fw fa-stack fa-user-secret"></i>
                  </div>
                  <p>
                  <?php echo $userFullName ." - ". (isset($_SESSION['JobTitle']) ? $_SESSION['JobTitle'] : "User") ?>
                    <small>Member since <?php echo (isset($_SESSION['DateEngaged']) ? $_SESSION['DateEngaged'] : "the beginning.") ?></small>
                  </p>
                </li>
                <!-- Menu Body -->
                <li class="user-body">
                  <div class="row">
                    <div class="col-xs-4 text-center">
                      <a href="#">Followers</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="#">Sales</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="#">Friends</a>
                    </div>
                  </div>
                  <!-- /.row -->
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                  <div class="pull-left">
                    <a href="<?php echo "{$baseUrl}/myprofile" ?>" class="btn btn-default btn-flat">Profile</a>
                  </div>
                  <div class="pull-right">
                    <a href="<?php echo "{$baseUrl}/auth/doLogout.php" ?>" class="btn btn-default btn-flat">Sign out</a>
                  </div>
                </li>
              </ul>
            </li>
            <!-- Control Sidebar Toggle Button -->
            <li>
              <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
            </li>
          </ul>
        </div>
  
      </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">
            <!-- <img src="<?php echo "{$baseUrl}/images/user2-160x160.jpg"; ?>" class="img-circle" alt="User Image"> -->
            <div class="fa fa-fw fa-inverse fa-2x fa-stack">
              <i class="fa fa-fw fa-stack-2x fa-circle-thin"></i>
              <i class="fa fa-fw fa-stack fa-user-secret"></i>
            </div>
          </div>
          <div class="pull-left info">
            <p><?php echo isset($_SESSION['fullName']) ? $_SESSION['fullName'] : "Full Name" ?></p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
          <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Search...">
            <span class="input-group-btn">
                  <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                    <i class="fa fa-search"></i>
                  </button>
                </span>
          </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
          <li class="header">MAIN NAVIGATION</li>
          <li>
          <a href="<?php echo "{$baseUrl}/index.php" ?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
          </li>
          <li class="treeview" id="menuPolicyHolders">
            <a href="#">
              <i class="fa fa-users"></i>
              <span>Policy Holders</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li id="menuListPolicyHolders"><a href="<?php echo "{$baseUrl}/members" ?>"><i class="fa fa-circle-o"></i> List Policy Holder</a></li>
              <li id="menuAddPolicyHolder"><a href="<?php echo "{$baseUrl}/members/details.php?mode=add" ?>"><i class="fa fa-circle-o"></i> Add New</a></li>
            </ul>
          </li>
          <li class="treeview" id="menuFinances">
            <a href="#">
              <i class="fa fa-money"></i>
              <span>Finances</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li id="menuInvoices"><a href="<?php echo "{$baseUrl}/finance/invoices.php" ?>"><i class="fa fa-circle-o"></i> Invoices</a></li>
              <li id="menuPayments"><a href="<?php echo "{$baseUrl}/finance/payments.php" ?>"><i class="fa fa-circle-o"></i> Payments</a></li>
            </ul>
          </li>
          <li class="treeview" id="menuPolicySetup">
            <a href="#">
              <i class="fa fa-edit"></i> <span>Policy Setup</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li id="menuPolicyPlans"><a href="<?php echo "{$baseUrl}/setup/plans-view.php" ?>"><i class="fa fa-circle-o"></i> Policy Plans</a></li>
              <li id="menuPolicyNumberFormat"><a href="<?php echo "{$baseUrl}/setup/policy-number-format.php" ?>"><i class="fa fa-circle-o"></i> Policy Number Format</a></li>
            </ul>
          </li>
          <li class="treeview" id="menuSettings">
            <a href="#">
              <i class="fa fa-gears"></i>
              <span>Settings</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li id="menuPersonTypes"><a href="<?php echo "{$baseUrl}/setup/dropdown-view.php?type=persontype" ?>"><i class="fa fa-circle-o"></i> Person Types</a></li>
              <li id="menuTitles"><a href="<?php echo "{$baseUrl}/setup/dropdown-view.php?type=title" ?>"><i class="fa fa-circle-o"></i> Titles</a></li>
              <li id="menuRelationships"><a href="<?php echo "{$baseUrl}/setup/dropdown-view.php?type=relationship" ?>"><i class="fa fa-circle-o"></i> Relationships</a></li>
              </ul>
          </li>
          <?php if (isset($_SESSION["RolePriority"]) && $_SESSION["RolePriority"] >= 9000) { ?>
          <li class="treeview" id="menuUsersRoles">
            <a href="#">
              <i class="fa fa-laptop"></i>
              <span>Users &amp; Roles</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li id="menuRoles"><a href="<?php echo "{$baseUrl}/setup/roles.php" ?>"><i class="fa fa-circle-o"></i> Roles</a></li>
              <li id="menuUsers"><a href="<?php echo "{$baseUrl}/setup/users.php" ?>"><i class="fa fa-circle-o"></i> Users</a></li>
            </ul>
          </li>
          <?php } ?>
        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>
  
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          <?php echo $pageName ?>
          <small>Version <?php echo $sysVersion; ?></small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
          <li class="active"><?php echo $pageName; ?></li>
        </ol>
      </section>
  
      <!-- Main content -->
      <section class="content">