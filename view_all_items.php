<?php
	include('common.php');

	if ($stmt = $conn->prepare("SELECT * FROM item ORDER BY id DESC")) {
		$stmt->execute();
		$res = $stmt->get_result();
		if ($res -> num_rows == 0) {
			$error = 'NoItemPosted';
			}
		}
	
$page_title = 'CS2102 Classfieds - All Items';
include('header.php');

?>
	
	<div class="container">
	<table class="table table-striped">
		 <thead>
			<tr>
				<th colspan="2"> <div class="container-fluid ">
					<h1>All listed items</h1>
				</th>
			</tr>
		</thead>
			
			
		<?php
        if (isset($error) && $error == "NoItemPosted"){
		?>
		<tr>
			<td>
		<div class="container-fluid ">
			<p>No items posted yet!
			<p>Click <a href="add_modify_item.php">here</a> to start!
		
		</div>
		</td>
		</tr>
		</table>
	<?php
	    }
		else{
     ?>
	  
      <?php
	    
		while($item=$res ->fetch_assoc()){
		
		?>
		<tr>
			<?php if($item['photo']!= NULL) { ?>
			<td style="padding-top:50px;" width="30%">
				<center>
				
				<!--PUT IMAGE HERE-HIDDEN UNLESS NOT NULL-->
				<img src="<?php echo $item['photo'] ?>" style="max-width:100%,vertical-align:top;padding-top:20px;">
				
				</center>
			</td>
							<?php } ?> 
		
			<td style="padding-left:50px;"><h2><a href="view_item.php?id=<?php echo $item['id'] ?>"><?php echo $item['title'] ?></a></h2>
				<p>
				<ul>
				<li><b>ID:</b> <?php echo $item['id'] ?>
				<li><b>Summary:</b> <?php echo $item['summary'] ?>
				<li><b>Date Listed:</b> <?php echo $item['date_listed'] ?>

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
        if (isset($error) && $error == "NoItemPosted"){
    ?>
		<div class="container-fluid ">
			<p>No items posted yet!
			<p>Click <a href="add_modify_item.php">here</a> to start!
		
		</div>
	  
	<?php
	    }
		else{
     ?>
      <div class="container-fluid ">
		
		
		<?php
	    
		while($item=$res ->fetch_assoc()){
		
		?>
		<li><h2><a href="view_item.php?id=<?php echo $item['id'] ?>"><?php echo $item['title'] ?></a></h2>
			<p>
			<ul>
			<li><b>ID:</b> <?php echo $item['id'] ?>
			<li><b>Summary:</b> <?php echo $item['summary'] ?>
			<li><b>Date Listed:</b> <?php echo $item['date_listed'] ?>

			</ul>
			<hr />
		
		<?php
		}	
		?>
		
		</ul>
      </div>


	
	<?php
 		}
     ?>
	 
<?php
  include('footer.php');
?>
