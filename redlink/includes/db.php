<?php
$conn = mysqli_connect("localhost", "root", "", "redlink");
if (!$conn) {
    die("DB connection failed: " . mysqli_connect_error());
}
?>
