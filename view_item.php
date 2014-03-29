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
				</td>

			</tr>
				
			<tr>
			<td width="30%">
				<?php 
				$itemphoto='img/noimg.jpg';
				if($item['photo']!= NULL) 
					$itemphoto='content/item/'.$item['photo']; ?>
				
					<center>
					
					<!--PUT IMAGE HERE-HIDDEN UNLESS NOT NULL-->
					<img src="<?php echo $itemphoto ?>" class="img-thumbnail" style="max-width:500px">
					
					</center>
				</td>
				<td>
					<div class="container-fluid ">
	  
					<dl>
					<dt><h3 class="form-signin-heading">Posted by:</h3></dt>
					<dd><a href="view_profile.php?username=<?php echo $item['user'] ?>">
					<dd><?php echo $item['user'] ?></a></dd>					
					<dt><h3 class="form-signin-heading">Date Listed</h3></dt>
					<dd><?php echo $item['date_listed'] ?></dd>
					<dt><h3 class="form-signin-heading">Summary</h3></dt>
					<dd><?php echo $item['summary'] ?></dd>
					<dt><h3 class="form-signin-heading">Description</h3></dt>
					<dd><?php echo $item['description'] ?></dd>
					<dt><h3 class="form-signin-heading">Condition</h3></dt>
					<dd><?php echo $item['cond'] ?></dd>
					<dt><h3 class="form-signin-heading">Price</h3></dt>
					<dd><?php echo $item['price'] ?></dd>
					<dt><h3 class="form-signin-heading">Categories</h3></dt>
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
				</td>
			</tr>
		</table>
	 <?php } ?> 

<?php
  include('footer.php');
?>
