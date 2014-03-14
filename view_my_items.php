<?php
	include('common.php');

	if (isset($_SESSION['username'])){
		//echo $_GET['id'];
		if ($stmt = $conn->prepare("SELECT * FROM item WHERE user = ?")) {
			$stmt->bind_param('s', $_SESSION['username']);
			$stmt->execute();
			$res = $stmt->get_result();
			if ($res -> num_rows == 0) {
				$error = 'NoItemPosted';
				}
			}
		}
	else{
		$error = 'NotLoggedIn';
		}

$page_title = 'CS2102 Classfieds - My Items';
include('header.php');

?>
	

    <div class="container">
      
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
	 
<?php
  include('footer.php');
?>
