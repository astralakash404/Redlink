<?php
session_start();
include("../includes/db.php");

if (!isset($_SESSION['donor_id'])) {
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Donor Dashboard</title>
</head>
<body>

<h2>Welcome, <?php echo $_SESSION['donor_name']; ?></h2>

<p>This is your donor portal.</p>

<ul>
    <li>View your profile</li>
    <li>Donation history (future scope)</li>
    <li>Blood donation camps</li>
</ul>

<a href="logout.php">Logout</a>

</body>
</html>
