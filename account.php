<?php
	include('header.php');

  echo "test1";

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
        <h2 class="form-signin-heading">Create account</h2>
        <input type="text" name="username" class="form-control" placeholder="Username" required autofocus>
        <input type="password" name="password" class="form-control" placeholder="Password" required>
		<input type="password" name="retype-password" class="form-control" placeholder="Retype Password" required>
		<input type="email" name="email" class="form-control" placeholder="Email Address" required>
		<input type="text" name="contact-number" class="form-control" placeholder="Contact Number" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Create account</button>
      </form>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>
