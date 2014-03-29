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

		<?php
		} else if(isset($_SESSION['role'] && $_SESSION['role'] == "admin"){
		?>


		<FORM action="add_modify_item.php">
			<input type="hidden" name="id" value="<?php echo $item['id'] ?>">
			<INPUT type=submit style=" vertical-align: middle;" value="Edit item" class="btn btn-primary" >
		</FORM>
					

		<?php
		}
		?>
		
		<br>
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
		<div class="row">
			
<!--
SELECT COUNT(v2.item_id) AS count, v2.item_id FROM views v1, views v2 WHERE v1.item_id = 10 AND v1.user_id = v2.user_id AND v2.item_id <> 10 AND v2.user_id <> 'john' GROUP BY v2.item_id ORDER BY count DESC

SELECT * FROM item WHERE id in (
SELECT COUNT(v2.item_id) AS count, v2.item_id FROM views v1, views v2 WHERE v1.item_id = 10 AND v1.user_id = v2.user_id AND v2.item_id <> 10 AND v2.user_id <> 'john' GROUP BY v2.item_id ORDER BY count DESC
)

SELECT * FROM item WHERE id in (
SELECT v2.item_id FROM views v1, views v2 WHERE v1.item_id = 10 AND v1.user_id = v2.user_id AND v2.item_id <> ? AND v2.user_id <> ? GROUP BY v2.item_id ORDER BY COUNT(v2.item_id) DESC LIMIT 0, 10
)
-->
			
			<h3>Users who viewed this item also viewed:</h3>
			<?php if ($relatedItemsStmt = $conn->prepare('
SELECT i.title, i.photo, i.id, COUNT(v2.item_id) as count FROM item i, views v1, views v2 WHERE v1.item_id = 10 AND v1.user_id = v2.user_id AND v2.item_id <> ? AND v2.user_id <> ? AND i.id = v2.item_id GROUP BY v2.item_id ORDER BY count DESC LIMIT 0, 6
			')) {
					$relatedItemsStmt->bind_param('is', $item['id'], $_SESSION['username']);
					$relatedItemsStmt->execute();
					$relatedItemsRes = $relatedItemsStmt->get_result();
					while($relItem = $relatedItemsRes ->fetch_assoc()){
						$itemphoto='img/noimg.jpg';
						if($relItem['photo']!= NULL) 
							$itemphoto='content/item/'.$relItem['photo'];
						?>
						<div class="col-md-2">
							<a href="view_item.php?id=<?= $relItem['id']; ?>" title="<?= $relItem['count']; ?> other user<?= $relItem['count'] > 1 ? 's' : '' ?> viewed this item">
								<img src="<?= $itemphoto; ?>" style="max-width:150px;max-height:200px;">
								<?= $relItem['title']; ?>
							</a>
						</div>							
						<?php
					}
				}
				//var_dump ($conn->error);
			?>
		</div>
	</div>
	 <?php } ?> 

<?php
  include('footer.php');
?>
