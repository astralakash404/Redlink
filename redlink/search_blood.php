<?php
include 'includes/db.php';
include 'includes/header.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

/* Fetch districts for dropdown */
$district_result = $conn->query("
    SELECT DISTINCT district 
    FROM blood_banks 
    ORDER BY district
");

$results = null;

if (isset($_GET['blood_group']) && isset($_GET['district'])) {

    $blood_group = $_GET['blood_group'];
    $district = $_GET['district'];

    $stmt = $conn->prepare("
        SELECT 
            bs.blood_group,
            SUM(bs.units) AS total_units,
            bb.district
        FROM blood_stock bs
        JOIN blood_banks bb 
            ON bs.blood_bank_id = bb.id
        WHERE bs.blood_group = ? 
          AND bb.district = ?
        GROUP BY bs.blood_group, bb.district
    ");

    $stmt->bind_param("ss", $blood_group, $district);
    $stmt->execute();
    $results = $stmt->get_result();
}
?>

<section class="search">
    <h2>Search Blood Availability</h2>

    <form method="GET">
        <!-- Blood Group -->
        <select name="blood_group" required>
            <option value="">Select Blood Group</option>
            <?php
            $groups = ['A+','A-','B+','B-','O+','O-','AB+','AB-'];
            foreach ($groups as $g) {
                echo "<option value='$g'>$g</option>";
            }
            ?>
        </select>

        <!-- District -->
        <select name="district" required>
            <option value="">Select District</option>
            <?php
            if ($district_result && $district_result->num_rows > 0) {
                while ($d = $district_result->fetch_assoc()) {
                    echo "<option value='{$d['district']}'>{$d['district']}</option>";
                }
            }
            ?>
        </select>

        <button type="submit">Search</button>
    </form>
</section>

<section class="cards">
<?php
if ($results) {
    if ($results->num_rows > 0) {
        while ($row = $results->fetch_assoc()) {
            echo "<div class='card'>";
            echo "<h3>{$row['blood_group']}</h3>";
            echo "<p>District: {$row['district']}</p>";
            echo "<p>Available Units: {$row['total_units']}</p>";
            echo "</div>";
        }
    } else {
        echo "<p>No blood available for selected criteria.</p>";
    }
}
?>
</section>
