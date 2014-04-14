<?php
include('common.php');

$page_title = 'CS2102 Classfieds - Home';
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
								<div style="text-align:center;width:150px;height:200px"><img src="<?= $itemphoto; ?>" style="max-width:150px;"></div>
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
					<div class="col-md-2">
						<h4><?= $latestItem['title']; ?></h4>
						<div style="text-align:center;width:150px;height:200px"><img src="<?= $itemphoto; ?>" style="max-width:150px"></div>
						<p><?= $latestItem['summary']; ?></p>
						<p><a class="btn btn-default" href="view_item.php?id=<?= $latestItem['id'] ?>" role="button">View details &raquo;</a></p>
					</div>							
					<?php
				}
			}
			//var_dump ($conn->error);
		?>
	</div> <!-- /container -->
	
	<?php
	if (isset($_SESSION['username'])){
	?>
	<div class="row">
		<h2>Recently Viewed Items</h2>
		<?php if ($recentItemsStmt = $conn->prepare('SELECT i.title, i.photo, i.id, i.summary FROM item i, views v WHERE v.user_id = ? AND i.id = v.item_id ORDER BY v.view_date LIMIT 0, 6')) {
				$recentItemsStmt->bind_param('s', $_SESSION['username']);
				$recentItemsStmt->execute();
				$recentItemsRes = $recentItemsStmt->get_result();
				while($recentItem = $recentItemsRes ->fetch_assoc()){
					$itemphoto='img/noimg.jpg';
					if($recentItem['photo']!= NULL) 
						$itemphoto='content/item/'.$recentItem['photo'];
					?>
					<div class="col-md-2">
						<h4><?= $recentItem['title']; ?></h4>
						<p><img src="<?= $itemphoto; ?>" style="max-width:150px;max-height:200px;"></p>
						<p><?= $recentItem['summary']; ?></p>
						<p><a class="btn btn-default" href="view_item.php?id=<?= $recentItem['id'] ?>" role="button">View details &raquo;</a></p>
					</div>							
					<?php
				}
			}
		?>		
	</div> <!-- /container -->
	<?php
	}
	?>

	<?php
include('footer.php');
	?>
