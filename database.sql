DROP DATABASE nexary;
CREATE DATABASE IF NOT EXISTS nexary;
USE nexary;



CREATE TABLE IF NOT EXISTS pb_user (
    id_user INT AUTO_INCREMENT,
    email VARCHAR(100) NOT NULL,
    name VARCHAR(50) NOT NULL,
    firstname VARCHAR(50) NOT NULL,
     birthdate DATE NOT NULL,
   numerotelephone VARCHAR(20),
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') NOT NULL DEFAULT 'user',
    PRIMARY KEY (id_user),
    UNIQUE (email)
);

CREATE TABLE IF NOT EXISTS pb_order (
    order_id INT AUTO_INCREMENT,
    order_date DATETIME NOT NULL,
    status ENUM('pending','paid','shipped','cancelled') NOT NULL,
    id_user INT NOT NULL,
    PRIMARY KEY (order_id),
    FOREIGN KEY (id_user) REFERENCES pb_user (id_user) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS category (
    id_category INT AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    PRIMARY KEY (id_category)
);

CREATE TABLE IF NOT EXISTS product (
    id_product INT AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    in_stock INT NOT NULL DEFAULT 0,
    id_category INT NOT NULL,
    PRIMARY KEY (id_product),
    FOREIGN KEY (id_category) REFERENCES category (id_category) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS order_product (
    order_id INT,
    id_product INT,
    quantity INT NOT NULL DEFAULT 1,
    PRIMARY KEY (order_id, id_product),
    FOREIGN KEY (order_id) REFERENCES pb_order (order_id) ON DELETE CASCADE,
    FOREIGN KEY (id_product) REFERENCES product (id_product) ON DELETE CASCADE
);

INSERT INTO
    category (name)
VALUES ('Action'),
    ('Aventure'),
    ('Shooter'),
    ('Stratégie'),
    ('Simulation'),
    ('Course'),
    ('Sport'),
    ('Horreur'),
    ('Puzzle'),
    ('Plateforme'),
    ('MMO'),
    ('Indie'),
    ('RPG'),
    ('Sandbox'),
    ('Survival'),
    ('Fighting'),
    ('Roguelike');