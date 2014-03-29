<?php 
include_once("model/Item.php");
include_once("model/Category.php");
include_once("model/User.php");
$extra_head = ' <link href="css/dashboard.css" rel="stylesheet">';
$page_title = "CS2102 Admin Panel";
include("header.php");

?>


      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
             <li <?php if($mode=="summary") echo 'class="active"'; ?>><a href="admin.php?action=summary">Summary</a></li>
             <li <?php if($mode=="classifieds") echo 'class="active"'; ?>><a href="admin.php?action=classifieds">All Classifieds</a></li>
             <li <?php if($mode=="categories") echo 'class="active"'; ?>><a href="admin.php?action=categories">All Categories</a></li>
             <li <?php if($mode=="users") echo 'class="active"'; ?>><a href="admin.php?action=users">All Users</a></li>
           </ul>	
         </div>
         <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">
            <?php          

            if ($mode == "classifieds") {
              echo 'All Classifieds';
            } else if ($mode == "users") {
              echo 'All Users';
            } else if ($mode == "categories") {
              echo 'All Categories';
            } else {
              echo 'Site Summary';
            }
            ?>
			<?php 
				if($mode == "classifieds") {
					$url = "add_modify_item.php";
				} if($mode == "users") {
					$url = "account.php";
				} if($mode == "categories") {
					$url = "admin.php?action=category&mode=add";
				}
				
				if($mode == "classifieds" || $mode == "users" || $mode == "categories") {
			?>
			<div class="pull-right"><a href="<?= $url ?>" role="button" class="btn btn-default">Add</a></div> 
			
			<?php } ?>
			
          </h1>
		  
          <?php if($mode == "classifieds" || $mode == "users" || $mode == "categories" ) { ?>
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <?php 
                  if($mode == "classifieds") {
                    echo '<th>ID</th><th>Title</th><th>User</th><th>Date posted</th><th>Price</th><th>Summary</th>';
                  } else if($mode == "categories") {
                    echo '<th>#</th><th>Title</th>';
                  } else if ($mode == "users") {
                    echo '<th>Username</th><th>Email address</th><th>Gender</th><th>Date joined</th><th>Phone number</th><th>Role</th>';
                  }
                  ?>
                </tr>
              </thead>
              <tbody>
                <?php 
                if($mode == "classifieds") {
                  for($i = 0; $i < count($arr); $i++ ) {
                    echo "<tr class='clickableRow' href='view_item.php?id=".$arr[$i]->id."'>";
                    echo '<td>'.$arr[$i]->id.'</td>';
                    echo '<td>'.$arr[$i]->title.'</td>';
                    echo '<td>'.$arr[$i]->user.'</td>';
                    echo '<td>'.$arr[$i]->date_listed.'</td>';
                    echo '<td>$'.$arr[$i]->price.'</td>';
                    echo '<td>'.$arr[$i]->summary.'</td>';
                    echo '</tr>';
                  }
                } else if($mode == "categories") {
                  for($i = 0; $i < count($arr); $i++) {
                    echo '<tr class="clickableRow" href="admin.php?action=category&id='.$arr[$i]->name.'" >';
                    echo '<td>'.($i+1).'</td>';
                    echo '<td>'.$arr[$i]->name.'</td>';
                    echo '</tr>';
                  }
                } else if($mode == "users") {
                  for($i = 0; $i < count($arr); $i++) {
                    echo "<tr class='clickableRow' href='view_profile.php?username=".$arr[$i]->username."'>";
                    echo '<td>'.$arr[$i]->username.'</td>';
                    echo '<td>'.$arr[$i]->email.'</td>';
                    echo '<td>'.$arr[$i]->gender.'</td>';
                    echo '<td>'.$arr[$i]->join_date.'</td>';
                    echo '<td>'.$arr[$i]->phone.'</td>';
                    echo '<td>'.$arr[$i]->role.'</td>';
                    echo '</tr>';
                  }
                } ?>
              </tbody>
            </table>
          </div>
          <?php 
        } else  if($mode =="summary") {
          echo "<div class=''>
          <p>Total number of users: $numUser</p>
          <p>Total number of categories: $numCat</p>
          <p>Total number of classifieds: $numItems</p>";

        } ?>
      </div>
    </div>
  </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <script src="../../assets/js/docs.min.js"></script>
    <script> jQuery(document).ready(function($) {
      $(".clickableRow").click(function() {
        window.document.location = $(this).attr("href");
      });
      $('.clickableRow').css('cursor', 'pointer');
    });</script>
  </body>
  </html>
