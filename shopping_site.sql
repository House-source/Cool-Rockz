-- Create the database
CREATE DATABASE IF NOT EXISTS shopping_site;
USE shopping_site;

-- Create users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    date_joined TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    user_role ENUM('user', 'admin') DEFAULT 'user'
);

-- Create categories table
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL
);

-- Create products table
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    image_path VARCHAR(255),
    stock_quantity INT DEFAULT 0,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

-- Create orders table
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total_amount DECIMAL(10,2) NOT NULL,
    status VARCHAR(20) DEFAULT 'Pending',
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Create order_items table
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Create contact messages table
CREATE TABLE contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    message TEXT NOT NULL,
    date_sent TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Create table to hold cart items
CREATE TABLE cart_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Initialize Store, categories and products.
INSERT INTO categories (name) 
VALUES 
('Cool Rockz'),
('Cool Standz');

INSERT INTO products (category_id, name, description, price, image_path, stock_quantity) 
VALUES 
(1, 'Smiley', '(Cool) Rock with a smiley face painted on.' , 5.00, '../images/smiley.jpg', 1),
(1, 'Funky Rock', 'Funky looking rock with an unidentified white mineral.' , 8.00, '../images/funky.jpg', 1),
(1, 'Wireless Rock', 'High-performance wireless rock with a great look and even better battery life.' , 99.00, '../images/wireless.jpg', 1),
(2, 'Adjustable Metal Arm Stand', 'A handy metal stand with adjustable arms, resting on an acrylic base.' , 12.00, '../images/metalarm.jpg', 10),
(2, 'Adjustable Brass Arm Stand', 'A fancy brass stand with adjustable arms, set on a walnut base.' , 15.00, '../images/brassarm.jpg', 10),
(2, '3 Tier Acrylic Display Riser', '3-tier acrylic riser stand. Perfect for holding a bunch of Cool Rockz!' , 20.00, '../images/3tier.jpg', 10);


-- Setup sql user for database
SELECT User, Host FROM mysql.user;
CREATE USER 'Dave Database'@'localhost' IDENTIFIED BY 'Dave@database1';
GRANT ALL PRIVILEGES ON shopping_site.* TO 'Dave Database'@'localhost';
FLUSH PRIVILEGES;

-- Create two users to illustrate user roles: 'user' and 'admin'
INSERT INTO users (name, email, password_hash, user_role) 
VALUES ('Tom Storeuser', 'john@example.com', '$2y$10$Vuxn9ipYlyq.NS.1nCgO/uVj2zblxJtW.hItT4XjcoIUSSJbvBQGq', 'user'); -- password: Password
INSERT INTO users (name, email, password_hash, user_role) 
VALUES ('Joseph Joestore', 'joejoe@example.com', '$2y$10$Vuxn9ipYlyq.NS.1nCgO/uVj2zblxJtW.hItT4XjcoIUSSJbvBQGq', 'admin'); -- password: Password

-- Delete/Reset database
-- DROP DATABASE shopping_site; 

