<?php
include 'includes/db.php';
include 'includes/header.php';

/* Overall blood availability summary */
$result = $conn->query("
    SELECT 
        bs.blood_group, 
        SUM(bs.units) AS total_units
    FROM blood_stock bs
    GROUP BY bs.blood_group
");
?>

<!-- HERO SECTION -->
<section class="hero">
    <h1>Donate Blood, Save Lives</h1>
    <p>A smart platform connecting donors with blood banks</p>
    <a href="search_blood.php" class="btn">Search Blood Availability</a>
</section>

<!-- QUICK SEARCH (REDIRECTS TO SEARCH PAGE) -->
<section class="search">
    <h2>Quick Blood Search</h2>
    <form action="search_blood.php" method="GET">
        <select name="blood_group" required>
            <option value="">Select Blood Group</option>
            <?php
            $groups = ['A+','A-','B+','B-','O+','O-','AB+','AB-'];
            foreach ($groups as $g) {
                echo "<option value='$g'>$g</option>";
            }
            ?>
        </select>

        <button type="submit">Search</button>
    </form>
</section>

<!-- BLOOD AVAILABILITY SUMMARY -->
<section class="cards">
<h2>Overall Blood Availability</h2>

<?php
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='card'>";
        echo "<h3>{$row['blood_group']}</h3>";
        echo "<p>Available Units: {$row['total_units']}</p>";
        echo "</div>";
    }
} else {
    echo "<p>No blood data available</p>";
}
?>
</section>

<?php include 'includes/footer.php'; ?>
