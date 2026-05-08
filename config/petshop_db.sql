-- Xóa Database cũ nếu có và tạo mới
DROP SCHEMA IF EXISTS `petshop_db`;
CREATE SCHEMA IF NOT EXISTS `petshop_db` DEFAULT CHARACTER SET utf8mb4;
USE `petshop_db`;

-- 1. Bảng Users
DROP TABLE IF EXISTS `Users`;
CREATE TABLE IF NOT EXISTS `Users` (
  `user_id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NULL,
  `username` VARCHAR(50) NULL,
  `full_name` VARCHAR(100) NULL,
  `role` ENUM('ADMIN', 'CUSTOMER') NULL DEFAULT 'CUSTOMER',
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `is_active` TINYINT(1) NULL DEFAULT 1,
  PRIMARY KEY (`user_id`),
  UNIQUE INDEX `user_id_UNIQUE` (`user_id` ASC))
ENGINE = InnoDB;

-- 2. Bảng Categories
DROP TABLE IF EXISTS `Categories`;
CREATE TABLE IF NOT EXISTS `Categories` (
  `category_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_name` VARCHAR(100) NOT NULL,
  `description` TEXT NULL,
  `parent_id` INT UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`category_id`))
ENGINE = InnoDB;

-- 3. Bảng Products
DROP TABLE IF EXISTS `Products`;
CREATE TABLE IF NOT EXISTS `Products` (
  `product_id` INT NOT NULL AUTO_INCREMENT,
  `product_name` VARCHAR(255) NOT NULL,
  `price_old` DECIMAL(12,2) NULL,
  `price_new` DECIMAL(12,2) NOT NULL,
  `stock_quantity` INT NULL DEFAULT 0,
  `image_url` VARCHAR(500) NULL,
  `description` TEXT NULL,
  `is_pet` TINYINT(1) NULL DEFAULT 0,
  `slug` VARCHAR(255) NULL,
  `category_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`product_id`),
  UNIQUE INDEX `slug_UNIQUE` (`slug` ASC),
  CONSTRAINT `fk_products_categories`
    FOREIGN KEY (`category_id`)
    REFERENCES `Categories` (`category_id`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB;

-- 4. Bảng Orders
DROP TABLE IF EXISTS `Orders`;
CREATE TABLE IF NOT EXISTS `Orders` (
  `order_id` INT NOT NULL AUTO_INCREMENT,
  `total_amount` DECIMAL(15,2) NOT NULL,
  `order_status` ENUM('PENDING', 'SHIPPING', 'DELIVERED', 'CANCELED') DEFAULT 'PENDING',
  `shipping_address` TEXT NULL,
  `order_date` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` INT NOT NULL,
  PRIMARY KEY (`order_id`),
  CONSTRAINT `fk_orders_users`
    FOREIGN KEY (`user_id`)
    REFERENCES `Users` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB;

-- 5. Bảng Order_Details
DROP TABLE IF EXISTS `Order_Details`;
CREATE TABLE IF NOT EXISTS `Order_Details` (
  `detail_id` INT NOT NULL AUTO_INCREMENT,
  `quantity` INT NOT NULL,
  `unit_price` DECIMAL(12,2) NULL,
  `order_id` INT NOT NULL,
  `product_id` INT NOT NULL,
  PRIMARY KEY (`detail_id`),
  CONSTRAINT `fk_details_orders`
    FOREIGN KEY (`order_id`)
    REFERENCES `Orders` (`order_id`)
    ON DELETE CASCADE,
  CONSTRAINT `fk_details_products`
    FOREIGN KEY (`product_id`)
    REFERENCES `Products` (`product_id`))
ENGINE = InnoDB;

-- 6. Bảng Reviews
DROP TABLE IF EXISTS `Reviews`;
CREATE TABLE IF NOT EXISTS `Reviews` (
  `review_id` INT NOT NULL AUTO_INCREMENT,
  `rating` TINYINT NULL,
  `comment` TEXT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` INT NOT NULL,
  `product_id` INT NOT NULL,
  PRIMARY KEY (`review_id`),
  CONSTRAINT `fk_reviews_users`
    FOREIGN KEY (`user_id`)
    REFERENCES `Users` (`user_id`),
  CONSTRAINT `fk_reviews_products`
    FOREIGN KEY (`product_id`)
    REFERENCES `Products` (`product_id`))
ENGINE = InnoDB;

-- 7. Bảng Promotions
DROP TABLE IF EXISTS `Promotions`;
CREATE TABLE IF NOT EXISTS `Promotions` (
  `promo_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `promo_name` VARCHAR(100) NOT NULL,
  `discount_percent` DECIMAL(5,2) NULL,
  `start_date` DATETIME NULL,
  `end_date` DATETIME NULL,
  `is_active` TINYINT(1) NULL DEFAULT 1,
  PRIMARY KEY (`promo_id`))
ENGINE = InnoDB;

-- 8. Bảng Policies
DROP TABLE IF EXISTS `Policies`;
CREATE TABLE IF NOT EXISTS `Policies` (
  `policy_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `policy_type` ENUM('WARRANTY', 'RETURN', 'SHIPPING') NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `content` TEXT NULL,
  PRIMARY KEY (`policy_id`))
ENGINE = InnoDB;

-- 9. Bảng Cart
DROP TABLE IF EXISTS `Cart`;
CREATE TABLE IF NOT EXISTS `Cart` (
  `cart_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `quantity` INT NOT NULL,
  `user_id` INT NOT NULL,
  `product_id` INT NOT NULL,
  PRIMARY KEY (`cart_id`),
  CONSTRAINT `fk_cart_users`
    FOREIGN KEY (`user_id`)
    REFERENCES `Users` (`user_id`),
  CONSTRAINT `fk_cart_products`
    FOREIGN KEY (`product_id`)
    REFERENCES `Products` (`product_id`))
ENGINE = InnoDB;

-- 10. Bảng Feedback
DROP TABLE IF EXISTS `Feedback`;
CREATE TABLE IF NOT EXISTS `Feedback` (
  `feedback_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `full_name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `subject` VARCHAR(255) NULL,
  `message` TEXT NOT NULL,
  `status` ENUM('NEW', 'READ', 'REPLIED') NULL DEFAULT 'NEW',
  `user_id` INT NOT NULL,
  PRIMARY KEY (`feedback_id`),
  CONSTRAINT `fk_feedback_users`
    FOREIGN KEY (`user_id`)
    REFERENCES `Users` (`user_id`))
ENGINE = InnoDB;

-- 11. Bảng Payment
DROP TABLE IF EXISTS `Payment`;
CREATE TABLE IF NOT EXISTS `Payment` (
  `payment_id` INT NOT NULL AUTO_INCREMENT,
  `payment_method` ENUM('COD', 'BANK', 'MOMO', 'VNPAY') NULL,
  `amount` DECIMAL(15,2) NULL,
  `transaction_id` VARCHAR(255) NULL,
  `payment_status` VARCHAR(45) NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `order_id` INT NOT NULL,
  PRIMARY KEY (`payment_id`),
  CONSTRAINT `fk_payment_orders`
    FOREIGN KEY (`order_id`)
    REFERENCES `Orders` (`order_id`))
ENGINE = InnoDB;