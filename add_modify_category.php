	<?php 
	$page_title = 'CS2102 Classifieds - Add/Edit Category';
	include('header.php');
	include('common.php');

	if(isset($_GET['title'])) {
		$cat_title = $_GET['title'];
	}

	if(isset($_POST['title'])) {
		$cat_title = $_POST['title'];
		if(isset($_GET['title'])) {
			if($stmt = $conn->prepare("UPDATE category SET name = ? WHERE category(name) = ?")) {
				$stmt->bind_param('ss', $_POST['title'], $_GET['title']);
				$stmt->execute();
				echo $conn->error;
				$message = "Your entry has been updated";
				echo "<script type='text/javascript'>alert('$message');</script>";
			}
		} else {
			if($stmt = $conn->prepare("INSERT INTO category (name) VALUES (?)")) {
				$stmt->bind_param('s', $_POST['title']);
				$stmt->execute();
				echo $conn->error;
				$message = "Your entry has been posted";
				echo "<script type='text/javascript'>alert('$message');</script>";
			}
		} 
	}

	?>

	<div class="container">

		<h1>Add/Edit Category</h1>


		<form class="form-signin" role="form" action="add_modify_category.php" method="post">
			<h2 class="form-signin-heading">Title</h2>
			<input type="text" name = "title" class="form-control" placeholder="Title" required autofocus value="<?php echo (isset($cat_title)? $cat_title : ''); ?>">

			<input type = "submit" class="btn btn-primary pull-left" type="button" id="post_btn" value="Edit"/>
		</form>
	</div>

	<?php

	include('footer.php');

	?>