<?php
include 'includes/db.php';
include 'includes/header.php';

// Fetch states & districts for filters
$states = mysqli_query($conn, "SELECT DISTINCT state FROM blood_banks ORDER BY state");
$districts = mysqli_query($conn, "SELECT DISTINCT district FROM blood_banks ORDER BY district");

$state = $_GET['state'] ?? '';
$district = $_GET['district'] ?? '';

// Build query
$sql = "SELECT name, category, address, contact, state, district FROM blood_banks WHERE 1";

if ($state !== '') {
    $sql .= " AND state = '$state'";
}
if ($district !== '') {
    $sql .= " AND district = '$district'";
}

$result = mysqli_query($conn, $sql);
?>

<h2>Blood Bank Directory</h2>

<form method="GET">
    State:
    <select name="state">
        <option value="">All States</option>
        <?php while ($s = mysqli_fetch_assoc($states)) { ?>
            <option value="<?= $s['state']; ?>" <?= ($state === $s['state']) ? 'selected' : '' ?>>
                <?= $s['state']; ?>
            </option>
        <?php } ?>
    </select>

    District:
    <select name="district">
        <option value="">All Districts</option>
        <?php while ($d = mysqli_fetch_assoc($districts)) { ?>
            <option value="<?= $d['district']; ?>" <?= ($district === $d['district']) ? 'selected' : '' ?>>
                <?= $d['district']; ?>
            </option>
        <?php } ?>
    </select>

    <button type="submit">Search</button>
</form>

<hr>

<?php
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "
        <div style='border:1px solid #ccc; padding:10px; margin-bottom:10px;'>
            <h3>{$row['name']}</h3>
            <p><b>Category:</b> {$row['category']}</p>
            <p><b>State:</b> {$row['state']} | <b>District:</b> {$row['district']}</p>
            <p><b>Address:</b> {$row['address']}</p>
            <p><b>Contact:</b> {$row['contact']}</p>
        </div>
        ";
    }
} else {
    echo "<p>No blood banks found.</p>";
}
?>

<?php include 'includes/footer.php'; ?>
