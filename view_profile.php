<?php
	include('header.php');

	if (isset($_GET['username'])){
		//echo $_GET['username'];
		if ($stmt = $conn->prepare("SELECT * FROM user WHERE username = ?")) {
			$stmt->bind_param('s', $_GET['username']);
			$stmt->execute();
			$res = $stmt->get_result();
			$user = $res->fetch_assoc();
			if ($res -> num_rows == 0) {
				$error = 'Invalid User: ';
			}
		}
		
	}
	else{
		$_GET['username']="Missing username";
		$error = 'Invalid User: ';
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

    <title>CS2102 I</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/dashboard.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

	<?php include('navigation.html'); ?>
   
    <div class="container-fluid">
      
	<?php
        if (isset ($error)){
    ?>
		<div class="container-fluid ">
        <h1>Invalid username:  <?php echo $_GET['username'] ?></h1>
      </div>
	<?php
	    }
		else{
     ?>
	  
	  	 
	  
      <div class="container-fluid ">
        <h1>Viewing User:  <?php echo $user['username'] ?></h1>
      </div>

	   <?php 
			if(isset($_SESSION['username']) && $user['username']==$_SESSION['username']){
			
		?>
			<FORM action="account.php">
				<INPUT type=submit value="Edit your own profile" class="btn btn-primary pull-center">
			</FORM>
		<br>
		<?php
			}
		 ?>
		 
      <div class="container-fluid ">
        <ul>
		<li><h2 class="form-signin-heading">Gender</h2>
        <?php echo $user['gender'] ?>
        <li><h2 class="form-signin-heading">Contact No</h2>
        <?php echo $user['phone'] ?>
		</ul>
      </div>

    </div>
	
	<?php
       }
     ?>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <script src="../../assets/js/docs.min.js"></script>
  </body>
</html>
