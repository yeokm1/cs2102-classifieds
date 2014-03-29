	<?php 
	$page_title = 'CS2102 Classifieds - Add/Edit Category';
	include('header.php');

	?>

	<div class="container">

		<h1>Add/Edit Category</h1>


		<form class="form-signin" role="form" action="admin.php?action=category&mode=<? echo $form_mode ?>&id=<? echo $cat_title ?>" method="post">
			<h2 class="form-signin-heading">Title</h2>
			<input type="text" name = "title" class="form-control" placeholder="Title" required autofocus value="<?php echo (isset($cat_title)? $cat_title : ''); ?>">

			<input type = "submit" class="btn btn-primary pull-left" type="button" id="post_btn" value="<?php echo (($form_mode == "new")? "Add": "Edit"); ?>"/>
		</form>
	</div>

	<?php

	include('footer.php');

	?>