<?php
session_start();
include 'api/db_connect.php';

// Security Check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') { 
    header("Location: login-register.php"); 
    exit(); 
}

// Get ID
if (!isset($_GET['id'])) { 
    header("Location: admin_dashboard.php?view=products"); 
    exit(); 
}
$id = $_GET['id'];

// Fetch current data
$result = $conn->query("SELECT * FROM products WHERE id=$id");
$product = $result->fetch_assoc();

if (!$product) {
    die("Product not found.");
}

if (isset($_POST['update_product'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $stock = $_POST['stock'];
    
    // If new image uploaded
    if (!empty($_FILES["image"]["name"])) {
        $target_dir = "assets/images/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        $sql = "UPDATE products SET name=?, category=?, price=?, stock=?, image=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdisi", $name, $category, $price, $stock, $target_file, $id);
    } else {
        // Keep old image
        $sql = "UPDATE products SET name=?, category=?, price=?, stock=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdis", $name, $category, $price, $stock, $id);
    }
    
    if ($stmt->execute()) {
        header("Location: admin_dashboard.php?view=products");
        exit();
    } else {
        $error = "Error updating product.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - YanKicks Admin</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        * {
            box-sizing: border-box; 
        }

        body { 
            background-color: #f9f9f9; 
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            min-height: 100vh; /* Changed from height to min-height for scrolling */
            margin: 0; 
            padding: 20px; /* Add padding to prevent edges touching on mobile */
        }

        .form-container { 
            background: white; 
            padding: 40px; 
            border-radius: 8px; 
            box-shadow: 0 4px 12px rgba(0,0,0,0.05); 
            width: 100%; 
            max-width: 500px; 
            border: 1px solid #e0e0e0; 
        }

        h1 { 
            margin-top: 0; 
            font-size: 24px; 
            margin-bottom: 20px; 
            color: #000; 
            text-align: center; /* Center title on all screens */
        }

        .form-group { 
            margin-bottom: 20px; 
        }

        label { 
            display: block; 
            margin-bottom: 8px; 
            font-weight: 600; 
            font-size: 13px; 
            color: #333; 
        }

        input[type="text"],
        input[type="number"],
        input[type="file"],
        select { 
            width: 100%; 
            padding: 12px; 
            border: 1px solid #ddd; 
            border-radius: 6px; 
            font-size: 14px; 
            background: #fff;
            transition: border-color 0.2s;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #000;
        }

        .current-img-container {
            margin-top: 10px;
            padding: 10px;
            background: #f8f8f8;
            border-radius: 6px;
            text-align: center;
        }

        .current-img { 
            max-width: 100%; 
            height: auto; 
            max-height: 150px;
            border-radius: 4px; 
            border: 1px solid #eee; 
            display: block;
            margin: 0 auto;
        }

        .btn { 
            width: 100%; 
            padding: 14px; 
            background: #000; 
            color: white; 
            border: none; 
            border-radius: 6px; 
            cursor: pointer; 
            font-weight: bold; 
            font-size: 15px;
            margin-top: 10px; 
            transition: background 0.2s;
        }

        .btn:hover { 
            background: #333; 
        }

        .back-link { 
            display: block; 
            text-align: center; 
            margin-top: 20px; 
            color: #666; 
            text-decoration: none; 
            font-size: 14px; 
        }

        .back-link:hover {
            color: #000;
            text-decoration: underline;
        }

        /* --- Mobile Responsiveness --- */
        @media (max-width: 480px) {
            .form-container {
                padding: 25px 20px; /* Reduce padding on small screens */
            }
            
            h1 {
                font-size: 20px;
            }

            input[type="text"],
            input[type="number"],
            select {
                font-size: 16px; /* Prevent zoom on iOS inputs */
            }
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h1>Edit Product</h1>
        
        <?php if(isset($error)) echo "<div style='background:#fee2e2; color:#ef4444; padding:10px; border-radius:4px; margin-bottom:15px; text-align:center;'>$error</div>"; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Product Name</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Category</label>
                <select name="category">
                    <option value="Lifestyle" <?php if($product['category']=='Lifestyle') echo 'selected'; ?>>Lifestyle</option>
                    <option value="Running" <?php if($product['category']=='Running') echo 'selected'; ?>>Running</option>
                    <option value="Basketball" <?php if($product['category']=='Basketball') echo 'selected'; ?>>Basketball</option>
                    <option value="Training" <?php if($product['category']=='Training') echo 'selected'; ?>>Training</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Price (₱)</label>
                <input type="number" step="0.01" name="price" value="<?php echo $product['price']; ?>" required>
            </div>

            <div class="form-group">
                <label>Stock Quantity</label>
                <input type="number" name="stock" value="<?php echo $product['stock']; ?>" required>
            </div>
            
            <div class="form-group">
                <label>Product Image</label>
                <input type="file" name="image">
                <div class="current-img-container">
                    <p style="font-size:12px; color:#666; margin:0 0 5px 0;">Current Image:</p>
                    <img src="<?php echo htmlspecialchars($product['image']); ?>" class="current-img" alt="Current Product Image">
                </div>
            </div>
            
            <button type="submit" name="update_product" class="btn">Update Product</button>
        </form>
        
        <a href="admin_dashboard.php?view=products" class="back-link">← Cancel & Return to Dashboard</a>
    </div>

</body>
</html>