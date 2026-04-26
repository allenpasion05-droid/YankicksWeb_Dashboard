<?php
/**
 * Sample Analytics Data Loader
 * This script loads sample data for the admin dashboard analytics
 * Run this script to populate the database with realistic sample data
 */

include 'api/db_connect.php';

echo "=== YanKicks Sample Analytics Data Loader ===\n\n";
echo "⚠️  WARNING: This script will DELETE ALL EXISTING DATA in your database!\n";
echo "   Make sure to backup any important data before proceeding.\n\n";
echo "Press Ctrl+C to cancel, or the script will continue in 5 seconds...\n\n";

sleep(5); // Give user time to cancel if needed

echo "Starting data load process...\n\n";

// Read the SQL file
$sql_file = 'sample_analytics_data.sql';
if (!file_exists($sql_file)) {
    die("Error: SQL file '$sql_file' not found!\n");
}

$sql_content = file_get_contents($sql_file);

// Split the SQL file into individual statements
$statements = array_filter(array_map('trim', explode(';', $sql_content)));

// Remove comments and empty statements
$clean_statements = [];
foreach ($statements as $statement) {
    // Skip comments and empty statements
    if (!empty($statement) && !preg_match('/^--/', $statement)) {
        $clean_statements[] = $statement;
    }
}

$success_count = 0;
$error_count = 0;

echo "Executing SQL statements...\n\n";

foreach ($clean_statements as $statement) {
    if (trim($statement) === '') continue;

    try {
        if ($conn->query($statement) === TRUE) {
            $success_count++;
            echo "✓ Statement executed successfully\n";
        } else {
            $error_count++;
            echo "✗ Error executing statement: " . $conn->error . "\n";
            echo "Statement: " . substr($statement, 0, 100) . "...\n\n";
        }
    } catch (Exception $e) {
        $error_count++;
        echo "✗ Exception: " . $e->getMessage() . "\n";
        echo "Statement: " . substr($statement, 0, 100) . "...\n\n";
    }
}

echo "\n=== Execution Summary ===\n";
echo "Successful statements: $success_count\n";
echo "Failed statements: $error_count\n\n";

if ($error_count === 0) {
    echo "🎉 All sample data loaded successfully!\n\n";

    // Run verification queries
    echo "=== Analytics Verification ===\n";

    // Get summary stats
    $stats = $conn->query("
        SELECT 'Total Users' as metric, COUNT(*) as value FROM users WHERE role = 'user'
        UNION ALL
        SELECT 'Total Products', COUNT(*) FROM products
        UNION ALL
        SELECT 'Total Orders', COUNT(*) FROM orders
        UNION ALL
        SELECT 'Total Revenue', SUM(total_amount) FROM orders WHERE status = 'completed'
        UNION ALL
        SELECT 'Completed Orders', COUNT(*) FROM orders WHERE status = 'completed'
    ");

    while ($row = $stats->fetch_assoc()) {
        echo $row['metric'] . ": " . ($row['metric'] == 'Total Revenue' ? '₱' . number_format($row['value'], 2) : $row['value']) . "\n";
    }

    echo "\n=== Monthly Sales (Last 6 Months) ===\n";
    $monthly_sales = $conn->query("
        SELECT
            DATE_FORMAT(created_at, '%Y-%m') as month,
            SUM(total_amount) as revenue,
            COUNT(*) as orders
        FROM orders
        WHERE status = 'completed'
            AND created_at >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
        GROUP BY DATE_FORMAT(created_at, '%Y-%m')
        ORDER BY month DESC
    ");

    while ($row = $monthly_sales->fetch_assoc()) {
        echo $row['month'] . ": ₱" . number_format($row['revenue'], 2) . " (" . $row['orders'] . " orders)\n";
    }

} else {
    echo "❌ Some statements failed. Please check the errors above.\n";
}

$conn->close();

echo "\n=== Next Steps ===\n";
echo "1. Log in to the admin dashboard at admin_dashboard.php\n";
echo "2. Navigate to the Overview section to see the analytics\n";
echo "3. Check the Sales Performance and Order Status Distribution charts\n";
echo "4. Explore the Users, Products, and Orders management sections\n";
?>