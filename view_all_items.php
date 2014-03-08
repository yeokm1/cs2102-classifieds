<?php
	include('header.php');

	if ($stmt = $conn->prepare("SELECT * FROM item ORDER BY id DESC")) {
		$stmt->execute();
		$res = $stmt->get_result();
		if ($res -> num_rows == 0) {
			$error = 'NoItemPosted';
			}
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

    <title>View all items</title>

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
	
	<div class="container-fluid ">
	<table class="table table-striped">
		 <thead>
			<tr>
				<th colspan="2"> <div class="container-fluid ">
					<h1>All listed items</h1>
				</th>
			</tr>
		</thead>
			
			
		<?php
        if (isset($error) && $error == "NoItemPosted"){
		?>
		<tr>
			<td>
		<div class="container-fluid ">
			<p>No items posted yet!
			<p>Click <a href="add_modify_item.php">here</a> to start!
		
		</div>
		</td>
		</tr>
		</table>
	<?php
	    }
		else{
     ?>
	  
      <?php
	    
		while($item=$res ->fetch_assoc()){
		
		?>
		<tr>
			<?php if($item['photo']!= NULL) { ?>
			<td style="padding-top:50px;" width="30%">
				<center>
				
				<!--PUT IMAGE HERE-HIDDEN UNLESS NOT NULL-->
				<img src="<?php echo $item['photo'] ?>" style="max-width:100%,vertical-align:top;padding-top:20px;">
				
				</center>
			</td>
							<?php } ?> 
		
			<td style="padding-left:50px;"><h2><a href="view_item.php?id=<?php echo $item['id'] ?>"><?php echo $item['title'] ?></a></h2>
				<p>
				<ul>
				<li><b>ID:</b> <?php echo $item['id'] ?>
				<li><b>Summary:</b> <?php echo $item['summary'] ?>
				<li><b>Date Listed:</b> <?php echo $item['date_listed'] ?>

				</ul>
				
			</td>
		</tr>
		<?php
		}	
		?>
		

		<?php
		}	
		?>
	  
	  </table>
	  
	  
	  
	<?php
        if (isset($error) && $error == "NoItemPosted"){
    ?>
		<div class="container-fluid ">
			<p>No items posted yet!
			<p>Click <a href="add_modify_item.php">here</a> to start!
		
		</div>
	  
	<?php
	    }
		else{
     ?>
      <div class="container-fluid ">
		
		
		<?php
	    
		while($item=$res ->fetch_assoc()){
		
		?>
		<li><h2><a href="view_item.php?id=<?php echo $item['id'] ?>"><?php echo $item['title'] ?></a></h2>
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
