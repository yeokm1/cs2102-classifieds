<?php
  include('common.php');
  
  // Account editing mode
  if (isset($_POST['edit-mode'])){
    if ($_POST['username'] == $_SESSION['username']){
      $stmt = null;
      if (trim($_POST['password']) != ''){
        if ($_POST['password'] == $_POST['retype-password']){
          $stmt = $conn->prepare("UPDATE user SET email = ?, password = ?, phone = ? WHERE username = ?");
          $stmt->bind_param('ssss', $_POST['email'], $_POST['password'], $_POST['contact-number'], $_SESSION['username']);
          
          if ($stmt->execute()){
            $msg = 'Update successful!';
          }else{
            $err = 'An error occurred';
          }
          if ($conn->error)  $err = $conn->error;
        }else{
          $err = 'Passwords do not match';
        }
      }else{
        $stmt = $conn->prepare("UPDATE user SET email = ?,  phone = ? WHERE username = ?");
        $stmt->bind_param('sss', $_POST['email'], $_POST['contact-number'], $_SESSION['username']);
        if ($stmt->execute()){
          $msg = 'Update successful!';
        }else{
          $err = 'An error occurred';
        }
        if ($conn->error)  $err = $conn->error;
      }
    }
    
  }else{
    
    // Account creation mode
    if (isset($_POST['username'])){

      if ($_POST['password'] != $_POST['retype-password']){
        $err = 'Passwords do not match';
      }else{
        if ($stmt = $conn->prepare("INSERT INTO user (email, username, password, phone) VALUES (?, ?, ?, ?)")) {
          $stmt->bind_param('ssss', $_POST['email'], $_POST['username'], $_POST['password'], $_POST['contact-number']);
          if ($stmt->execute()){
            $msg = 'Update successful!';
          }else{
            $err = 'An error occurred';
          }
        }
      }
    }

  }

  $editMode = false;

  if (isset($_SESSION['username'])){
    // User is logged in
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

$extra_head = <<<EOT
  <link href="css/signin.css" rel="stylesheet">
EOT;
  include('header.php');

?>

    <div class="container">



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

<?php
        if (isset($err)){
          echo "<div class=\"alert alert-danger\">$err</div>";
        }
        ?>
        <?php
        if (isset ($msg)){
          echo "<div class=\"alert alert-success\">$msg</div>";
        }
        ?>

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
