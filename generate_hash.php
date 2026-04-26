<?php
/**
 * Password Generator for Admin User
 * This generates the plain text password for the admin
 */

// Store password as plain text (for now)
$hashed_password = $password;

echo "=== YanKicks Admin Password Generator ===\n\n";
echo "Original Password: " . $password . "\n";
echo "Stored Password: " . $hashed_password . "\n\n";

// Display SQL statements using this hash
echo "=== SQL Commands ===\n\n";

echo "Option 1: Insert new admin user:\n";
echo "INSERT INTO users (full_name, email, password, role) VALUES \n";
echo "('Admin User', 'admin@yankicks.com', '" . $hashed_password . "', 'admin');\n\n";

echo "Option 2: Update existing admin user password:\n";
echo "UPDATE users SET password = '" . $hashed_password . "' \n";
echo "WHERE email = 'admin@yankicks.com';\n\n";

echo "=== Verification ===\n";
echo "Verifying password match: ";
if ($password === $hashed_password) {
    echo "✓ SUCCESS - Password is stored as plain text!\n";
} else {
    echo "✗ FAILED - Password mismatch\n";
}
?>
