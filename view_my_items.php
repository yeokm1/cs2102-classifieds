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
	<table class="table table-hover">
		 <thead>
			<tr>
				<th colspan="2">
					<h1>Viewing your listed items</h1>
				</th>
			</tr>
		</thead>
      
	<?php
        if (isset($error) && $error == "NoItemPosted"){
    ?>
	<tr>
		<td>
			<div class="container-fluid ">
				<blockquote><p>You have no items posted yet!
				<p>Click <a href="add_modify_item.php">here</a> to create your first one!</blockquote>
			
			</div>
		</td>
	</tr>
	<?php
	    }
		else if(isset($error) && $error == "NotLoggedIn"){
     ?>
	 <tr>
		<td>
			<div class="container-fluid ">
				<blockquote><p>Error! You are not logged in!
				<p>Click <a href="signin.php">here</a> to login!</blockquote>
			</div>
		</td>
	</tr>
	<?php
	    }
		else{
     ?>
		
		<?php
		
	while($item=$res ->fetch_assoc()){
		
		?>
		<tr>
			<td width="20%">
			<?php 
			$itemphoto='img/noimg.jpg';
			if($item['photo']!= NULL) 
				$itemphoto='content/item/'.$item['photo']; ?>
		
			<center>
			
			<!--PUT IMAGE HERE-HIDDEN UNLESS NOT NULL-->
			<a href="view_item.php?id=<?php echo $item['id'] ?>" title="Click to find out more!"><img src="<?php echo $itemphoto ?>" class="img-thumbnail" style="max-width:200px; max-height:200px;"></a>
			
			</center>
			</td>
		
			<td style="padding-left:50px;"><h2><a href="view_item.php?id=<?php echo $item['id'] ?>" title="Click to find out more!"><?php echo $item['title'] ?></a></h2>
				<p>
				<ul>
				<li><b>Date Listed:</b> <?php echo $item['date_listed'] ?>
				<li><b>Summary:</b> <?php echo $item['summary'] ?>
				<li><b>Price:</b> <?php echo $item['price'] ?>
				<li><b>Condition:</b> <?php echo $item['cond'] ?>
				<li><b>Categories:</b> 
				 <?php if ($itemCatStmt = $conn->prepare("SELECT cat_name FROM tagged WHERE item_id = ?")) {
						  $itemCatStmt->bind_param('i', $item['id']);
						  $itemCatStmt->execute();
						  $itemCatRes = $itemCatStmt->get_result();
						  $itemCatAll= array();
						  while($cat=$itemCatRes ->fetch_assoc()){
								$itemCatAll[] = '<a href="view_all_items.php?cat='.$cat['cat_name'].'">'.$cat['cat_name'].'</a>';  
							  }
						  }
						  echo (implode (", " , $itemCatAll ));?>	</li>		
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
  include('footer.php');
?>
