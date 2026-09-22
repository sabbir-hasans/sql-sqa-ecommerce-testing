CREATE DATABASE IF NOT EXISTS sql_sqa_project CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE sql_sqa_project;

DROP TABLE IF EXISTS shippings;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS customers;

CREATE TABLE customers (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NULL,
    age INT NULL,
    country VARCHAR(50) NOT NULL
);

CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    item VARCHAR(100) NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    customer_id INT NOT NULL,
    CONSTRAINT fk_orders_customer FOREIGN KEY (customer_id) REFERENCES customers(customer_id)
        ON UPDATE CASCADE ON DELETE RESTRICT
);

CREATE TABLE shippings (
    shipping_id INT AUTO_INCREMENT PRIMARY KEY,
    status ENUM('Pending','Delivered') NOT NULL DEFAULT 'Pending',
    customer INT NOT NULL,
    order_id INT NULL,
    CONSTRAINT fk_ship_customer FOREIGN KEY (customer) REFERENCES customers(customer_id)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT fk_ship_order FOREIGN KEY (order_id) REFERENCES orders(order_id)
        ON UPDATE CASCADE ON DELETE SET NULL
);
