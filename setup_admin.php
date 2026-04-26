<?php
/**
 * Admin User Setup Script
 * This script creates or updates an admin user with password 'admin123'
 * Run this script to set up the admin user for testing
 */

include 'api/db_connect.php';

$admin_email = 'admin@yankicks.com';
$admin_name = 'Admin User';
$admin_password = 'admin123';

// Check if admin user already exists
$sql_check = "SELECT id FROM users WHERE email = ? AND role = 'admin'";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("s", $admin_email);
$stmt_check->execute();
$result = $stmt_check->get_result();

if ($result->num_rows > 0) {
    // Admin user exists, update password
    $sql_update = "UPDATE users SET password = ? WHERE email = ? AND role = 'admin'";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ss", $admin_password, $admin_email);

    if ($stmt_update->execute()) {
        echo "✓ Admin user password updated successfully!\n";
        echo "Email: $admin_email\n";
        echo "Password: $admin_password\n";
    } else {
        echo "✗ Error updating admin password: " . $stmt_update->error . "\n";
    }

    $stmt_update->close();
} else {
    // Admin user doesn't exist, create new one
    $sql_insert = "INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, 'admin')";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("sss", $admin_name, $admin_email, $admin_password);

    if ($stmt_insert->execute()) {
        echo "✓ Admin user created successfully!\n";
        echo "Name: $admin_name\n";
        echo "Email: $admin_email\n";
        echo "Password: $admin_password\n";
        echo "Role: admin\n";
    } else {
        echo "✗ Error creating admin user: " . $stmt_insert->error . "\n";
    }

    $stmt_insert->close();
}

$stmt_check->close();
$conn->close();

echo "\n=== Admin Login Credentials ===\n";
echo "Email: $admin_email\n";
echo "Password: $admin_password\n";
echo "\nYou can now log in to the admin dashboard at admin_dashboard.php\n";
?>