<?php
	include('header.php');

  echo "test1";

  if (isset($_POST['edit-mode'])){
    if ($_POST['username'] == $_SESSION['username']){
      $stmt = null;
      echo 1;
      if (trim($_POST['password']) != '' && $_POST['password'] == $_POST['retype-password']){
        echo 2;

        $stmt = $conn->prepare("UPDATE user SET email = ?, password = ?, phone = ? WHERE username = ?");
        $stmt->bind_param('ssss', $_POST['email'], $_POST['password'], $_POST['contact-number'], $_SESSION['username']);
        $stmt->execute();
        if ($conn->error) echo $conn->error;
      }else{
        $stmt = $conn->prepare("UPDATE user SET email = ?,  phone = ? WHERE username = ?");
        $stmt->bind_param('sss', $_POST['email'], $_POST['contact-number'], $_SESSION['username']);
        $stmt->execute();
        if ($conn->error) echo $conn->error;
      }
    }
  }else{

    if (isset($_POST['username'])){
      echo "test2";

      if ($_POST['password'] != $_POST['retype-password']){
        echo "test3";
        $err = 'Passwords do not match';
      }else{
        echo "test4";
        if ($stmt = $conn->prepare("INSERT INTO user (email, username, password, phone) VALUES (?, ?, ?, ?)")) {
          $stmt->bind_param('ssss', $_POST['email'], $_POST['username'], $_POST['password'], $_POST['contact-number']);
          $stmt->execute();
        }
      }
    }

  }

  $editMode = false;

  if (isset($_SESSION['username'])){
    echo "{$_SESSION['username']} is logged in";

    if ($stmt = $conn->prepare("SELECT * FROM user WHERE username = ?")) {
      $stmt->bind_param('s', $_SESSION['username']);
      $stmt->execute();
      $res = $stmt->get_result();
      if ($res->num_rows >= 1) {
        $editMode = true;

        $row = $res->fetch_assoc();
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
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Create account</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">

      <?php
        if (isset($err)){
          echo $err;
        }
      ?>

      <form class="form-signin" role="form" action="account.php" method="post">
        <h2 class="form-signin-heading">
          <?php
            if ($editMode) {
              echo 'Edit account';
              echo '<input type="hidden" name="edit-mode">';
            }else{
              echo 'Create account';
            }
          ?>
        </h2>
        <input type="text" name="username" class="form-control form-first-item" placeholder="Username" <?= $editMode? 'readonly' : '' ?> value="<?= $editMode ? $row['username'] : ''; ?>" required autofocus>
        <input type="password" name="password" class="form-control" placeholder="Password" <?= $editMode ? '' : 'required' ?>>
        <input type="password" name="retype-password" class="form-control" placeholder="Retype Password" <?= $editMode ? '' : 'required' ?>>
        <input type="email" name="email" class="form-control" placeholder="Email Address" value="<?= $editMode ? $row['email'] : ''; ?>" required>
        <input type="text" name="contact-number" class="form-control form-last-item" placeholder="Contact Number" value="<?= $editMode ? $row['phone'] : ''; ?>" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">
          <?php
            if ($editMode) {
              echo 'Edit account';
            }else{
              echo 'Create account';
            }            
          ?>
        </button>
      </form>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>
