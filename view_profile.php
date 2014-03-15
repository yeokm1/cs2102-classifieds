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
    <h1>Invalid username:  <?php echo $_GET['username'] ?></h1>
  <?php
    }else{
  ?>

  <div class="pull-right"><a href="account.php" class="btn btn-default" role="button" style="margin-top:20px;">Edit Profile</a></div>
  
  <h1>User: <?= $user['username'] ?></h1>  
  

  <div class="row" style="margin-top:20px;">
    <div class="col-md-4">
      <img src="content/profile/<?= $user['photo'] ?>" style="width:100%;margin-top:30px;">
    </div>
    <div class="col-md-3">
      <h3>User Info</h3>
      <dl>
        <dt>Gender</dt>
        <dl><?= $user['gender'] ?></dl>
        <dt>Email</dt>
        <dl><?= $user['email'] ?></dl>
        <dt>Contact No</dt>
        <dl><?= $user['phone'] ?></dl>
      </dl>
    </div>
    <div class="col-md-5">
      <h3>Item(s) Posted</h3>

      <?php if(isset($user_error)) { ?>
        <p>Nothing!</p>
      <?php } ?>
        <dl>
          <?php
            while($item=$user_res ->fetch_assoc()){
          ?>
          <dt><a href="view_item.php?id=<?php echo $item['id'] ?>">
          <?php echo $item['title'] ?></a></dt>	
          <dl><?= $item['summary'] ?></dl>
          <?php
            }	
          ?>
        </dl>
      
      </div>
    </div>
  
  <?php
  }
  ?>
  
</div>

<?php
include('footer.php');
?>