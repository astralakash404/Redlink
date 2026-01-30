<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard – RedLink</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<header class="navbar">
    <div class="logo">🩸 RedLink Admin</div>
    <nav>
        <li><a href="add_camp.php">Add Donation Camp</a></li>

        <a href="dashboard.php">Dashboard</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>

<section class="search">
    <h2>Welcome, Admin</h2>
    <p>You can manage blood stock and donors from here.</p>
</section>

<!-- 🔽 ADD THIS SECTION -->
<section class="cards">

    <div class="card">
        <h3>Add Blood Stock</h3>
        <p>Add new blood units to a blood bank.</p>
        <a href="add_stock.php" class="btn">Add Stock</a>
    </div>

    <div class="card">
        <h3>Issue Blood</h3>
        <p>Reduce blood units when blood is issued.</p>
        <a href="update_stock.php" class="btn">Update Stock</a>
    </div>

</section>

</body>
</html>
