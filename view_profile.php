<?php
	include('common.php');

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
		if ($stmt = $conn->prepare("SELECT * FROM item WHERE user = ?")) {
			$stmt->bind_param('s', $_GET['username']);
			$stmt->execute();
			$user_res = $stmt->get_result();
			if ($user_res -> num_rows == 0) {
				$user_error = 'NoItemPosted';
				}
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

    <title>Viewing profile: <?php echo $_GET['username'] ?></title>

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
	  
	  	 
 <div class="table-responsive">
		<table class="table table-striped">
			<tr>
				<td colspan="2"> <div class="container-fluid ">
					<h1 style="float: left;padding-right:10px;">Viewing User:  <?php echo $user['username'] ?></h1>
					&nbsp;
					  <?php 
						if(isset($_SESSION['username']) && $user['username']==$_SESSION['username']){
						
					?>
						<FORM action="account.php">
							<INPUT type=submit style=" vertical-align: middle;" value="Edit your own profile" class="btn" >
						</FORM>
					<br>
					<?php
						}
					 ?>
				</td>

			</tr>
				
			<tr>
				<?php if($user['photo']!= NULL) { ?>
				<td style="padding-top:50px;" width="30%">
					<center>
					
										
					<!--PUT IMAGE HERE-HIDDEN UNLESS NOT NULL-->
					<img src="<?php echo $item['photo'] ?>" style="max-width:100%,vertical-align:top;padding-top:20px;">
					
					</center>
				</td>
					
				<?php } ?> 

				</td>
				<td>
					<div class="container-fluid ">
						<ul>
						<li><h2 class="form-signin-heading">Gender</h2>
						<?php echo $user['gender'] ?>
						<li><h2 class="form-signin-heading">Contact No</h2>
						<?php echo $user['phone'] ?>
						
						<hr />
						<li><h2 class="form-signin-heading">Item(s) Posted:</h2>
						
						
						
						<?php if(isset($user_error)) { ?>
						<p>No images posted yet!
						<?php } ?>
						<ul>
						<?php
						
						while($item=$user_res ->fetch_assoc()){
						
						?>
						
						<li><a href="view_item.php?id=<?php echo $item['id'] ?>">
								<b><?php echo $item['title'] ?></b></a>	
							<p><?php echo $item['summary'] ?>
						
						<?php
						}	
						?>
						
						</ul>
					</ul>	
				  </div>
				</td>
			</tr>
		</table>
	  
	
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
