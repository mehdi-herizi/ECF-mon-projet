DROP DATABASE IF EXISTS Mastergaming;

CREATE DATABASE IF NOT EXISTS Mastergaming;

USE Mastergaming;

CREATE TABLE pb_user (
    id_user INT AUTO_INCREMENT,
    email VARCHAR(100) NOT NULL UNIQUE,
    name VARCHAR(50) NOT NULL,
    firstname VARCHAR(50) NOT NULL,
    birthdate DATE NOT NULL,
    phone VARCHAR(20),
    role ENUM('user', 'admin') NOT NULL DEFAULT 'user',
    password VARCHAR(255) NOT NULL,
    PRIMARY KEY (id_user)
);

CREATE TABLE pb_order (
    id_order INT AUTO_INCREMENT,
    status ENUM(
        'pending',
        'paid',
        'shipped',
        'cancelled'
    ) NOT NULL DEFAULT 'pending',
    order_date DATETIME NOT NULL,
    id_user INT NOT NULL,
    PRIMARY KEY (id_order),
    FOREIGN KEY (id_user) REFERENCES pb_user (id_user) ON DELETE CASCADE
);

CREATE TABLE category (
    id_category INT AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL UNIQUE,
    PRIMARY KEY (id_category)
);

CREATE TABLE product (
    id_product INT AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    date_ DATE NOT NULL,
    picture VARCHAR(255) NULL,
    video VARCHAR(255) NULL,
    description TEXT NOT NULL,
    excerpt VARCHAR(500) NOT NULL,
    id_category INT NOT NULL,
    PRIMARY KEY (id_product),
    FOREIGN KEY (id_category) REFERENCES category (id_category) ON DELETE CASCADE
);

CREATE TABLE order_product (
    id_order INT NOT NULL,
    id_product INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    PRIMARY KEY (id_order, id_product),
    FOREIGN KEY (id_order) REFERENCES pb_order (id_order) ON DELETE CASCADE,
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

-- Vous devez restaurer les INSERT product depuis votre fichier original
-- ou de l'attachment fourni lors de la demande précédente
-- La structure correcte est :
INSERT INTO
    product (
        name,
        price,
        date_,
        picture,
        video,
        description,
        excerpt,
        id_category
    )
VALUES
    -- Les données devraient être ajoutées ici avec id_category
    -- Voir l'attachement database.sql pour les données complètes
;
