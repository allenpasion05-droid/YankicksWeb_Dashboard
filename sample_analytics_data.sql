-- Sample Data for YanKicks Admin Dashboard Analytics
-- This script creates realistic sample data to populate the admin dashboard analytics

USE yankicks;

-- Drop existing tables to start from scratch
DROP TABLE IF EXISTS order_items;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS users;

-- Recreate tables (from setup_db.sql)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    banned_until DATETIME DEFAULT NULL,
    phone_number VARCHAR(20) DEFAULT NULL,
    profile_picture VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255) DEFAULT NULL,
    stock INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total_amount DECIMAL(10, 2) NOT NULL,
    payment_method VARCHAR(50) NOT NULL,
    shipping_address TEXT NOT NULL,
    status ENUM('pending', 'shipped', 'completed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_name VARCHAR(255) NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id)
);

-- Insert sample users (regular users + admin)
INSERT INTO users (full_name, email, password, role, created_at) VALUES
('John Smith', 'john.smith@email.com', 'password123', 'user', '2024-10-01 10:00:00'),
('Maria Garcia', 'maria.garcia@email.com', 'password123', 'user', '2024-10-05 14:30:00'),
('Alex Johnson', 'alex.johnson@email.com', 'password123', 'user', '2024-10-08 09:15:00'),
('Sarah Wilson', 'sarah.wilson@email.com', 'password123', 'user', '2024-10-12 16:45:00'),
('Mike Brown', 'mike.brown@email.com', 'password123', 'user', '2024-10-15 11:20:00'),
('Emma Davis', 'emma.davis@email.com', 'password123', 'user', '2024-10-18 13:10:00'),
('Chris Taylor', 'chris.taylor@email.com', 'password123', 'user', '2024-10-22 08:30:00'),
('Lisa Anderson', 'lisa.anderson@email.com', 'password123', 'user', '2024-10-25 15:55:00'),
('David Martinez', 'david.martinez@email.com', 'password123', 'user', '2024-10-28 12:40:00'),
('Jennifer Lee', 'jennifer.lee@email.com', 'password123', 'user', '2024-11-02 10:25:00'),
('Robert White', 'robert.white@email.com', 'password123', 'user', '2024-11-05 14:15:00'),
('Amanda Clark', 'amanda.clark@email.com', 'password123', 'user', '2024-11-08 09:50:00'),
('Kevin Rodriguez', 'kevin.rodriguez@email.com', 'password123', 'user', '2024-11-12 16:30:00'),
('Michelle Hall', 'michelle.hall@email.com', 'password123', 'user', '2024-11-15 11:45:00'),
('Steven Young', 'steven.young@email.com', 'password123', 'user', '2024-11-18 13:20:00'),
('Jessica King', 'jessica.king@email.com', 'password123', 'user', '2024-11-22 08:55:00'),
('Daniel Wright', 'daniel.wright@email.com', 'password123', 'user', '2024-11-25 15:40:00'),
('Ashley Lopez', 'ashley.lopez@email.com', 'password123', 'user', '2024-11-28 12:15:00'),
('James Hill', 'james.hill@email.com', 'password123', 'user', '2024-12-02 10:35:00'),
('Brittany Green', 'brittany.green@email.com', 'password123', 'user', '2024-12-05 14:25:00'),
('Admin User', 'admin@yankicks.com', 'admin123', 'admin', '2024-10-01 09:00:00');

-- Insert sample products across different categories
INSERT INTO products (name, category, price, image, stock, created_at) VALUES
-- Running Shoes
('Turbo Run Max', 'Running', 8500.00, 'turborunmax_shop.jpg', 25, '2024-10-01 10:00:00'),
('Cloud Run Elite', 'Running', 9200.00, 'cloudrunelite_shop.jpg', 18, '2024-10-02 11:00:00'),
('Sprint Force', 'Running', 7800.00, 'sprintforce_shop.jpg', 32, '2024-10-03 12:00:00'),
('Aero Speed Pro', 'Running', 9500.00, 'aerospeedpro_shop.jpg', 15, '2024-10-04 13:00:00'),

-- Basketball Shoes
('Jump Force Supreme', 'Basketball', 11200.00, 'jumpforcesupreme_shop.jpg', 12, '2024-10-05 14:00:00'),
('Slam Dunk Ultra', 'Basketball', 10800.00, 'slamdunkultra_shop.jpg', 20, '2024-10-06 15:00:00'),
('Court King Pro', 'Basketball', 9800.00, 'courtkingpro_shop.jpg', 28, '2024-10-07 16:00:00'),
('Hoops Master Pro', 'Basketball', 10500.00, 'hoopsmasterpro.jpg', 16, '2024-10-08 17:00:00'),

-- Lifestyle Shoes
('Urban Flex Premium', 'Lifestyle', 7200.00, 'UrbanFlex Premium_shop.jpg', 35, '2024-10-09 10:00:00'),
('Street Style Signature', 'Lifestyle', 6800.00, 'streetstylesignature_shop.jpg', 22, '2024-10-10 11:00:00'),
('Metro Walk Classic', 'Lifestyle', 6500.00, 'MetroWalk Classic_shop.jpg', 30, '2024-10-11 12:00:00'),
('City Walk Premium', 'Lifestyle', 7500.00, 'citywalkpremium_shop.jpg', 18, '2024-10-12 13:00:00'),

-- Additional products for variety
('Velocity Elite', 'Running', 8900.00, 'velocityelite_shop.jpg', 14, '2024-10-13 14:00:00'),
('Arena Pro Champion', 'Basketball', 11500.00, 'ArenaPro Champion_shop.jpg', 10, '2024-10-14 15:00:00'),
('Casual Comfort Pro', 'Lifestyle', 6900.00, 'CasualComfort Pro_shop.jpg', 26, '2024-10-15 16:00:00'),
('Trail Blazer X', 'Running', 8800.00, 'TrailBlazer X_shop.jpg', 19, '2024-10-16 17:00:00'),
('Street Ball Classic', 'Basketball', 9200.00, 'streetballclassic_shop.jpg', 24, '2024-10-17 10:00:00'),
('Urban Style', 'Lifestyle', 7100.00, 'urbanstyle_shop.jpg', 21, '2024-10-18 11:00:00');

-- Insert sample orders with realistic dates spanning the last 6 months
INSERT INTO orders (user_id, total_amount, payment_method, shipping_address, status, created_at) VALUES
-- October 2024 orders
(1, 17000.00, 'GCash', '123 Main St, Manila, Philippines', 'completed', '2024-10-15 10:30:00'),
(2, 9200.00, 'PayPal', '456 Oak Ave, Quezon City, Philippines', 'completed', '2024-10-18 14:20:00'),
(3, 11200.00, 'GCash', '789 Pine Rd, Cebu City, Philippines', 'shipped', '2024-10-22 09:15:00'),
(4, 6500.00, 'Bank Transfer', '321 Elm St, Davao City, Philippines', 'completed', '2024-10-25 16:45:00'),
(5, 20500.00, 'GCash', '654 Maple Ave, Makati, Philippines', 'completed', '2024-10-28 11:30:00'),

-- November 2024 orders
(6, 7800.00, 'PayPal', '987 Birch Rd, Pasig, Philippines', 'completed', '2024-11-02 13:20:00'),
(7, 15800.00, 'GCash', '147 Cedar St, Taguig, Philippines', 'shipped', '2024-11-05 15:10:00'),
(8, 9500.00, 'Bank Transfer', '258 Walnut Ave, Mandaluyong, Philippines', 'completed', '2024-11-08 10:45:00'),
(9, 7200.00, 'GCash', '369 Spruce Rd, Paranaque, Philippines', 'pending', '2024-11-12 14:30:00'),
(10, 10800.00, 'PayPal', '741 Ash St, Las Pinas, Philippines', 'completed', '2024-11-15 09:20:00'),
(11, 13200.00, 'GCash', '852 Fir Ave, Muntinlupa, Philippines', 'shipped', '2024-11-18 16:15:00'),
(12, 6800.00, 'Bank Transfer', '963 Palm Rd, Antipolo, Philippines', 'completed', '2024-11-22 12:40:00'),
(13, 18700.00, 'GCash', '159 Oak St, Bacoor, Philippines', 'completed', '2024-11-25 08:55:00'),
(14, 8500.00, 'PayPal', '357 Pine Ave, Imus, Philippines', 'cancelled', '2024-11-28 15:30:00'),

-- December 2024 orders
(15, 11500.00, 'GCash', '468 Elm Rd, Dasmariñas, Philippines', 'completed', '2024-12-02 11:10:00'),
(16, 9200.00, 'Bank Transfer', '579 Maple St, General Trias, Philippines', 'shipped', '2024-12-05 13:45:00'),
(17, 14300.00, 'PayPal', '680 Birch Ave, Trece Martires, Philippines', 'completed', '2024-12-08 10:20:00'),
(18, 7500.00, 'GCash', '791 Cedar Rd, Naic, Philippines', 'pending', '2024-12-12 14:55:00'),
(19, 16800.00, 'Bank Transfer', '802 Walnut St, Maragondon, Philippines', 'completed', '2024-12-15 09:40:00'),
(20, 9800.00, 'GCash', '913 Spruce Ave, Tanza, Philippines', 'shipped', '2024-12-18 16:25:00'),
(1, 12500.00, 'PayPal', '024 Fir Rd, Rosario, Philippines', 'completed', '2024-12-22 12:15:00'),
(2, 8900.00, 'GCash', '135 Ash St, Noveleta, Philippines', 'completed', '2024-12-25 08:50:00'),
(3, 15600.00, 'Bank Transfer', '246 Palm Ave, Kawit, Philippines', 'pending', '2024-12-28 15:35:00'),

-- January 2025 orders (recent)
(4, 10500.00, 'GCash', '357 Oak Rd, Cavite City, Philippines', 'completed', '2025-01-02 11:20:00'),
(5, 13200.00, 'PayPal', '468 Pine St, Bacoor, Philippines', 'shipped', '2025-01-05 13:55:00'),
(6, 7800.00, 'GCash', '579 Elm Ave, Dasmariñas, Philippines', 'completed', '2025-01-08 10:30:00'),
(7, 14700.00, 'Bank Transfer', '680 Maple Rd, Imus, Philippines', 'completed', '2025-01-12 14:45:00'),
(8, 9600.00, 'GCash', '791 Birch St, General Trias, Philippines', 'pending', '2025-01-15 09:15:00'),
(9, 11200.00, 'PayPal', '802 Cedar Ave, Trece Martires, Philippines', 'completed', '2025-01-18 16:40:00'),
(10, 13400.00, 'GCash', '913 Walnut Rd, Naic, Philippines', 'shipped', '2025-01-22 12:25:00'),
(11, 8700.00, 'Bank Transfer', '024 Spruce St, Maragondon, Philippines', 'completed', '2025-01-25 08:10:00'),
(12, 15900.00, 'GCash', '135 Fir Ave, Tanza, Philippines', 'completed', '2025-01-28 15:55:00'),

-- February 2025 orders (current month)
(13, 11800.00, 'PayPal', '246 Ash Rd, Rosario, Philippines', 'completed', '2025-02-02 11:40:00'),
(14, 9200.00, 'GCash', '357 Palm St, Noveleta, Philippines', 'shipped', '2025-02-05 13:20:00'),
(15, 14100.00, 'Bank Transfer', '468 Oak Ave, Kawit, Philippines', 'completed', '2025-02-08 10:05:00'),
(16, 7600.00, 'GCash', '579 Pine Rd, Cavite City, Philippines', 'pending', '2025-02-12 14:50:00'),
(17, 12800.00, 'PayPal', '680 Elm St, Bacoor, Philippines', 'completed', '2025-02-15 09:35:00'),
(18, 10300.00, 'GCash', '791 Maple Ave, Dasmariñas, Philippines', 'shipped', '2025-02-18 16:20:00'),
(19, 15200.00, 'Bank Transfer', '802 Birch Rd, Imus, Philippines', 'completed', '2025-02-22 12:45:00'),
(20, 8900.00, 'GCash', '913 Cedar St, General Trias, Philippines', 'completed', '2025-02-25 08:30:00'),
(1, 16700.00, 'PayPal', '024 Walnut Ave, Trece Martires, Philippines', 'pending', '2025-02-28 15:15:00');

-- Insert order items (linking products to orders)
INSERT INTO order_items (order_id, product_name, quantity, price) VALUES
-- Order 1 items
(1, 'Turbo Run Max', 1, 8500.00),
(1, 'Sprint Force', 1, 7800.00),

-- Order 2 items
(2, 'Cloud Run Elite', 1, 9200.00),

-- Order 3 items
(3, 'Jump Force Supreme', 1, 11200.00),

-- Order 4 items
(4, 'Metro Walk Classic', 1, 6500.00),

-- Order 5 items
(5, 'Turbo Run Max', 1, 8500.00),
(5, 'Slam Dunk Ultra', 1, 10800.00),

-- Continue with more order items...
(6, 'Sprint Force', 1, 7800.00),
(7, 'Aero Speed Pro', 1, 9500.00),
(7, 'Urban Flex Premium', 1, 7200.00),
(8, 'Court King Pro', 1, 9800.00),
(9, 'Street Style Signature', 1, 6800.00),
(10, 'Hoops Master Pro', 1, 10500.00),
(11, 'Jump Force Supreme', 1, 11200.00),
(11, 'City Walk Premium', 1, 7500.00),
(12, 'Metro Walk Classic', 1, 6500.00),
(13, 'Velocity Elite', 1, 8900.00),
(13, 'Arena Pro Champion', 1, 11500.00),
(14, 'Casual Comfort Pro', 1, 6900.00),
(15, 'Trail Blazer X', 1, 8800.00),
(16, 'Street Ball Classic', 1, 9200.00),
(17, 'Urban Style', 1, 7100.00),
(17, 'Turbo Run Max', 1, 8500.00),
(18, 'Cloud Run Elite', 1, 9200.00),
(19, 'Sprint Force', 1, 7800.00),
(19, 'Aero Speed Pro', 1, 9500.00),
(20, 'Jump Force Supreme', 1, 11200.00),
(21, 'Slam Dunk Ultra', 1, 10800.00),
(22, 'Court King Pro', 1, 9800.00),
(23, 'Hoops Master Pro', 1, 10500.00),
(24, 'Urban Flex Premium', 1, 7200.00),
(25, 'Street Style Signature', 1, 6800.00),
(26, 'Metro Walk Classic', 1, 6500.00),
(27, 'City Walk Premium', 1, 7500.00),
(28, 'Velocity Elite', 1, 8900.00),
(29, 'Arena Pro Champion', 1, 11500.00),
(30, 'Casual Comfort Pro', 1, 6900.00),
(31, 'Trail Blazer X', 1, 8800.00),
(32, 'Street Ball Classic', 1, 9200.00),
(33, 'Urban Style', 1, 7100.00),
(34, 'Turbo Run Max', 1, 8500.00),
(35, 'Cloud Run Elite', 1, 9200.00),
(36, 'Sprint Force', 1, 7800.00),
(37, 'Aero Speed Pro', 1, 9500.00),
(38, 'Jump Force Supreme', 1, 11200.00),
(39, 'Slam Dunk Ultra', 1, 10800.00),
(40, 'Court King Pro', 1, 9800.00),
(41, 'Hoops Master Pro', 1, 10500.00),
(42, 'Urban Flex Premium', 1, 7200.00),
(43, 'Street Style Signature', 1, 6800.00),
(44, 'Metro Walk Classic', 1, 6500.00),
(45, 'City Walk Premium', 1, 7500.00);

-- Verification queries
SELECT 'Total Users' as metric, COUNT(*) as value FROM users WHERE role = 'user'
UNION ALL
SELECT 'Total Products', COUNT(*) FROM products
UNION ALL
SELECT 'Total Orders', COUNT(*) FROM orders
UNION ALL
SELECT 'Total Revenue', SUM(total_amount) FROM orders WHERE status = 'completed'
UNION ALL
SELECT 'Completed Orders', COUNT(*) FROM orders WHERE status = 'completed'
UNION ALL
SELECT 'Pending Orders', COUNT(*) FROM orders WHERE status = 'pending'
UNION ALL
SELECT 'Shipped Orders', COUNT(*) FROM orders WHERE status = 'shipped'
UNION ALL
SELECT 'Cancelled Orders', COUNT(*) FROM orders WHERE status = 'cancelled';

-- Monthly sales breakdown for the last 6 months
SELECT
    DATE_FORMAT(created_at, '%Y-%m') as month,
    SUM(total_amount) as revenue,
    COUNT(*) as orders
FROM orders
WHERE status = 'completed'
    AND created_at >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
GROUP BY DATE_FORMAT(created_at, '%Y-%m')
ORDER BY month DESC;

-- Category distribution
SELECT category, COUNT(*) as product_count FROM products GROUP BY category ORDER BY product_count DESC;

-- Order status distribution
SELECT status, COUNT(*) as order_count FROM orders GROUP BY status ORDER BY order_count DESC;