<?php
include('common.php');

if (isset($_GET['id'])){
	//echo $_GET['id'];
	if ($stmt = $conn->prepare("SELECT * FROM item WHERE id = ?")) {
		$stmt->bind_param('i', $_GET['id']);
		$stmt->execute();
		$res = $stmt->get_result();
		$item = $res->fetch_assoc();
		if ($res -> num_rows == 0) {
			$error = 'Invalid item';
		}else{
			if (isset($_SESSION['username'])){
				if ($stmt = $conn->prepare('INSERT INTO views (item_id, user_id, view_date) VALUES (?, ?, NOW()) ON DUPLICATE KEY UPDATE view_date = NOW()')) {
					$stmt->bind_param('is', $_GET['id'], $_SESSION['username']);
					if (!$stmt->execute()) {
						$error = 'Error logging user: '.$stmt->error;
					}
				}
			}	
		}
	}
}else{
	$_GET['id']="Missing ID";
	$error = 'Invalid item';
}

$page_title = 'CS2102 Classfieds - View an item';
include('header.php');

?>

    <div class="container">
      
	<?php
        if (isset ($error)){
    ?>
		<div>
          <h1>Invalid item:  <?php echo $_GET['id']; ?><br><?= $error ?></h1>
        </div>
	<?php
	    }
		else{
	?>
	  
		<h1>Viewing Item:  <?php echo $item['title'] ?></h1>
		<?php 
			if(isset($_SESSION['username']) && $item['user']==$_SESSION['username']){
		?>
		<FORM action="add_modify_item.php">
			<input type="hidden" name="id" value="<?php echo $item['id'] ?>">
			<INPUT type=submit style=" vertical-align: middle;" value="Edit your own item" class="btn btn-primary" >
		</FORM>
		<br>

		<?php
		} else if($_SESSION['role'] == "admin"){
		?>


		<FORM action="add_modify_item.php">
			<input type="hidden" name="id" value="<?php echo $item['id'] ?>">
			<INPUT type=submit style=" vertical-align: middle;" value="Edit item" class="btn" >
		</FORM>
		<br>					

		<?php
		}
		?>
		
		<div class="row">
			<div class="col-md-4" style="padding-top:30px;">
				
				<?php 
				$itemphoto='img/noimg.jpg';
				if($item['photo']!= NULL) 
					$itemphoto='content/item/'.$item['photo']; ?>
				
					<center>
					
					<!--PUT IMAGE HERE-HIDDEN UNLESS NOT NULL-->
					<img src="<?php echo $itemphoto ?>" class="img-thumbnail" style="max-width:500px">
					
					</center>
			</div>
			<div class="col-md-8">	  
				<dl>
				<dt>Posted by:</dt>
				<dd><a href="view_profile.php?username=<?php echo $item['user'] ?>">
				<dd><?php echo $item['user'] ?></a></dd>					
				<dt>Date Listed</dt>
				<dd><?php echo $item['date_listed'] ?></dd>
				<dt>Summary</dt>
				<dd><?php echo $item['summary'] ?></dd>
				<dt>Description</dt>
				<dd><?php echo $item['description'] ?></dd>
				<dt>Condition</dt>
				<dd><?php echo $item['cond'] ?></dd>
				<dt>Price</dt>
				<dd><?php echo $item['price'] ?></dd>
				<dt>Categories</dt>
				<dd>
				 <?php if ($itemCatStmt = $conn->prepare("SELECT cat_name FROM tagged WHERE item_id = ?")) {
						  $itemCatStmt->bind_param('i', $item['id']);
						  $itemCatStmt->execute();
						  $itemCatRes = $itemCatStmt->get_result();
						  $itemCatAll= array();
						  while($cat=$itemCatRes ->fetch_assoc()){
								$itemCatAll[] = '<a href="view_all_items.php?cat='.$cat['cat_name'].'">'.$cat['cat_name'].'</a>';  
							  }
						  }
						  echo (implode (", " , $itemCatAll ));?>	</dd>		
				</dl>
			</div>
		</div>
	</div>
	 <?php } ?> 

<?php
  include('footer.php');
?>
