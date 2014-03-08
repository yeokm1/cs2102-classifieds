<?php
	include('header.php');

	if (isset($_SESSION['username'])){
		//echo $_GET['id'];
		if ($stmt = $conn->prepare("SELECT * FROM item WHERE user = ?")) {
			$stmt->bind_param('s', $_SESSION['username']);
			$stmt->execute();
			$res = $stmt->get_result();
			$item = $res->fetch_assoc();
			if ($res -> num_rows == 0) {
				$error = 'NoItemPosted';
				}
			}
		}
	else{
		$error = 'NotLoggedIn';
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

    <title>View your list of items</title>

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
	<div class="container-fluid ">
	<h1>Your posted items</h1></div>
	<?php include('navigation.html'); ?>

    <div class="container-fluid">
      
	<?php
        if (isset($error) && $error == "NoItemPosted"){
    ?>
		<div class="container-fluid ">
			<p>You have no items posted yet!
			<p>Click <a href="add_modify_item.php">here</a> to create your first one!
		
		</div>
	<?php
	    }
		else if(isset($error) && $error == "NotLoggedIn"){
     ?>
		<div class="container-fluid ">
			<p>Error! You are not logged in!
			<p>Click <a href="signin.php">here</a> to login!
		</div>
	<?php
	    }
		else{
     ?>
	  
		 
      <div class="container-fluid ">
		
		<?php
	    
		while($item=$res ->fetch_assoc()){
		
		?>
		<li><h2><?php echo $item['title'] ?></h2>
			<FORM action="add_modify_item.php">
				<input type="hidden" name="id" value="<?php echo $item['id'] ?>">
				<INPUT type=submit value="Edit" class="btn btn-primary pull-center">
			</FORM>
			<p>
			<ul>
			<li><b>ID:</b> <?php echo $item['id'] ?>
			<li><b>Summary:</b> <?php echo $item['summary'] ?>
			<li><b>Date Listed:</b> <?php echo $item['date_listed'] ?>

			</ul>
			<hr />
		
		<?php
		}	
		?>
		
		</ul>
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
