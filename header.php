<?php

if (!isset($page_title)){
  $page_title = 'CS2102 Classifieds';
}

if (!isset($extra_head)){
  $extra_head = '';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">

  <title><?= $page_title ?></title>

  <!-- Bootstrap core CSS -->
  <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap theme -->
  <link href="bootstrap/dist/css/bootstrap-theme.min.css" rel="stylesheet">
  
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,700italic,400,700,600' rel='stylesheet' type='text/css'>

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
  
  <style>
  body{
    padding-top: 50px;
    font-family: 'Open Sans';
  }
  </style>

  <?= $extra_head ?>
</head>

<body role="document">

  <!-- Fixed navbar -->
  <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="view_all_items.php">CS2102 Classifieds</a>
      </div>
      <div class="navbar-collapse collapse">
       <div class="navbar-right">
        <ul class="nav navbar-nav">

          <?php
          if (isset($_SESSION['username'])){
            ?>
            <li><a href="account.php">Hi, <?= $_SESSION['username'] ?></a></li>
				<?php
				if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'){
				  ?><li><a href="admin.php">Admin</a></li>
				  <?php  
				}
				?>
            <li><a href="add_modify_item.php">Sell</a></li>
            <li><a href="view_my_items.php">My Classifieds</a></li>
            <li><a href="signout.php">Logout</a></li>
            <?php
          }else{ 
            ?>
			<!--NOT LOGGED IN-->
            <li><a href="signin.php">Sign in</a></li>
            <li><a href="account.php">Register</a></li>
            <?php
          }
          ?>
        </ul>
      </div>
    </div><!--/.nav-collapse -->
  </div>
</div>