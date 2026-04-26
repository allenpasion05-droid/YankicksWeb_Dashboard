-- SQL script to insert all *_shop.jpg images into the products table
-- Each product gets placeholder values for name, category, price, and stock

USE yankicks;

INSERT INTO products (name, category, price, image, stock) VALUES
('Aero Speed Pro', 'Running', 8999.99, 'aerospeedpro_shop.jpg', 50),
('Arena Pro Champion', 'Basketball', 10999.99, 'ArenaPro Champion_shop.jpg', 30),
('Casual Comfort Pro', 'Lifestyle', 7999.99, 'CasualComfort Pro_shop.jpg', 40),
('City Walk Premium', 'Lifestyle', 6999.99, 'citywalkpremium_shop.jpg', 60),
('Cloud Run Elite', 'Running', 9999.99, 'cloudrunelite_shop.jpg', 45),
('Court King Pro', 'Basketball', 11999.99, 'courtkingpro_shop.jpg', 25),
('Jump Force Supreme', 'Basketball', 12999.99, 'jumpforcesupreme_shop.jpg', 20),
('Metro Walk Classic', 'Lifestyle', 5999.99, 'MetroWalk Classic_shop.jpg', 70),
('Slam Dunk Ultra', 'Basketball', 13999.99, 'slamdunkultra_shop.jpg', 15),
('Sprint Force', 'Running', 9499.99, 'sprintforce_shop.jpg', 35),
('Street Ball Classic', 'Basketball', 8999.99, 'streetballclassic_shop.jpg', 40),
('Street Style Signature', 'Lifestyle', 8499.99, 'streetstylesignature_shop.jpg', 55),
('Trail Blazer X', 'Running', 10999.99, 'TrailBlazer X_shop.jpg', 28),
('Turbo Run Max', 'Running', 11999.99, 'turborunmax_shop.jpg', 22),
('Urban Flex Premium', 'Lifestyle', 7599.99, 'UrbanFlex Premium_shop.jpg', 65),
('Velocity Elite', 'Running', 10499.99, 'velocityelite_shop.jpg', 32);