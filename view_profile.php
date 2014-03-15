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
	  
	  	 
 <div class="table-responsive">
		<table class="table table-striped">
			<tr>
				<td colspan="2"> <div class="container-fluid ">
					<h1 style="float: left;padding-right:10px;">Viewing User:  <?php echo $user['username'] ?></h1>
					&nbsp;
					  <?php 
						if(isset($_SESSION['username']) && $user['username']==$_SESSION['username']){
						
					?>
						<FORM action="account.php">
							<INPUT type=submit style=" vertical-align: middle;" value="Edit your own profile" class="btn" >
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
				
			<tr>
				<?php if($user['photo']!= NULL) { ?>
				<td style="padding-top:50px;" width="30%">
					<center>
					
										
					<!--PUT IMAGE HERE-HIDDEN UNLESS NOT NULL-->
					<img src="<?php echo $item['photo'] ?>" style="max-width:100%,vertical-align:top;padding-top:20px;">
					
					</center>
				</td>
					
				<?php } ?> 

				</td>
				<td>
					<div class="container-fluid ">
						<ul>
						<li><h2 class="form-signin-heading">Gender</h2>
						<?php echo $user['gender'] ?>
						<li><h2 class="form-signin-heading">Contact No</h2>
						<?php echo $user['phone'] ?>
						
						<hr />
						<li><h2 class="form-signin-heading">Item(s) Posted:</h2>
						
						
						
						<?php if(isset($user_error)) { ?>
						<p>No images posted yet!
						<?php } ?>
						<ul>
						<?php
						
						while($item=$user_res ->fetch_assoc()){
						
						?>
						
						<li><a href="view_item.php?id=<?php echo $item['id'] ?>">
								<b><?php echo $item['title'] ?></b></a>	
							<p><?php echo $item['summary'] ?>
						
						<?php
						}	
						?>
						
						</ul>
					</ul>	
				  </div>
				</td>
			</tr>
		</table>
	  
	
	<?php
       }
     ?>

<?php
  include('footer.php');
?>
