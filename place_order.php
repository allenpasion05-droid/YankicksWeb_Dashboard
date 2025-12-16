<?php
session_start();
include 'api/db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Please <a href='login-register.php'>login</a> to place an order.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $address = $_POST['address'];
    $payment_method = $_POST['payment_method'];
    
    // Get the cart data from the hidden input field
    $cart_json = $_POST['cart_data'];
    $cart_items = json_decode($cart_json, true);

    if (empty($cart_items)) {
        die("Your cart is empty.");
    }

    // Calculate total on server side for security
    $total_amount = 0;
    foreach ($cart_items as $item) {
        $total_amount += $item['price'] * $item['quantity'];
    }

    // 1. Insert into ORDERS table
    $sql_order = "INSERT INTO orders (user_id, total_amount, payment_method, shipping_address) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql_order);
    $stmt->bind_param("idss", $user_id, $total_amount, $payment_method, $address);
    
    if ($stmt->execute()) {
        $order_id = $stmt->insert_id; // Get the ID of the order we just created

        // 2. Insert into ORDER_ITEMS table
        $sql_item = "INSERT INTO order_items (order_id, product_name, quantity, price) VALUES (?, ?, ?, ?)";
        $stmt_item = $conn->prepare($sql_item);

        foreach ($cart_items as $item) {
            $stmt_item->bind_param("isid", $order_id, $item['name'], $item['quantity'], $item['price']);
            $stmt_item->execute();
        }

        // --- SUCCESS: REDIRECT TO CONFIRMATION PAGE ---
        // This redirect allows payment-confirmation.php to clear the local storage cart
        header("Location: payment-confirmation.php?order_id=" . $order_id);
        exit();

    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>