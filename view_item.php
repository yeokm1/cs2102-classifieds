<?php
	include('header.php');

	if (isset($_GET['id'])){
		//echo $_GET['id'];
		if ($stmt = $conn->prepare("SELECT * FROM item WHERE id = ?")) {
			$stmt->bind_param('i', $_GET['id']);
			$stmt->execute();
			$res = $stmt->get_result();
			$item = $res->fetch_assoc();
			if ($res -> num_rows == 0) {
				$error = 'Invalid item';
				}
			}
		}
	else{
		$_GET['id']="Missing ID";
		$error = 'Invalid item';
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

        <title>Viewing item: <?php echo $item['title'] ?></title>

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
        <h1>Invalid item:  <?php echo $_GET['id'] ?></h1>
      </div>
	<?php
	    }
		else{
     ?>
	  
   <div class="table-responsive">
		<table class="table table-striped">
			<tr>
				<td colspan="2"> <div class="container-fluid ">
					<h1 style="float: left;padding-right:10px;">Viewing Item:  <?php echo $item['title'] ?></h1>
					&nbsp;
					  <?php 
						if(isset($_SESSION['username']) && $item['user']==$_SESSION['username']){
						
					?>
						<FORM action="add_modify_item.php">
							<input type="hidden" name="id" value="<?php echo $item['id'] ?>">
							<INPUT type=submit style=" vertical-align: middle;" value="Edit your own item" class="btn" >
						</FORM>
					<br>
					<?php
						}
					 ?>
				</td>

			</tr>
				
			<tr>
				<?php if($item['photo']!= NULL) { ?>
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
					<li><h3 class="form-signin-heading">Posted by:</h2>
					<a href="view_profile.php?username=<?php echo $item['user'] ?>">
					<?php echo $item['user'] ?>
					</a>
					<li><h3 class="form-signin-heading">ID</h2>
					<?php echo $item['id'] ?>
					<li><h3 class="form-signin-heading">Summary</h2>
					<?php echo $item['summary'] ?>
					<li><h3 class="form-signin-heading">Description</h2>
					<?php echo $item['description'] ?>
					<li><h3 class="form-signin-heading">Condition</h2>
					<?php echo $item['cond'] ?>
					<li><h3 class="form-signin-heading">Price</h2>
					<?php echo $item['price'] ?>
					<li><h3 class="form-signin-heading">Date</h2>
					<?php echo $item['date_listed'] ?>
					</ul>
					</div>
				</td>
			</tr>
		</table>
	 <?php } ?> 

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <script src="../../assets/js/docs.min.js"></script>
  </body>
</html>
