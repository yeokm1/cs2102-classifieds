<?php 

$conn = mysqli_connect("localhost", "root", "", "classifieds");
if (mysqli_connect_errno($conn)) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
} 

?>