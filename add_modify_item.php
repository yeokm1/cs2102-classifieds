<?php
include('header.php');

       //if edit item
if (isset($_GET['id'])){

  if ($stmt = $conn->prepare("SELECT * FROM item WHERE id = ?")) {
    $stmt->bind_param('i', $_GET['id']);
    $stmt->execute();
    $res = $stmt->get_result();
    $item = $res->fetch_assoc();


  }

}

//if fields are set
else if (isset($_POST['title']) && isset($_POST['summary']) && isset($_POST['description']) && isset($_POST['condition']) && isset($_POST['price']) ){

  if($_POST['condition'] == "invalid"){

    $message = "Please set the condition of the item";
    echo "<script type='text/javascript'>alert('$message');</script>";
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
  <link href="css/bootstrap-responsive.css" rel="stylesheet">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>CS2102 Classifieds</title>

  <!-- Bootstrap core CSS -->
  <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/dashboard.css" rel="stylesheet">

  <!-- Just for debugging purposes. Don't actually copy this line! -->
  <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
    </head>

    <body>

      <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">CS2102 Classifieds</a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
              <li><a href="#">Dashboard</a></li>
              <li><a href="#">Settings</a></li>
              <li><a href="#">Profile</a></li>
              <li><a href="#">Help</a></li>
            </ul>
            <form class="navbar-form navbar-right">
              <input type="text" class="form-control" placeholder="Search...">
            </form>
          </div>
        </div>
      </div>

      <div class="container-fluid">

        <div class="row">
          <h1>Add/Edit Post</h1>
        </div>

        <div class="row">
         <form class="form-signin" role="form" action="add_modify_item.php" method="post">
          <h2 class="form-signin-heading">Title</h2>
          <input type="text" name = "title" class="form-control" placeholder="Title" required autofocus value="<?php echo (isset($item)? $item['title'] : ''); ?>">
          <h2 class="form-signin-heading">Summary</h2>
          <input type="text" name = "summary" class="form-control" placeholder="Summary" required value="<?php echo (isset($item)? $item['summary'] : ''); ?>">
          <h2 class="form-signin-heading">Description</h2>
          <input type="text" name = "description" class="form-control" placeholder="Description" required value="<?php echo (isset($item)? $item['description'] : ''); ?>">

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

            </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>


  </body>


  </html>
