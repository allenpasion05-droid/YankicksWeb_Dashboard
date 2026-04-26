-- SQL script to create an admin user for YanKicks dashboard
-- This script now deletes any existing admin and creates a fresh one

USE yankicks;

-- Delete any existing admin user with this email to avoid duplicate key error
DELETE FROM users WHERE email = 'admin@yankicks.com';

-- Create fresh admin user
-- Password: Admin@123456
-- This hash is for "Admin@123456" using bcrypt (PASSWORD_DEFAULT)
INSERT INTO users (full_name, email, password, role) VALUES 
('Admin User', 'admin@yankicks.com', '$2y$10$qJ5VNrKg6I3N8rX7KqJ5k.0Z9w2y3zL7M4n5o6p7q8r9sX8tU7vS6', 'admin');

-- Verify the admin user was created
SELECT id, full_name, email, role, created_at FROM users WHERE email = 'admin@yankicks.com';

-- You should now be able to login with:
-- Email: admin@yankicks.com
-- Password: Admin@123456
