<?php
session_start();
include 'api/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT id, full_name, password, role FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            // CHECK IF BANNED
            if ($row['banned_until'] && new DateTime($row['banned_until']) > new DateTime()) {
                $banned_date = date('M d, Y', strtotime($row['banned_until']));
                echo "<div style='color:red; text-align:center; margin-top:20px;'>
                        <h3>Account Suspended</h3>
                        <p>You are banned until: <strong>$banned_date</strong></p>
                        <a href='login.php'>Go Back</a>
                      </div>";
                exit();
            }

            // Password Correct & Not Banned -> Start Session
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['full_name'];
            $_SESSION['role'] = $row['role'];

            if ($row['role'] == 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No account found with that email.";
    }
}
?>