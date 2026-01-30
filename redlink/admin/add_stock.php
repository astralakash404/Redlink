<?php
include '../includes/db.php';

if ($_POST) {
    $conn->query("
        INSERT INTO blood_stock (city_id, blood_group, units)
        VALUES ('$_POST[city]', '$_POST[group]', '$_POST[units]')
    ");
    echo "Stock added!";
}
?>

<form method="POST">
    City ID: <input name="city"><br>
    Blood Group: <input name="group"><br>
    Units: <input name="units"><br>
    <button>Add</button>
</form>
