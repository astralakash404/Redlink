<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$msg = "";

// Fetch blood banks
$banks = mysqli_query($conn, "SELECT id, name FROM blood_banks");

if (isset($_POST['add'])) {

    $blood_bank_id = $_POST['blood_bank_id'];
    $camp_name = $_POST['camp_name'];
    $camp_date = $_POST['camp_date'];
    $location = $_POST['location'];
    $contact = $_POST['contact'];

    $stmt = $conn->prepare(
        "INSERT INTO camps (blood_bank_id, camp_name, camp_date, location, contact)
         VALUES (?, ?, ?, ?, ?)"
    );
    $stmt->bind_param("issss",
        $blood_bank_id,
        $camp_name,
        $camp_date,
        $location,
        $contact
    );

    if ($stmt->execute()) {
        $msg = "Camp added successfully";
    } else {
        $msg = "Failed to add camp";
    }
}
?>

<h2>Add Blood Donation Camp</h2>

<p style="color:green;"><?php echo $msg; ?></p>

<form method="POST">
    Blood Bank:
    <select name="blood_bank_id" required>
        <option value="">Select Blood Bank</option>
        <?php while ($b = mysqli_fetch_assoc($banks)) { ?>
            <option value="<?= $b['id']; ?>"><?= $b['name']; ?></option>
        <?php } ?>
    </select><br><br>

    Camp Name:
    <input type="text" name="camp_name" required><br><br>

    Camp Date:
    <input type="date" name="camp_date" required><br><br>

    Location:
    <textarea name="location" required></textarea><br><br>

    Contact:
    <input type="text" name="contact" required><br><br>

    <button type="submit" name="add">Add Camp</button>
</form>
