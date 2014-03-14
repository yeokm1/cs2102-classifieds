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
				}
			}
		}
	else{
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
          <h1>Invalid item:  <?php echo $_GET['id'] ?></h1>
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
							<INPUT type=submit style=" vertical-align: middle;" value="Edit your own item" class="btn" >
						</FORM>
					<br>
					<?php
						}
					 ?>
				</td>

			</tr>
				
			<tr>
				<?php if($item['photo']!= NULL) { ?>
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
					<li><h3 class="form-signin-heading">Posted by:</h2>
					<a href="view_profile.php?username=<?php echo $item['user'] ?>">
					<?php echo $item['user'] ?>
					</a>
					<li><h3 class="form-signin-heading">ID</h2>
					<?php echo $item['id'] ?>
					<li><h3 class="form-signin-heading">Summary</h2>
					<?php echo $item['summary'] ?>
					<li><h3 class="form-signin-heading">Description</h2>
					<?php echo $item['description'] ?>
					<li><h3 class="form-signin-heading">Condition</h2>
					<?php echo $item['cond'] ?>
					<li><h3 class="form-signin-heading">Price</h2>
					<?php echo $item['price'] ?>
					<li><h3 class="form-signin-heading">Date</h2>
					<?php echo $item['date_listed'] ?>
					</ul>
					</div>
				</td>
			</tr>
		</table>
	 <?php } ?> 

<?php
  include('footer.php');
?>
