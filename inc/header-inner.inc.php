<!DOCTYPE html>
  <html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo "{$sysFullName} v{$sysVersion} by {$sysDeveloperName}" ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo "{$baseUrl}/css/bootstrap.min.css"; ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo "{$baseUrl}/css/font-awesome.min.css"; ?>">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo "{$baseUrl}/css/ionicons.min.css"; ?>">
    <!-- jvectormap -->
    <link rel="stylesheet" href="<?php echo "{$baseUrl}/plugins/jquery-jvectormap.css"; ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo "{$baseUrl}/css/AdminLTE.min.css"; ?>">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo "{$baseUrl}/css/skins/skin-black.min.css"; ?>">
    <!-- iCheck -->
    <!-- <link rel="stylesheet" href="<?php echo "{$baseUrl}/plugins/icheck-futurico/futurico.css"; ?>"> -->
    <link rel="stylesheet" href="<?php echo "{$baseUrl}/plugins/icheck-square/square.css"; ?>">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="<?php echo "{$baseUrl}/plugins/bootstrap-datepicker.min.css"; ?>">
    <link rel="stylesheet" href="<?php echo "{$baseUrl}/plugins/daterangepicker.css"; ?>">
    <!-- bootstrap dataTables -->
    <link rel="stylesheet" href="<?php echo "{$baseUrl}/plugins/dataTables.bootstrap.min.css"; ?>">
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  
    <!-- Google Font -->
    <!--<link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">-->

    <style>
      .example-modal .modal {
        position: relative;
        top: auto;
        bottom: auto;
        right: auto;
        left: auto;
        display: block;
        z-index: 1;
        background: transparent !important;
      }
  </style>
  </head>

  <?php echo "<body class=\"hold-transition{$bodyClassAdditional}\">" ?>