	<?php 
	$page_title = 'CS2102 Classifieds - Add/Edit Category';
	include('header.php');

	?>

	<div class="container">

		<h1>Add/Edit Category</h1>


		<form class="form-signin" role="form" action="admin.php?action=category&mode=<?php echo $form_mode ?>&id=<?php echo $cat_title ?>" method="post">
			<div class="form-group">
			<h2 class="form-signin-heading">Category name:</h2>
			<input type="text" name = "title" class="form-control" placeholder="Title" required autofocus value="<?php echo (isset($cat_title)? $cat_title : ''); ?>">
			</div>

			<div class="form-group">
			<div class="col-md-1">
				<input type = "submit" class="btn btn-primary pull-left" type="button" id="post_btn" value="<?php echo (($form_mode == "new")? "Add": "Edit"); ?>"/>
			</div>
			<?php if($form_mode != "new") { ?>
				<div class="col-md-1">
					<input type = "submit" class="btn btn-danger pull-left" type="button" id="post_btn" name = 'delete' value="Delete"/>
				</div>
			<?php } ?>
			</div>
		</form>
	</div>

	<?php

	include('footer.php');

	?>