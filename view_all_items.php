<?php
	include('common.php');

	$sql="SELECT i.id, i.user, i.title, i.summary, i.description, i.photo, i.cond, i.price, i.date_listed ";
	$sql=$sql."FROM item i";
	
	if(isset($_GET['cat']) && $_GET['cat']!=""){
		$catname=$_GET['cat'];
		$sql=$sql.", tagged t";
		$sql=$sql." WHERE t.cat_name='".$catname."'";
		$sql=$sql." AND t.item_id=i.id";
		
	}
	
	$sql=$sql." ORDER BY ";
	if(isset($_GET['orderby']) && $_GET['orderby']!=""){
		$orderby=$_GET['orderby'];
		$sql=$sql." i.".$orderby." ";
	}
	else{
		$sql=$sql." i.date_listed ";
		$sql=$sql." DESC ";
	}
	
	if(isset($_GET['order']) && $_GET['order']!=""){
		$order=$_GET['order'];
		if($order=="DESC")
		$sql=$sql.$order;
	}

	
	//echo($sql);

	if($stmt = $conn->prepare($sql) ){
		$stmt->execute();
		$res = $stmt->get_result();
	}
	
	if(!isset($res)){
		$error = 'ErrorSQL';
	}
	else if ($res -> num_rows == 0) {
		$error = 'NoItemPosted';
	}	
	
$extra_head = <<<EOT
  <style>
  .row{
    margin-top:20px;
    margin-bottom:20px;
  }
  </style>
EOT;
$page_title = 'CS2102 Classfieds - All Items';
include('header.php');

?>
	
	<div class="container">
	<h1>All listed items</h1>
					
		<?php
        if (isset($error) && $error == "NoItemPosted"){
		?>
			<p>No items posted yet!</p>
            <p>Click <a href="add_modify_item.php">here</a> to start.</p>
		<?php
        }else if(isset($error) && $error == "ErrorSQL"){
		?>
			<p>Error URL</p>
			<p>Click <a href="view_all_items.php">here</a> to view all items!</p>
	<?php
	    }else{
     ?>
        <div class="row">
            <form name="form" method="GET" action="view_all_items.php">
                <div class="col-md-6">
                    <b>Sort By:</b>						
                    <!--ORDER BY-->
                    <select name="orderby" style="width:200px;display:inline-block" class="form-control">
                    <?php 

                        $orderby='';;
                        $sel="selected";

                        if(isset($_GET['orderby'])){ 
                            $orderby=$_GET['orderby'];
                        } ?>

                        <option value="date_listed" <?php if (($orderby === 'date_listed') OR ($orderby === '')) echo $sel; ?>>Date Listed</option>
                        <option value="title" <?php if ($orderby === 'title') echo $sel; ?>>Title</option>
                        <option value="price" <?php if ($orderby === 'price') echo $sel; ?>>Price</option>
                        <option value="cond" <?php if ($orderby === 'cond') echo $sel; ?>>Condition</option>
                    </select>

                    <!--ORDER -->
                    <select name="order" style="width:200px;display:inline-block" class="form-control">
                    <?php 
                        $order=$_GET['order'];
                        $sel="selected";
                        if(isset($_GET['order'])){ 
                            $order=$_GET['order'];
                            $sel="selected";
                        } ?>
                        <option value="DESC" <?php if (($order === 'DESC') OR ($order === '')) echo $sel; ?>>Descending</option>
                        <option value="ASC" <?php if ($order === 'ASC') echo $sel; ?>>Ascending</option>						
                    </select>
                </div>
                <div class="col-md-4">
                    <b>Filter Category:</b>
                    <!--FILTER BY CATEGORY-->
                    <select name="cat" style="width:200px;display:inline-block"  class="form-control">
                        <?php 
                        $catname="";
                        $sel="selected";

                        if(isset($_GET['cat'])){
                            $catname=$_GET['cat'];
                        } ?>
                            <?php

                        if ($allCatStmt = $conn->prepare("SELECT * FROM category")) {

                            $allCatStmt->execute();
                            $allCatRes = $allCatStmt->get_result();
                                ?>
                            <option value="" <?php if($catname == "") echo $sel ?>> -- View All --</option>			
                          <?php while($cat=$allCatRes->fetch_assoc()){

                                ?>
                                <option value="<?php echo $cat['name']?>" 
                                    <?php if($cat['name'] == $catname) echo $sel?>>
                                    <?php echo $cat['name']?></option>
                            <?php 
                              }

                          }	?>

                    </select>
                </div>
                <div class="col-md-2">
						
                    <button class="btn btn-primary" type="submit">Go</button>
                    <a href="?" class="btn btn-primary">Reset</a>
                </div>
            </form>
        </div>

        <?php	    
            while($item=$res ->fetch_assoc()){		
		?>
        <div class="row">
        <div class="col-md-3">
        <?php 
			$itemphoto='img/noimg.jpg';
			if($item['photo']!= NULL) 
				$itemphoto=$item['photo']; ?>
			
			<!--PUT IMAGE HERE-HIDDEN UNLESS NOT NULL-->
			<a href="view_item.php?id=<?php echo $item['id'] ?>" title="Click to find out more!"><img src="<?php echo $itemphoto ?>" class="img-thumbnail" style="max-width:200px"></a>
        </div>
        <div class="col-md-9">
            <h2><a href="view_item.php?id=<?php echo $item['id'] ?>" title="Click to find out more!"><?php echo $item['title'] ?></a></h2>
            <p>
				<ul>
				    <li>
                        <b>Date Listed:</b>
                        <?php echo $item['date_listed'] ?>
                    </li>
				    <li>
                        <b>Posted by:</b>
				        <a href="view_profile.php?username=<?php echo $item['user'] ?>"><?php echo $item['user'] ?></a></li>
				    <li>
                        <b>Summary:</b>
                        <?php echo $item['summary'] ?>
                    </li>
				    <li>
                        <b>Price:</b>
                        <?php echo $item['price'] ?>
                    </li>
                    <li>
                        <b>Condition:</b>
                        <?php echo $item['cond'] ?>
                    </li>
                    <li>
                        <b>Categories:</b> 
                        <?php 
                            if ($itemCatStmt = $conn->prepare("SELECT cat_name FROM tagged WHERE item_id = ?")) {
                                $itemCatStmt->bind_param('i', $item['id']);
                                $itemCatStmt->execute();
                                $itemCatRes = $itemCatStmt->get_result();
                                $itemCatAll= array();
                                while($cat=$itemCatRes ->fetch_assoc()){
                                    $itemCatAll[] = '<a href="view_all_items.php?cat='.$cat['cat_name'].'">'.$cat['cat_name'].'</a>';  
                                }
                            }
                            echo (implode (", " , $itemCatAll ));?>
                    </li>		
				</ul>
            </div>
        </div>
        <?php
	   }	
        ?>

	
	  
    <?php
    }	
    ?>
	 
<?php
  include('footer.php');
?>