<?php
// api/products.php
header('Content-Type: application/json');
include 'db_connect.php';

// Fetch all products from the database
$sql = "SELECT * FROM products ORDER BY id DESC"; // Newest items first
$result = $conn->query($sql);

$products = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Fix the image path if needed
        // If the path in DB already includes 'assets/images/', keep it.
        // If it's just 'uploads/shoe.jpg', add the prefix.
        
        // We push the raw row data into our array
        $products[] = $row;
    }
}

// Send the data back to the browser as JSON
echo json_encode($products);

$conn->close();
?>