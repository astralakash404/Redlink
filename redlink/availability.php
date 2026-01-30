<?php
include "includes/db.php";
include "includes/header.php";

$state = $_GET['state'] ?? '';
$district = $_GET['district'] ?? '';
$blood_group = $_GET['blood_group'] ?? '';

// Fetch states
$states = mysqli_query(
    $conn,
    "SELECT DISTINCT state FROM blood_banks ORDER BY state"
);

// Fetch districts only after state selected
$districts = $state
    ? mysqli_query(
        $conn,
        "SELECT DISTINCT district 
         FROM blood_banks 
         WHERE state='$state' 
         ORDER BY district"
      )
    : false;
?>

<h2>Blood Stock Availability</h2>

<form method="get">

    <!-- State -->
    <select name="state" onchange="this.form.submit()" required>
        <option value="">Select State</option>
        <?php while ($s = mysqli_fetch_assoc($states)) { ?>
            <option value="<?= $s['state'] ?>" <?= ($state == $s['state']) ? 'selected' : '' ?>>
                <?= $s['state'] ?>
            </option>
        <?php } ?>
    </select>

    <!-- District -->
    <select name="district" onchange="this.form.submit()" <?= !$state ? 'disabled' : '' ?> required>
        <option value="">Select District</option>
        <?php if ($districts) while ($d = mysqli_fetch_assoc($districts)) { ?>
            <option value="<?= $d['district'] ?>" <?= ($district == $d['district']) ? 'selected' : '' ?>>
                <?= $d['district'] ?>
            </option>
        <?php } ?>
    </select>

    <!-- Blood Group -->
    <select name="blood_group" required>
        <option value="">Select Blood Group</option>
        <?php
        foreach (['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bg) {
            $sel = ($blood_group == $bg) ? 'selected' : '';
            echo "<option value='$bg' $sel>$bg</option>";
        }
        ?>
    </select>

    <button type="submit">Search</button>
</form>

<hr>

<?php
if ($state && $district && $blood_group) {

    $query = "
        SELECT 
            bb.name,
            bb.address,
            bb.contact,
            bs.units
        FROM blood_banks bb
        JOIN blood_stock bs ON bs.blood_bank_id = bb.id
        WHERE bb.state = '$state'
          AND bb.district = '$district'
          AND bs.blood_group = '$blood_group'
    ";

    $res = mysqli_query($conn, $query);

    if (mysqli_num_rows($res) > 0) {

        echo "<table border='1' cellpadding='8'>
                <tr>
                    <th>Blood Bank</th>
                    <th>Address</th>
                    <th>Contact</th>
                    <th>Units</th>
                    <th>Status</th>
                </tr>";

        while ($r = mysqli_fetch_assoc($res)) {

            // 🔴 Low stock logic (eRaktKosh style)
            $status = "NORMAL";
            $color = "green";

            if ($r['units'] <= 2) {
                $status = "CRITICAL";
                $color = "red";
            } elseif ($r['units'] <= 5) {
                $status = "LOW";
                $color = "orange";
            }

            echo "<tr>
                    <td>{$r['name']}</td>
                    <td>{$r['address']}</td>
                    <td>{$r['contact']}</td>
                    <td>{$r['units']}</td>
                    <td style='color:$color; font-weight:bold;'>$status</td>
                  </tr>";
        }

        echo "</table>";

    } else {
        echo "<p>No stock available.</p>";
    }
}

include "includes/footer.php";
?>
