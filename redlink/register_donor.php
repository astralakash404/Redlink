<?php
include 'includes/db.php';
include 'includes/header.php';

$msg = "";

/* Fetch cities for dropdown */
$city_result = $conn->query("SELECT DISTINCT city FROM blood_banks");

if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password']; // plain text for prototype
    $blood_group = $_POST['blood_group'];
    $city = $_POST['city'];
    $phone = $_POST['phone'];

    // Insert donor with login credentials
    $stmt = $conn->prepare(
        "INSERT INTO donors (name, email, password, blood_group, city, phone)
         VALUES (?, ?, ?, ?, ?, ?)"
    );

    $stmt->bind_param(
        "ssssss",
        $name,
        $email,
        $password,
        $blood_group,
        $city,
        $phone
    );

    if ($stmt->execute()) {
        $msg = "🎉 Donor registered successfully! You can now login.";
    } else {
        $msg = "❌ Registration failed. Email may already exist.";
    }
}
?>

<section class="search">
    <h2>Become a Blood Donor</h2>

    <?php if ($msg != "") { ?>
        <p style="font-weight:bold;"><?php echo $msg; ?></p>
    <?php } ?>

    <form method="POST">

        <input type="text" name="name" placeholder="Full Name" required>

        <!-- 🔐 LOGIN DETAILS -->
        <input type="email" name="email" placeholder="Email Address" required>

        <input type="password" name="password" placeholder="Create Password" required>

        <select name="blood_group" required>
            <option value="">Select Blood Group</option>
            <option>A+</option>
            <option>A-</option>
            <option>B+</option>
            <option>B-</option>
            <option>O+</option>
            <option>O-</option>
            <option>AB+</option>
            <option>AB-</option>
        </select>

        <select name="city" required>
            <option value="">Select City</option>
            <?php
            if ($city_result && $city_result->num_rows > 0) {
                while ($row = $city_result->fetch_assoc()) {
                    echo "<option value='{$row['city']}'>{$row['city']}</option>";
                }
            }
            ?>
        </select>

        <input type="text" name="phone" placeholder="Mobile Number" required>

        <button type="submit" name="submit">Register</button>
    </form>
</section>

</body>
</html>
