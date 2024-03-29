<?php
  
    include('common.php');

  function handleEdit(){
    global $conn;
    
	if(isset($_POST['delete']) && $_SESSION['role'] == "admin") {
		if(isset($_POST['username'])) {
			if ($stmt = $conn->prepare("DELETE FROM user WHERE username = ?")) {
				$stmt->bind_param('s', $_POST['username']);
				$stmt->execute();
			} else {
				$err = 'An error occurred';
			}
		}
	} else if ($_POST['username'] == $_SESSION['username'] || $_SESSION['role'] == "admin"){
      $stmt = null;
      
      //print_r($_POST);
      //print_r($_FILES);
      
      // Process photo uploads
      if (isset($_FILES['photo']) && $_FILES['photo']['name'] != ''){
        include_once('imageUploadHandler.php');
        try{
          $photo_path = processUpload('photo', 'content/profile/');
        }catch(Exception $e) {
          $err = 'An error occurred<br>' . $e->getMessage();
          throw new Exception($err);
        }
      }
      
      // Process password
      if (trim($_POST['password']) != ''){
        if ($_POST['password'] == $_POST['retype-password']){          
          $new_password = $_POST['password'];
        }else{
          $err = 'Passwords do not match';
          throw new Exception($err);
        }
      }
      
      $bindParam = new BindParam();
      
      $build_stmt = 'UPDATE user SET email = ?, phone = ?, gender = ? ';
      $bindParam->add('s', $_POST['email']);
      $bindParam->add('s', $_POST['contact-number']);
	  $bindParam->add('s', $_POST['gender']);
      
      if (isset($new_password)){
        $build_stmt .=  ', password = ?';
        $bindParam->add('s', $new_password);
      }
      
      if (isset($photo_path)){
        $build_stmt .= ', photo = ?';
        $bindParam->add('s', $photo_path);
      }
      

      $build_stmt .= ' WHERE username = ?';
      $bindParam->add('s', $_POST['username']);
      
      $stmt = $conn->prepare($build_stmt);
      echo $conn->error;
      call_user_func_array(array($stmt, 'bind_param'), $bindParam->getRef()); 
          
      if ($stmt->execute()){
        $msg = 'Update successful!';
      }else{
        $err = 'An error occurred<br>' . $conn->error;
        throw new Exception($err);
      }
      
      return $msg;        
    
    }else{
      $err = 'Invalid user';
      throw new Exception($err); 
    }
  }
  
  // Account editing mode
  if (isset($_POST['edit-mode'])){
    try{
      $msg = handleEdit();
    }catch(Exception $e){
      $err = $e->getMessage();
    }
    
  }else{
    
    // Account creation mode
    if (isset($_POST['username'])){

      if ($_POST['password'] != $_POST['retype-password']){
        $err = 'Passwords do not match';
      }else{
        
        if ($stmt = $conn->prepare("INSERT INTO user (email, username, password, gender, phone) VALUES (?, ?, ?, ?, ?)")) {
          $stmt->bind_param('sssss', $_POST['email'], $_POST['username'], $_POST['password'], $_POST['gender'], $_POST['contact-number']);
          if ($stmt->execute()){
            $msg = 'Account created successfully! You may now <a href="signin.php">sign in</a>.';
          }else{
            $err = 'An error occurred<br>' . $conn->error;
          }
        }
      }
    }

  }

  $editMode = false;

   if (isset($_REQUEST['add']) && $_SESSION['role'] == "admin") {
		//admin wants to add a user
		//nothing to do here :)
   }else if(isset($_POST['username'])) {
    if($stmt = $conn->prepare("SELECT * FROM user WHERE username = ?")) {
      $stmt->bind_param('s', $_POST['username']);
      $stmt->execute();
      $res = $stmt->get_result();

      if($res->num_rows == 1) {
        $editMode = true;
        $row = $res->fetch_assoc();
      } #else ignored
    }
  } else if(isset($_GET['id'])) {
    if($stmt = $conn->prepare("SELECT * FROM user WHERE username = ?")) {
      $stmt->bind_param('s', $_GET['id']);
      $stmt->execute();
      $res = $stmt->get_result();

      if($res->num_rows == 1) {
        $editMode = true;
        $row = $res->fetch_assoc();
      } #else ignored
    }
  } else if (isset($_SESSION['username'])){
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



      <form class="form-signin" role="form" enctype="multipart/form-data" action="account.php" method="post">

        

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

        <label>Username: </label><input type="text" name="username" class="form-control form-first-item" placeholder="Username" <?= $editMode? 'readonly' : '' ?> value="<?= $editMode ? $row['username'] : ''; ?>" required autofocus>
        <label>Password: </label><input type="password" name="password" class="form-control" placeholder="Password" <?= $editMode ? '' : 'required' ?>>
        <label>Retype password: </label><input type="password" name="retype-password" class="form-control" placeholder="Retype Password" <?= $editMode ? '' : 'required' ?>>
        <label>Email: </label><input type="email" name="email" class="form-control" placeholder="Email Address" value="<?= $editMode ? $row['email'] : ''; ?>" required>
		<label>Gender: </label><input type="text" name="gender" class="form-control" placeholder="Gender" value="<?= $editMode ? $row['gender'] : ''; ?>" required>
        <label>Phone: </label><input type="text" name="contact-number" class="form-control form-last-item" placeholder="Contact Number" value="<?= $editMode ? $row['phone'] : ''; ?>" required>
        <?php if ($editMode && $row['photo'] != '') { ?>
          <img src="<?= 'content/profile/'.$row['photo']; ?>" width="300">
        <?php } ?>
        <?php if ($editMode) { ?>
          <label>Image: </label><input type="file" name="photo" class="form-control form-last-item" placeholder="Photo">
        <?php } ?>
        <button class="btn btn-lg btn-primary btn-block" type="submit">
          <?php
            if ($editMode) {
              echo 'Edit account';
            }else{
              echo 'Create account';
            }            
          ?>
        </button>
		<?php if($editMode && $_SESSION['role'] == "admin") { ?>
		<button class="btn btn-lg btn-danger btn-block" type="submit" name="delete">Delete</button>
		<?php } ?>
      </form>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>
