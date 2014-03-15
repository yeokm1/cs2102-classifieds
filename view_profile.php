<?php
	include('common.php');

	if (isset($_GET['username'])){
		//echo $_GET['username'];
		if ($stmt = $conn->prepare("SELECT * FROM user WHERE username = ?")) {
			$stmt->bind_param('s', $_GET['username']);
			$stmt->execute();
			$res = $stmt->get_result();
			$user = $res->fetch_assoc();
			if ($res -> num_rows == 0) {
				$error = 'Invalid User: ';
			}
		if ($stmt = $conn->prepare("SELECT * FROM item WHERE user = ?")) {
			$stmt->bind_param('s', $_GET['username']);
			$stmt->execute();
			$user_res = $stmt->get_result();
			if ($user_res -> num_rows == 0) {
				$user_error = 'NoItemPosted';
				}
			}
		}
		
	}
	else{
		$_GET['username']="Missing username";
		$error = 'Invalid User: ';
	}
	
$page_title = 'CS2102 Classfieds - View Profile';
include('header.php');

?>
   
    <div class="container">
      
	<?php
        if (isset ($error)){
    ?>
		<div class="container-fluid ">
        <h1>Invalid username:  <?php echo $_GET['username'] ?></h1>
      </div>
	<?php
	    }
		else{
     ?>
	  
	  	 
 <div>
		<table class="table">
			<tr>
				<td colspan="2"> <div class="container-fluid ">
					<h1 style="float: left;padding-right:10px;">Viewing User:  <?php echo $user['username'] ?></h1>
					&nbsp;
					  <?php 
						if(isset($_SESSION['username']) && $user['username']==$_SESSION['username']){
						
					?>
						<FORM action="account.php">
							<INPUT type=submit style=" vertical-align: middle;" value="Edit your profile" class="btn btn-primary" >
						</FORM>
					<br>
					<?php
						} else if($_SESSION['role'] == "admin"){
					 ?>
					 

						<FORM action="add_modify_item.php">
							<input type="hidden" name="id" value="<?php echo $item['id'] ?>">
							<INPUT type=submit style=" vertical-align: middle;" value="Edit profile" class="btn" >
						</FORM>
					<br>					
					
					<?php
						}
					 ?>
				</td>

			</tr>
				
			<tr height="200px">

				<td width="30%">
					<?php 
					$userphoto='img/noimg.jpg';
					if($user['photo']!= NULL) 
						$userphoto=$user['photo']; ?>
				
					<center>
					
					<!--PUT IMAGE HERE-HIDDEN UNLESS NOT NULL-->
					<img src="<?php echo $userphoto ?>" class="img-thumbnail" style="max-width:500px">

					</center>
				</td>
				<td>
					<div class="container-fluid ">
						<dl>
						<dt><h2 class="form-signin-heading">Gender</h2></dt>
						<dd><?php echo $user['gender'] ?></dd>
						<dt><h2 class="form-signin-heading">Contact No</h2></dt>
						<dd><?php echo $user['phone'] ?></dd>
						<dt><h2 class="form-signin-heading">User since</h2></dt>
						<dd><?php echo $user['join_date'] ?></dd>
						</dl>									
					</div>
				</td>
			</tr>

		<?php if(isset($user_error)) { ?>
			<tr>
				<td colspan=2><p>No images posted yet!
				</td>
			</tr>
		<?php } ?>
		<tr><td colspan=2>
			 <table class="table table-hover">
				<thead>
					<tr>
						<th colspan=2><h2>Item(s) Posted:</h2>
						</th>
					</tr>
				</thead>
				<?php
					while($item=$user_res ->fetch_assoc()){
				?>
					<tr>
						<td width="20%">
						<?php 
						$itemphoto='img/noimg.jpg';
						if($item['photo']!= NULL) 
							$itemphoto=$item['photo']; ?>
						
						<center>
						
						<!--PUT IMAGE HERE-HIDDEN UNLESS NOT NULL-->
						<a href="view_item.php?id=<?php echo $item['id'] ?>" title="Click to find out more!"><img src="<?php echo $itemphoto ?>" class="img-thumbnail" style="max-width:200px"></a>
						
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
			</table>
			</td>
		</tr>
	</table>
	  
	
	<?php
       }
     ?>

<?php
  include('footer.php');
?>
