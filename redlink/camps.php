<?php
include 'includes/db.php';
include 'includes/header.php';

// Fetch filters
$states = mysqli_query($conn, "SELECT DISTINCT state FROM blood_banks");
$districts = mysqli_query($conn, "SELECT DISTINCT district FROM blood_banks");

$state = $_GET['state'] ?? '';
$district = $_GET['district'] ?? '';

$sql = "
    SELECT 
        c.camp_name,
        c.camp_date,
        c.location,
        c.contact,
        bb.name AS bank_name,
        bb.state,
        bb.district
    FROM camps c
    JOIN blood_banks bb ON c.blood_bank_id = bb.id
    WHERE c.camp_date >= CURDATE()
";

if ($state !== '') {
    $sql .= " AND bb.state = '$state'";
}
if ($district !== '') {
    $sql .= " AND bb.district = '$district'";
}

$sql .= " ORDER BY c.camp_date ASC";

$result = mysqli_query($conn, $sql);
?>

<h2>Upcoming Blood Donation Camps</h2>

<form method="GET">
    State:
    <select name="state">
        <option value="">All States</option>
        <?php while ($s = mysqli_fetch_assoc($states)) { ?>
            <option value="<?= $s['state']; ?>" <?= ($state == $s['state']) ? 'selected' : '' ?>>
                <?= $s['state']; ?>
            </option>
        <?php } ?>
    </select>

    District:
    <select name="district">
        <option value="">All Districts</option>
        <?php while ($d = mysqli_fetch_assoc($districts)) { ?>
            <option value="<?= $d['district']; ?>" <?= ($district == $d['district']) ? 'selected' : '' ?>>
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
            <h3>{$row['camp_name']}</h3>
            <p><b>Date:</b> {$row['camp_date']}</p>
            <p><b>Blood Bank:</b> {$row['bank_name']}</p>
            <p><b>Location:</b> {$row['location']}</p>
            <p><b>Contact:</b> {$row['contact']}</p>
            <p><b>State:</b> {$row['state']} | <b>District:</b> {$row['district']}</p>
        </div>
        ";
    }
} else {
    echo "<p>No upcoming camps found.</p>";
}
?>

<?php include 'includes/footer.php'; ?>
