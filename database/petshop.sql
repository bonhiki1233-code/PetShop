
CREATE DATABASE IF NOT EXISTS petshop;
USE petshop;


CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price INT NOT NULL,
    image VARCHAR(255) NOT NULL
);


CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(255) NOT NULL,
    number VARCHAR(20) NOT NULL,
    total_price INT NOT NULL,
    status VARCHAR(20) DEFAULT 'pending'
);


INSERT INTO products (name, price, image) VALUES

SELECT * FROM products;

CREATE TABLE IF NOT EXISTS orders (
   id INT AUTO_INCREMENT PRIMARY KEY,
   user_name VARCHAR(255) NOT NULL,
   number VARCHAR(20) NOT NULL,
   email VARCHAR(255) NOT NULL,
   method VARCHAR(50) NOT NULL,
   address VARCHAR(255) NOT NULL,
   total_products VARCHAR(255) NOT NULL,
   total_price INT NOT NULL,
   status VARCHAR(20) DEFAULT 'pending'
);

INSERT INTO orders (user_name, number, total_price, status) VALUES

SELECT image FROM products;