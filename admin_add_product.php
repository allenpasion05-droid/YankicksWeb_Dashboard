<?php
session_start();
include 'api/db_connect.php';

// Security Check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') { header("Location: login-register.php"); exit(); }

if (isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $stock = $_POST['stock'];
    
    // Image Upload Handling
    $target_dir = "assets/images/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

    $stmt = $conn->prepare("INSERT INTO products (name, category, price, image, stock) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdsi", $name, $category, $price, $target_file, $stock);
    
    if ($stmt->execute()) {
        header("Location: admin_dashboard.php?view=products");
    } else {
        $error = "Error adding product.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product - YanKicks Admin</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body { background-color: #f9f9f9; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .form-container { background: white; padding: 40px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); width: 100%; max-width: 500px; border: 1px solid #e0e0e0; }
        h1 { margin-top: 0; font-size: 24px; margin-bottom: 20px; color: #000; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #333; }
        input, select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; box-sizing: border-box; }
        .btn { width: 100%; padding: 12px; background: #000; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; margin-top: 10px; }
        .btn:hover { background: #333; }
        .back-link { display: block; text-align: center; margin-top: 15px; color: #666; text-decoration: none; font-size: 13px; }
    </style>
</head>
<body>

    <div class="form-container">
        <h1>Add New Product</h1>
        
        <?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Product Name</label>
                <input type="text" name="name" required>
            </div>
            
            <div class="form-group">
                <label>Category</label>
                <select name="category">
                    <option value="Lifestyle">Lifestyle</option>
                    <option value="Running">Running</option>
                    <option value="Basketball">Basketball</option>
                    <option value="Training">Training</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Price (₱)</label>
                <input type="number" step="0.01" name="price" required>
            </div>

            <div class="form-group">
                <label>Stock Quantity</label>
                <input type="number" name="stock" value="10" required>
            </div>
            
            <div class="form-group">
                <label>Product Image</label>
                <input type="file" name="image" required>
            </div>
            
            <button type="submit" name="add_product" class="btn">Add Product</button>
        </form>
        
        <a href="admin_dashboard.php?view=products" class="back-link">← Cancel & Return to Dashboard</a>
    </div>

</body>
</html>