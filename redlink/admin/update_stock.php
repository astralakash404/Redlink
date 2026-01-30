<?php
session_start();
include("../includes/db.php");

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
}

$msg = "";

/* Fetch blood banks */
$banks = mysqli_query($conn, "SELECT id, name FROM blood_banks");

if (isset($_POST['update'])) {

    $bank_id = $_POST['bank_id'];
    $blood_group = $_POST['blood_group'];
    $issued_units = $_POST['issued_units'];

    // Get current units
    $check = mysqli_query($conn, "
        SELECT units 
        FROM blood_stock 
        WHERE blood_bank_id='$bank_id' 
        AND blood_group='$blood_group'
    ");

    if (mysqli_num_rows($check) == 1) {
        $row = mysqli_fetch_assoc($check);
        $current_units = $row['units'];

        if ($issued_units <= $current_units) {
            $new_units = $current_units - $issued_units;

            mysqli_query($conn, "
                UPDATE blood_stock 
                SET units='$new_units' 
                WHERE blood_bank_id='$bank_id' 
                AND blood_group='$blood_group'
            ");

            $msg = "Stock updated successfully!";
        } else {
            $msg = "Error: Not enough units available!";
        }
    } else {
        $msg = "Stock record not found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Blood Stock</title>
</head>
<body>

<h2>Issue Blood / Reduce Stock</h2>
<p style="color:green"><?php echo $msg; ?></p>

<form method="post">
    Blood Bank:
    <select name="bank_id" required>
        <option value="">Select</option>
        <?php while ($b = mysqli_fetch_assoc($banks)) { ?>
            <option value="<?= $b['id']; ?>"><?= $b['name']; ?></option>
        <?php } ?>
    </select><br><br>

    Blood Group:
    <select name="blood_group" required>
        <option>A+</option><option>A-</option>
        <option>B+</option><option>B-</option>
        <option>O+</option><option>O-</option>
        <option>AB+</option><option>AB-</option>
    </select><br><br>

    Issued Units:
    <input type="number" name="issued_units" required><br><br>

    <button type="submit" name="update">Update Stock</button>
</form>

</body>
</html>
