<?php
include('common.php');

//get list of all categories
if ($stmt = $conn->prepare("SELECT * FROM category")) {
	$stmt->execute();
	$res = $stmt->get_result();
	// $cat_temp = $res->fetch_assoc();

	$x = 0;

	while ( $cat_temp = $res->fetch_assoc()) {
		$categories[$x] =  (string) $cat_temp['name'];
		// print_r($cat_temp);
		$x++;
	}
}

//if fields are set
if (isset($_POST['title']) && isset($_POST['summary']) && isset($_POST['description']) && isset($_POST['condition']) && isset($_POST['price']) ){
	//echo "Fields are set";

	// Process photo uploads
	$img_submitted = false;
	if (isset($_FILES['img']) && $_FILES['img']['name'] != ''){
		$img_submitted = true;
		include_once('imageUploadHandler.php');
		try{
			$img_path = processUpload('img', 'content/item/');
		}catch(Exception $e) {
			$img_err = 'An error occurred<br>' . $e->getMessage();
		}
	}

	if (($img_submitted && !isset($img_path)) || isset($img_err)){
		// Image submitted but not uploaded, error!
		// This part is false (so will continue to execute the correct code)
		// if the image is NOT submitted, or, if the image is submitted and uploaded correctly
		$err = $img_err;
		$item = array("title"=>$_POST['title'],
			"summary"=>$_POST['summary'],
			"description"=>$_POST['description'],
			"cond"=>$_POST['condition'],
			"price"=>$_POST['price']
			);
	}
	else if($_POST['condition'] == "invalid"){
		//echo "condition invalid";
		$err = "Please set the condition of the item";
		$item = array("title"=>$_POST['title'],
			"summary"=>$_POST['summary'],
			"description"=>$_POST['description'],
			"cond"=>$_POST['condition'],
			"price"=>$_POST['price']
			);
	}
	//if price is invalid field
	else if(!is_numeric($_POST['price'])){
		//echo "price invalid";
		$err = "Price is invalid, only numbers are allowed. E.g 5.50";
		//repopulate
		$item = array("title"=>$_POST['title'],
			"summary"=>$_POST['summary'],
			"description"=>$_POST['description'],
			"cond"=>$_POST['condition'],
			"price"=>$_POST['price']
			);

	}

	//if it's not edit item, it is add item
	else if(!isset($_POST['item_id'])){
		//echo "adding item";
		if ($stmt = $conn->prepare("INSERT INTO item (user, title, summary, description, cond, price, photo) VALUES (?, ?, ?, ?, ?, ?, ?)")) {
			
			if (!isset($img_path)){
				$img_path = null;	
			}
			$stmt->bind_param('sssssds', $_SESSION["username"], $_POST['title'], $_POST['summary'], $_POST['description'], $_POST['condition'], $_POST['price'], $img_path);
			if ($stmt->execute()){
				//$conn->error;
				
				//echo "<script type='text/javascript'>alert('$message');</script>";

				//need to key in entries for tags / categories
				//get the index of the item that we just entered
				$item_index = $conn->insert_id;

				for($x = 0; $x < count( $_POST['ticked_categories']); $x++){
					if ($stmt = $conn->prepare("INSERT INTO tagged (item_id, cat_name) VALUES (?, ?)")) {
						$stmt->bind_param('is',  $item_index ,$_POST['ticked_categories'][$x]);
						if (!$stmt->execute()){
							//echo $conn->error;
							$err = 'An error occured<br>'.$conn->error;
						}
					}

				}
				
				$message = "Item has been posted. <a href=\"view_item.php?id=$item_index\">Click here to view your item listing</a>.<br>You can use the page below to add another listing!";
				
			}else{
				//echo $conn->error;
				$err = 'An error occured<br>'.$conn->error;
			}
		}else{
			//echo $conn->error;
			$err = 'An error occured<br>'.$conn->error;
		}
	}

	//if we're modifying an existing item
	else if(isset($_POST['item_id'])){
		//echo "editing item";
		if ($stmt = $conn->prepare("UPDATE item set title = ?, summary = ?, description = ?, cond = ?, price = ? where id = ? and user = ?")) {

			$bindParam = new BindParam();

			$build_stmt = 'UPDATE item SET title = ?, summary = ?, description = ?, cond = ?, price = ?';
			$bindParam->add('s', $_POST['title']);
			$bindParam->add('s', $_POST['summary']);
			$bindParam->add('s', $_POST['description']);
			$bindParam->add('s', $_POST['condition']);
			$bindParam->add('s', $_POST['price']);
			
			if ($img_submitted && isset($img_path)){
				$build_stmt .= ', photo = ?';
				$bindParam->add('s', $img_path);	
			}

			$build_stmt .= ' where id = ? and user = ?';
			$bindParam->add('s', $_POST['item_id']);

			//check if admin, fill in with the poster's username
			if($_SESSION['role'] == 'admin'){
				//since he is admin, he can modify the post
				$bindParam->add('s', $item['user']);
			}
			else{
				//if username is same as poster username, the sql command will not permit it
				$bindParam->add('s', $_SESSION["username"]);
			}
			$stmt = $conn->prepare($build_stmt);
			echo $conn->error;
			call_user_func_array(array($stmt, 'bind_param'), $bindParam->getRef()); 

			$stmt->execute();
			echo $conn->error;
			$message = "Item has been updated";
			//echo "<script type='text/javascript'>alert('$message');</script>";

			//update if tags are updated
			//drop off all the old tags
			if ($stmt = $conn->prepare("DELETE FROM tagged WHERE item_id =?")) {
				$stmt->bind_param('i',  $_POST['item_id']);
				$stmt->execute();
				echo $conn->error;
			}
			//re-insert the current set of tags
			for($x = 0; $x < count( $_POST['ticked_categories']); $x++){
				if ($stmt = $conn->prepare("INSERT INTO tagged (item_id, cat_name) VALUES (?, ?)")) {
					$stmt->bind_param('is',  $_POST['item_id'] ,$_POST['ticked_categories'][$x]);
					//echo "reinserted!";
					$stmt->execute();
					echo $conn->error;
				}

			}

		}

	}

	// deletion of item?
	if(isset($_POST['Delete'])){
		if($item['user'] == $_SESSION['username'] || $_SESSION['role'] == 'admin' ){}
			if ($stmt = $conn->prepare("DELETE FROM item where id = ?")) {
				$stmt->bind_param('i', $item['id']);
				$stmt->execute();
				echo $conn->error;
			}
		}
	}


//if edit item - load up item
if (isset($_GET['id'])){

	if ($stmt = $conn->prepare("SELECT * FROM item WHERE id = ?")) {
		$stmt->bind_param('i', $_GET['id']);
		$stmt->execute();
		$res = $stmt->get_result();
		$item = $res->fetch_assoc();

		if ($stmt = $conn->prepare("SELECT cat_name FROM tagged WHERE item_id = ?")) {
			$stmt->bind_param('i', $_GET['id']);
			$stmt->execute();
			$res = $stmt->get_result();

			$x = 0;
			$all_tags = array();
			while ( $tags = $res->fetch_assoc()) {
				$all_tags[$x] =  (string) $tags['cat_name'];
				//print_r($tags);
				$x++;
			}
		}
		echo $conn->error;

	}

}

$page_title = 'CS2102 Classifieds - Add/Edit Item';
include('header.php');
?>

<div class="container" style="margin-bottom:50px;">

	<?php if(isset($item)){?>
	<h1>Edit Item</h1>
	<?php } else {?>
	<h1>Add Item</h1>
	<?php } ?>


	<form role="form" action="add_modify_item.php<?= isset($item) ? '?id='.$item['id'] : '' ?>" method="post" enctype="multipart/form-data">
		<div class="row">
			<?php if (isset($message)){ ?>
			<div class="alert alert-success alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<?= $message ?>
			</div>
			<?php } ?>
			<?php if (isset($err)){ ?>
			<div class="alert alert-danger alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<?= $err ?>
			</div>
			<?php } ?>
		</div>
		<div class="row">
			<div class="col-md-4" style="padding-top:30px;">
				<div class="form-group">
					<img src="<?= isset($item['photo']) ? 'content/item/'.$item['photo'] : 'img/noimg.jpg' ?>" alt="">
				</div>
				<div class="form-group">            
					<label>Change Photo</label>
					<input type="file" name="img"> 
				</div>        
			</div>
			<div class="col-md-8">
				<div class="form-group">
					<label>Title</label>
					<input type="text" name = "title" class="form-control" placeholder="Title" required autofocus value="<?php echo (isset($item)? $item['title'] : ''); ?>">
				</div>

				<div class="form-group">
					<label>Summary</label>
					<input type="text" name = "summary" class="form-control" placeholder="Summary" required value="<?php echo (isset($item)? $item['summary'] : ''); ?>">
				</div>
				<div class="form-group">        
					<label>Description</label>
					<textarea name="description" class="form-control" placeholder="Description" required><?php echo (isset($item)? $item['description'] : ''); ?></textarea>
				</div>

				<div class="form-group">
					<label>Category</label>
					<?php 

					for($x = 0; $x < count($categories); $x++) {
						$checked = false;
						if (isset($all_tags)){
							$checked = in_array($categories[$x], $all_tags);
						} 

						?>            
						<div class="checkbox">
							<label>
								<input type="checkbox" name="ticked_categories[]" value="<?php echo $categories[$x]?>" <?= $checked ? 'checked' : '' ?>>
								<?php echo $categories[$x]?>
							</label>
						</div>
						<?php } ?>
					</div>  

					<div class="form-group">        
						<label>Condition</label>
						<input type="text" name = "condition" class="form-control" placeholder="Condition of item" required value="<?php echo (isset($item)? $item['cond'] : ''); ?>" >
					</div>    

				<!--
<div class="control-group">
<label class="control-label" for="inputModuleCode">Condition of Item</label>
<div class="controls">
<select id="inputModuleCode" name = "condition">
<option id="option" value = "invalid" >Select item</option>
<option id="option1" value = "Brand new" <?php echo (isset($item) && $item['cond']=='Brand new' ? 'selected' : ''); ?> >Brand new</option>
<option id="option2" value = "Excellent" <?php echo (isset($item) && $item['cond']=='Excellent' ? 'selected' : ''); ?> >Excellent</option>
<option id="option3" value = "Good" <?php echo (isset($item) && $item['cond']=='Good' ? 'selected' : ''); ?> >Good</option>
<option id="option4" value = "Decent" <?php echo (isset($item) && $item['cond']=='Decent' ? 'selected' : ''); ?> >Decent</option>
<option id="option5" value = "Slightly Screwed"  <?php echo (isset($item) && $item['cond']=='Slightly Screwed' ? 'selected' : ''); ?> >Slightly screwed</option>
<option id="option6" value = "Screwed"  <?php echo (isset($item) && $item['cond']=='invalid' ? 'selected' : ''); ?> >Screwed </option>
</select>                   
</div>
</div>
-->

<div class="form-group">        
	<label>Price</label>
	<input type="text" name = "price" class="form-control" placeholder="Price" required value="<?php echo (isset($item)? $item['price'] : '');?>">
</div>

<?php
if(isset($item) && ( ( isset($_SESSION['username']) && $item['user'] == $_SESSION['username']) || (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') ) ){
	?>
	<input type = "submit" class="btn btn-primary pull-left" type="button" id="post_btn" value="Edit"/>
	<input type="hidden" name = "item_id" class="form-control" value="<?php echo $item['id']; ?>">

	<input type = "submit" class="btn btn-primary pull-left" type="button" id="post_btn" value="Delete"/>
	<input type="hidden" name = "item_id" class="form-control" value="<?php echo $item['id']; ?>">

	<?php
}else{
	?>
	<input type = "submit" class="btn btn-primary pull-left" type="button" id="edit_btn" value="Post"/>
	<?php
}
?>

</div>
</div>

</form>

</div>

<?php

include('footer.php');

?>
