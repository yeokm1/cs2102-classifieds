<?php
include('common.php');

//get list of all categories
 if ($stmt = $conn->prepare("SELECT * FROM category")) {
    $stmt->execute();
    $res = $stmt->get_result();
   // $cat_temp = $res->fetch_assoc();
   
      $x = 0;

          while ( $cat_temp = $res->fetch_assoc()) {
                  $categories[$x] =  (string) $cat_temp['name'];
              print_r($cat_temp);
              $x++;
          }
  }

       //if edit item
if (isset($_GET['id'])){

  if ($stmt = $conn->prepare("SELECT * FROM item WHERE id = ?")) {
    $stmt->bind_param('i', $_GET['id']);
    $stmt->execute();
    $res = $stmt->get_result();
    $item = $res->fetch_assoc();

       if ($stmt = $conn->prepare("SELECT cat_name FROM tagged WHERE item_id = ?")) {
      $stmt->bind_param('i', $_GET['id']);
      $stmt->execute();
      $res = $stmt->get_result();
     
      $x = 0;

          while ( $tags = $res->fetch_assoc()) {
              $all_tags[$x] =  (string) $tags['cat_name'];
              print_r($tags);
              $x++;
          }
      }
       echo $conn->error;

  }

}

//if fields are set
else if (isset($_POST['title']) && isset($_POST['summary']) && isset($_POST['description']) && isset($_POST['condition']) && isset($_POST['price']) ){

  if($_POST['condition'] == "invalid"){

    $message = "Please set the condition of the item";
    echo "<script type='text/javascript'>alert('$message');</script>";
       //repopulate
       $item = array("title"=>$_POST['title'],
                    "summary"=>$_POST['summary'],
                    "description"=>$_POST['description'],
                    "cond"=>$_POST['condition'],
                    "price"=>$_POST['price']
        );
  }
//if price is invalid field
  else if(isSet($_POST['price'])){
    if(!is_numeric($_POST['price'])){
      $message = "Price is invalid, only numbers are allowed. E.g 5.50";
       echo "<script type='text/javascript'>alert('$message');</script>";
       //repopulate
       $item = array("title"=>$_POST['title'],
                    "summary"=>$_POST['summary'],
                    "description"=>$_POST['description'],
                    "cond"=>$_POST['condition'],
                    "price"=>$_POST['price']
        );

    }
  }
  else if(!isSet($_POST['item_id'])){
    if ($stmt = $conn->prepare("INSERT INTO item (user, title, summary, description, cond, price) VALUES (?, ?, ?, ?, ?, ?)")) {

      $stmt->bind_param('sssssd', $_SESSION["username"], $_POST['title'], $_POST['summary'], $_POST['description'], $_POST['condition'], $_POST['price']);
      $stmt->execute();
      echo $conn->error;
      $message = "Your entry has been posted";
      echo "<script type='text/javascript'>alert('$message');</script>";
    }
  }
  else if(isSet($_POST['item_id'])){
    if ($stmt = $conn->prepare("UPDATE item set title = ?, summary = ?, description = ?, cond =?, price = ? where id = ? and user = ?")) {

      $stmt->bind_param('ssssdis', $_POST['title'], $_POST['summary'], $_POST['description'], $_POST['condition'], $_POST['price'], $_POST['item_id'], $_SESSION["username"] );
      $stmt->execute();
      echo $conn->error;
      $message = "Your post has been updated";
      echo "<script type='text/javascript'>alert('$message');</script>";

    }

  }

}

$page_title = 'CS2102 Classifieds - Add/Edit Item';
include('header.php');
?>

      <div class="container">

          <h1>Add/Edit Item</h1>


         <form class="form-signin" role="form" action="add_modify_item.php" method="post">
          <h2 class="form-signin-heading">Title</h2>
          <input type="text" name = "title" class="form-control" placeholder="Title" required autofocus value="<?php echo (isset($item)? $item['title'] : ''); ?>">
          <h2 class="form-signin-heading">Photo</h2>
          <img src="img/noimg.jpg" alt="">
          <h2 class="form-signin-heading">Select a file:</h2>
          <input type="file" name="img"> 
          <h2 class="form-signin-heading">Summary</h2>
          <input type="text" name = "summary" class="form-control" placeholder="Summary" required value="<?php echo (isset($item)? $item['summary'] : ''); ?>">
          <h2 class="form-signin-heading">Description</h2>
          <input type="text" name = "description" class="form-control" placeholder="Description" required value="<?php echo (isset($item)? $item['description'] : ''); ?>">


          <h2 class="form-signin-heading">Description</h2>

          <?php for($x = 0; $x < count($categories); $x++) { ?>
          <input type="checkbox" name= "ticked_categories" value= "<?php echo $categories[$x]?>"> <?php echo $categories[$x] ?> <br>

          <?php } ?>


          <h2 class="form-signin-heading">Condition</h2>
          <input type="text" name = "condition" class="form-control" placeholder="Condition of item" required value="<?php echo (isset($item)? $item['cond'] : ''); ?>" >

<!--
                  <div class="control-group">
                      <label class="control-label" for="inputModuleCode">Condition of Item</label>
                      <div class="controls">
                        <select id="inputModuleCode" name = "condition">
                          <option id="option" value = "invalid" >Select item</option>
                          <option id="option1" value = "Brand new" <?php echo (isset($item) && $item['cond']=='Brand new' ? 'selected' : ''); ?> >Brand new</option>
                          <option id="option2" value = "Excellent" <?php echo (isset($item) && $item['cond']=='Excellent' ? 'selected' : ''); ?> >Excellent</option>
                          <option id="option3" value = "Good" <?php echo (isset($item) && $item['cond']=='Good' ? 'selected' : ''); ?> >Good</option>
                          <option id="option4" value = "Decent" <?php echo (isset($item) && $item['cond']=='Decent' ? 'selected' : ''); ?> >Decent</option>
                          <option id="option5" value = "Slightly Screwed"  <?php echo (isset($item) && $item['cond']=='Slightly Screwed' ? 'selected' : ''); ?> >Slightly screwed</option>
                          <option id="option6" value = "Screwed"  <?php echo (isset($item) && $item['cond']=='invalid' ? 'selected' : ''); ?> >Screwed </option>
                        </select>                   
                      </div>
                    </div>
                  -->
                  <h2 class="form-signin-heading">Price</h2>
                  <input type="text" name = "price" class="form-control" placeholder="Price" required value="<?php echo (isset($item)? $item['price'] : ''); ?>">
                  <br></br>

                  <?php
                  if(isset($item)){
                    ?>
                    <input type = "submit" class="btn btn-primary pull-left" type="button" id="post_btn" value="Edit"/>
                    <input type="hidden" name = "item_id" class="form-control" value="<?php echo $item['id']; ?>">
                    <?php
                  }
                  else{
                    ?>
                    <input type = "submit" class="btn btn-primary pull-left" type="button" id="edit_btn" value="Post"/>
                    <?php
                  }
                  ?>

                </form>

                <br></br>
                <br></br>
                <br></br>

		</div>
			
<?php

include('footer.php');

?>
