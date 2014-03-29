<?php
include('common.php');

$page_title = 'CS2102 Classfieds - Sign In';
$extra_head = <<<EOT
<style type="text/css">
  body {
    padding-top: 50px;
    padding-bottom: 30px;
  }
</style>
EOT;
include('header.php');
?>

<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
	<div class="container">
		<div class="col-md-4">
			<h1>Hot Items</h1>
			<p>Check out these popular items</p>
		</div>
		<?php if ($hotItemsStmt = $conn->prepare('
SELECT i.title, i.photo, i.id, COUNT(v.item_id) as count FROM item i, views v WHERE i.id = v.item_id GROUP BY v.item_id ORDER BY count DESC LIMIT 0, 4
			')) {
					//$relatedItemsStmt->bind_param('is', $item['id'], $_SESSION['username']);
					$hotItemsStmt->execute();
					$hotItemsRes = $hotItemsStmt->get_result();
					while($hotItem = $hotItemsRes ->fetch_assoc()){
						$itemphoto='img/noimg.jpg';
						if($hotItem['photo']!= NULL) 
							$itemphoto='content/item/'.$hotItem['photo'];
						?>
						<div class="col-md-2">
							<a href="view_item.php?id=<?= $hotItem['id']; ?>" title="<?= $hotItem['count']; ?> other user<?= $relItem['count'] > 1 ? 's' : '' ?> viewed this item">
								<div><img src="<?= $itemphoto; ?>" style="max-width:150px;max-height:200px;"></div>
								<div style="text-align:center;"><?= $hotItem['title']; ?></div>
							</a>
						</div>							
						<?php
					}
				}
				//var_dump ($conn->error);
			?>
		<div class="col-md-2">
			
		</div>
	</div>
</div>

<div class="container">
	<!-- Example row of columns -->
	<div class="row">
		<h2>Latest Items</h2>
		<?php if ($latestItemsStmt = $conn->prepare('SELECT * FROM item i ORDER BY date_listed DESC LIMIT 0, 6')) {
				//$relatedItemsStmt->bind_param('is', $item['id'], $_SESSION['username']);
				$latestItemsStmt->execute();
				$latestItemsRes = $latestItemsStmt->get_result();
				while($latestItem = $latestItemsRes ->fetch_assoc()){
					$itemphoto='img/noimg.jpg';
					if($latestItem['photo']!= NULL) 
						$itemphoto='content/item/'.$latestItem['photo'];
					?>
					<div class="col-md-4">
						<h3><?= $latestItem['title']; ?></h3>
						<p><img src="<?= $itemphoto; ?>" style="max-width:200px;max-height:200px;"></p>
						<p><?= $latestItem['summary']; ?></p>
						<p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
					</div>							
					<?php
				}
			}
			//var_dump ($conn->error);
		?>
		<div class="col-md-4">
			<h3>Heading</h3>
			<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
			<p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
		</div>
		<div class="col-md-4">
			<h3>Heading</h3>
			<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
			<p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
		</div>
		<div class="col-md-4">
			<h3>Heading</h3>
			<p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
			<p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
		</div>
	</div> <!-- /container -->

	<?php
include('footer.php');
	?>
