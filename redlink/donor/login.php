<?php
session_start();
include("../includes/db.php");

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM donors WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $donor = mysqli_fetch_assoc($result);
        $_SESSION['donor_id'] = $donor['id'];
        $_SESSION['donor_name'] = $donor['name'];
        header("Location: dashboard.php");
    } else {
        $error = "Invalid login details";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Donor Login</title>
</head>
<body>

<h2>Donor Login</h2>

<?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>

<form method="post">
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit" name="login">Login</button>
</form>

</body>
</html>
