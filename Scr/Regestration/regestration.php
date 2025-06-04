<?php
// regerstration.php
require_once '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = trim($_POST['fname']);
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repeat = $_POST['repeat-password'];

    if ($password !== $repeat) {
        die("Wrong password or login");
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (login, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $login, $email, $hashed_password);

    if ($stmt->execute()) {
        echo "Successful!";
    } else {
        echo "Regestration Error" . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
