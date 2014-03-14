<?php

include('common.php');

if (isset($_POST['username'])){
  if ($stmt = $conn->prepare("SELECT * FROM user WHERE username = ? AND password = ?")) {
    $stmt->bind_param('ss', $_POST['username'], $_POST['password']);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res -> num_rows > 0) {
      $_SESSION['username'] = $_POST['username'];

      $row = $res->fetch_assoc();
      $_SESSION['role'] = $row['role'];
      $msg = 'You have logged in!';

      $host  = $_SERVER['HTTP_HOST'];
      $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
      $extra = 'index.php';
      header("Location: http://$host$uri/$extra");

    }else{
      $msg = '<div class="alert alert-danger">Invalid Username or Password</div>';
    }
  }
}

$page_title = 'CS2102 Classfieds - Sign In';
$extra_head = <<<EOT
<link href="css/signin.css" rel="stylesheet">
EOT;

include('header.php');

?>

<div class="container">

  <form class="form-signin" role="form" method="post" action="signin.php">
    <h2 class="form-signin-heading">Please sign in</h2>
    <input type="username" name="username" class="form-control form-first-item" placeholder="Username" required autofocus>
    <input type="password" name="password" class="form-control form-last-item" placeholder="Password" required>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>

    <br/>
    <?php
    if (isset ($msg)){
      echo $msg;
    }
    ?>
  </form>

</div> <!-- /container -->


<?php
include('footer.php');
?>
