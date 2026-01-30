<?php
session_start();
include '../includes/db.php';

$error = "";

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare(
        "SELECT * FROM admins WHERE username=? AND password=?"
    );
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $_SESSION['admin'] = $username;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid admin credentials";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login – REDLINK</title>
</head>
<body>

<h2>Admin Login</h2>

<?php if ($error != "") { ?>
    <p style="color:red;"><?php echo $error; ?></p>
<?php } ?>

<form method="POST">
    <input type="text" name="username" placeholder="Username" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit" name="login">Login</button>
</form>

</body>
</html>
