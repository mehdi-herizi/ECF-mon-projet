DROP DATABASE IF EXISTS Mastergaming;

CREATE DATABASE IF NOT EXISTS Mastergaming;

USE Mastergaming;

-- 1. Table des catégories
CREATE TABLE IF NOT EXISTS `category` (
  `id_category` int(11) NOT NULL AUTO_INCREMENT,
  `name_category` varchar(50) NOT NULL,
  PRIMARY KEY (`id_category`)
);

-- 2. Table des produits (jeux)
CREATE TABLE IF NOT EXISTS `product` (
  `id_product` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `date_` date NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `id_category` int(11) NOT NULL,
  `tag` enum('trending','coming_soon','new') DEFAULT NULL,
  PRIMARY KEY (`id_product`),
  KEY `fk_category` (`id_category`),
  CONSTRAINT `fk_category` FOREIGN KEY (`id_category`) REFERENCES `category` (`id_category`) ON DELETE CASCADE
);

-- 3. Table des utilisateurs
CREATE TABLE IF NOT EXISTS `pb_user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `birthdate` date DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` varchar(50) DEFAULT 'user',
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id_user`)
);

-- 4. Table des commandes
CREATE TABLE IF NOT EXISTS `pb_order` (
  `id_order` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(50) NOT NULL,
  `order_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id_order`),
  KEY `fk_user` (`id_user`),
  CONSTRAINT `fk_user` FOREIGN KEY (`id_user`) REFERENCES `pb_user` (`id_user`) ON DELETE CASCADE
);

-- 5. Table de liaison Commandes/Produits (Détails de la commande)
CREATE TABLE IF NOT EXISTS `order_product` (
  `id_order` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id_order`,`id_product`),
  KEY `fk_product_order` (`id_product`),
  CONSTRAINT `fk_order` FOREIGN KEY (`id_order`) REFERENCES `pb_order` (`id_order`) ON DELETE CASCADE,
  CONSTRAINT `fk_product_order` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`) ON DELETE CASCADE
);
CREATE TABLE IF NOT EXISTS `contact_messages` (
  `id_message` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `is_read` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_message`)
);
CREATE TABLE IF NOT EXISTS `wishlist` (
    `id_user` int(11) NOT NULL,
    `id_product` int(11) NOT NULL,
    `added_at` datetime DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id_user`, `id_product`),
    CONSTRAINT `fk_wishlist_user` FOREIGN KEY (`id_user`) REFERENCES `pb_user` (`id_user`) ON DELETE CASCADE,
    CONSTRAINT `fk_wishlist_product` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`) ON DELETE CASCADE
);
INSERT INTO
    category (name_category)
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

INSERT INTO
    product (
        name,
        price,
        date_,
        picture,
        video,
        description,
        id_category,
        tag
    )
VALUES (
        'ARC Raiders',
        39.99,
        '2023-09-01',
        'images-jeux/ARC-Raiders.webp',
        'https://www.youtube.com/watch?v=9slTF7NJ7UI',
        '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit turpis vitae ante maximus mollis id et dui. Phasellus convallis justo id ligula sagittis eleifend. Vestibulum vel finibus lectus. Nullam ac felis nibh. Aenean eu porta lorem. Fusce vestibulum lorem id porta accumsan. Curabitur sit amet ultrices mauris. Nunc tempus nibh facilisis dolor pretium, tempor pretium leo suscipit. Ut consectetur nunc nisi, quis ornare lorem fringilla ac. Sed fringilla risus sodales, eleifend lectus ac, interdum lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris et egestas purus, id egestas nisi.

Cras non mattis purus. Vivamus dignissim pulvinar orci, eu interdum quam hendrerit eget. Nunc elementum imperdiet volutpat. Phasellus enim nibh, lacinia sed orci eu, laoreet lacinia ligula. Morbi ullamcorper finibus magna eu interdum. Aenean nec dolor sed nunc dapibus malesuada vitae in massa. Nam semper mi risus, dictum vehicula nisi hendrerit ut. Ut posuere pulvinar ipsum in semper. Cras magna enim, hendrerit eget nisi ac, rutrum malesuada tortor. Pellentesque rutrum pretium mauris, sed tincidunt nunc dapibus non. Nunc semper neque felis, auctor fringilla justo faucibus ac. Aliquam imperdiet dapibus orci, ut bibendum libero iaculis id. Duis at mauris non felis scelerisque maximus. Ut nec nisl urna. Quisque ullamcorper arcu quis ante laoreet, vitae semper ex accumsan. Ut auctor id nisl vel rhoncus.

Nulla egestas massa in libero blandit, vel auctor mi feugiat. In non nulla vitae turpis sollicitudin consectetur a eget lacus. Mauris arcu ex, vestibulum in hendrerit id, blandit eu erat. Nullam nec commodo ex, vel hendrerit mi. Mauris vitae dolor ac purus dignissim varius. In vel faucibus erat, a commodo ante. Phasellus a nisi non arcu volutpat imperdiet vitae ac neque. Pellentesque convallis nunc et mi fermentum pharetra. Nullam tincidunt libero eu est finibus rhoncus. Proin eu lacus sed erat malesuada rhoncus vitae sed odio. Nullam tempus euismod elit, sit amet scelerisque ante tristique vel. In ac libero at diam pulvinar bibendum. Pellentesque gravida neque in ipsum sagittis bibendum.

Sed libero lectus, facilisis et volutpat in, congue vel ex. Morbi ac facilisis diam, eget pellentesque lectus. Vestibulum in ex in eros vulputate accumsan. Donec maximus velit tortor, at euismod purus commodo et. Curabitur vitae consequat lectus. Suspendisse vitae nunc elit. Quisque nec bibendum urna, maximus lobortis metus. Integer tincidunt pulvinar dui, sed euismod metus pulvinar vitae. Aenean lacus augue, consequat quis commodo sed, imperdiet nec risus. Aliquam imperdiet, nisi id aliquam pellentesque, libero magna consequat est, ac facilisis nunc enim id ipsum. Nunc ullamcorper interdum quam, sed facilisis mi porttitor non. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer maximus tortor dui, pulvinar pretium neque tempus quis. Nullam fringilla, urna eu commodo eleifend, nunc velit egestas felis, vel consequat purus leo vel orci. Sed fringilla pellentesque magna.

Nullam eget faucibus risus. Ut tellus tellus, scelerisque sit amet risus nec, mattis condimentum augue. Donec orci justo, aliquet a quam sed, pulvinar sagittis augue. Mauris venenatis dolor eu lacus mattis, vel accumsan velit laoreet. Nulla dapibus vulputate volutpat. Sed eget dictum elit. Morbi a volutpat justo. Suspendisse non diam lorem. Nulla hendrerit ut nisi sed mattis. Morbi vitae consequat velit, sit amet sollicitudin quam. Vestibulum dignissim eleifend mi, a tincidunt libero congue faucibus. Fusce semper posuere sapien, hendrerit molestie risus congue vitae. Ut eu auctor turpis. In hac habitasse platea dictumst. Etiam condimentum urna sit amet arcu venenatis, at commodo augue fermentum.',
        1,
        NULL
    ),
    (
        'ARK: Survival Ascended',
        44.99,
        '2024-10-23',
        'images-jeux/ARK-Survival-Ascended.webp',
        'https://www.youtube.com/watch?v=sYi6iy07GsE',
        '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit turpis vitae ante maximus mollis id et dui. Phasellus convallis justo id ligula sagittis eleifend. Vestibulum vel finibus lectus. Nullam ac felis nibh. Aenean eu porta lorem. Fusce vestibulum lorem id porta accumsan. Curabitur sit amet ultrices mauris. Nunc tempus nibh facilisis dolor pretium, tempor pretium leo suscipit. Ut consectetur nunc nisi, quis ornare lorem fringilla ac. Sed fringilla risus sodales, eleifend lectus ac, interdum lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris et egestas purus, id egestas nisi.

Cras non mattis purus. Vivamus dignissim pulvinar orci, eu interdum quam hendrerit eget. Nunc elementum imperdiet volutpat. Phasellus enim nibh, lacinia sed orci eu, laoreet lacinia ligula. Morbi ullamcorper finibus magna eu interdum. Aenean nec dolor sed nunc dapibus malesuada vitae in massa. Nam semper mi risus, dictum vehicula nisi hendrerit ut. Ut posuere pulvinar ipsum in semper. Cras magna enim, hendrerit eget nisi ac, rutrum malesuada tortor. Pellentesque rutrum pretium mauris, sed tincidunt nunc dapibus non. Nunc semper neque felis, auctor fringilla justo faucibus ac. Aliquam imperdiet dapibus orci, ut bibendum libero iaculis id. Duis at mauris non felis scelerisque maximus. Ut nec nisl urna. Quisque ullamcorper arcu quis ante laoreet, vitae semper ex accumsan. Ut auctor id nisl vel rhoncus.

Nulla egestas massa in libero blandit, vel auctor mi feugiat. In non nulla vitae turpis sollicitudin consectetur a eget lacus. Mauris arcu ex, vestibulum in hendrerit id, blandit eu erat. Nullam nec commodo ex, vel hendrerit mi. Mauris vitae dolor ac purus dignissim varius. In vel faucibus erat, a commodo ante. Phasellus a nisi non arcu volutpat imperdiet vitae ac neque. Pellentesque convallis nunc et mi fermentum pharetra. Nullam tincidunt libero eu est finibus rhoncus. Proin eu lacus sed erat malesuada rhoncus vitae sed odio. Nullam tempus euismod elit, sit amet scelerisque ante tristique vel. In ac libero at diam pulvinar bibendum. Pellentesque gravida neque in ipsum sagittis bibendum.

Sed libero lectus, facilisis et volutpat in, congue vel ex. Morbi ac facilisis diam, eget pellentesque lectus. Vestibulum in ex in eros vulputate accumsan. Donec maximus velit tortor, at euismod purus commodo et. Curabitur vitae consequat lectus. Suspendisse vitae nunc elit. Quisque nec bibendum urna, maximus lobortis metus. Integer tincidunt pulvinar dui, sed euismod metus pulvinar vitae. Aenean lacus augue, consequat quis commodo sed, imperdiet nec risus. Aliquam imperdiet, nisi id aliquam pellentesque, libero magna consequat est, ac facilisis nunc enim id ipsum. Nunc ullamcorper interdum quam, sed facilisis mi porttitor non. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer maximus tortor dui, pulvinar pretium neque tempus quis. Nullam fringilla, urna eu commodo eleifend, nunc velit egestas felis, vel consequat purus leo vel orci. Sed fringilla pellentesque magna.

Nullam eget faucibus risus. Ut tellus tellus, scelerisque sit amet risus nec, mattis condimentum augue. Donec orci justo, aliquet a quam sed, pulvinar sagittis augue. Mauris venenatis dolor eu lacus mattis, vel accumsan velit laoreet. Nulla dapibus vulputate volutpat. Sed eget dictum elit. Morbi a volutpat justo. Suspendisse non diam lorem. Nulla hendrerit ut nisi sed mattis. Morbi vitae consequat velit, sit amet sollicitudin quam. Vestibulum dignissim eleifend mi, a tincidunt libero congue faucibus. Fusce semper posuere sapien, hendrerit molestie risus congue vitae. Ut eu auctor turpis. In hac habitasse platea dictumst. Etiam condimentum urna sit amet arcu venenatis, at commodo augue fermentum.',
        2,
        'new'
    ),
    (
        'Assassin''s Creed Odyssey',
        59.99,
        '2018-10-05',
        'images-jeux/Assassins-Creed-Odyssey.webp',
        'https://www.youtube.com/watch?v=VUR4Xs1K2WU',
        '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit turpis vitae ante maximus mollis id et dui. Phasellus convallis justo id ligula sagittis eleifend. Vestibulum vel finibus lectus. Nullam ac felis nibh. Aenean eu porta lorem. Fusce vestibulum lorem id porta accumsan. Curabitur sit amet ultrices mauris. Nunc tempus nibh facilisis dolor pretium, tempor pretium leo suscipit. Ut consectetur nunc nisi, quis ornare lorem fringilla ac. Sed fringilla risus sodales, eleifend lectus ac, interdum lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris et egestas purus, id egestas nisi.

Cras non mattis purus. Vivamus dignissim pulvinar orci, eu interdum quam hendrerit eget. Nunc elementum imperdiet volutpat. Phasellus enim nibh, lacinia sed orci eu, laoreet lacinia ligula. Morbi ullamcorper finibus magna eu interdum. Aenean nec dolor sed nunc dapibus malesuada vitae in massa. Nam semper mi risus, dictum vehicula nisi hendrerit ut. Ut posuere pulvinar ipsum in semper. Cras magna enim, hendrerit eget nisi ac, rutrum malesuada tortor. Pellentesque rutrum pretium mauris, sed tincidunt nunc dapibus non. Nunc semper neque felis, auctor fringilla justo faucibus ac. Aliquam imperdiet dapibus orci, ut bibendum libero iaculis id. Duis at mauris non felis scelerisque maximus. Ut nec nisl urna. Quisque ullamcorper arcu quis ante laoreet, vitae semper ex accumsan. Ut auctor id nisl vel rhoncus.

Nulla egestas massa in libero blandit, vel auctor mi feugiat. In non nulla vitae turpis sollicitudin consectetur a eget lacus. Mauris arcu ex, vestibulum in hendrerit id, blandit eu erat. Nullam nec commodo ex, vel hendrerit mi. Mauris vitae dolor ac purus dignissim varius. In vel faucibus erat, a commodo ante. Phasellus a nisi non arcu volutpat imperdiet vitae ac neque. Pellentesque convallis nunc et mi fermentum pharetra. Nullam tincidunt libero eu est finibus rhoncus. Proin eu lacus sed erat malesuada rhoncus vitae sed odio. Nullam tempus euismod elit, sit amet scelerisque ante tristique vel. In ac libero at diam pulvinar bibendum. Pellentesque gravida neque in ipsum sagittis bibendum.

Sed libero lectus, facilisis et volutpat in, congue vel ex. Morbi ac facilisis diam, eget pellentesque lectus. Vestibulum in ex in eros vulputate accumsan. Donec maximus velit tortor, at euismod purus commodo et. Curabitur vitae consequat lectus. Suspendisse vitae nunc elit. Quisque nec bibendum urna, maximus lobortis metus. Integer tincidunt pulvinar dui, sed euismod metus pulvinar vitae. Aenean lacus augue, consequat quis commodo sed, imperdiet nec risus. Aliquam imperdiet, nisi id aliquam pellentesque, libero magna consequat est, ac facilisis nunc enim id ipsum. Nunc ullamcorper interdum quam, sed facilisis mi porttitor non. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer maximus tortor dui, pulvinar pretium neque tempus quis. Nullam fringilla, urna eu commodo eleifend, nunc velit egestas felis, vel consequat purus leo vel orci. Sed fringilla pellentesque magna.

Nullam eget faucibus risus. Ut tellus tellus, scelerisque sit amet risus nec, mattis condimentum augue. Donec orci justo, aliquet a quam sed, pulvinar sagittis augue. Mauris venenatis dolor eu lacus mattis, vel accumsan velit laoreet. Nulla dapibus vulputate volutpat. Sed eget dictum elit. Morbi a volutpat justo. Suspendisse non diam lorem. Nulla hendrerit ut nisi sed mattis. Morbi vitae consequat velit, sit amet sollicitudin quam. Vestibulum dignissim eleifend mi, a tincidunt libero congue faucibus. Fusce semper posuere sapien, hendrerit molestie risus congue vitae. Ut eu auctor turpis. In hac habitasse platea dictumst. Etiam condimentum urna sit amet arcu venenatis, at commodo augue fermentum.',
        2,
        NULL
    ),
    (
        'Call of Duty: Black Ops II',
        59.99,
        '2012-12-13',
        'images-jeux/Call-of-Duty-Black-Ops-II.webp',
        '',
        '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit turpis vitae ante maximus mollis id et dui. Phasellus convallis justo id ligula sagittis eleifend. Vestibulum vel finibus lectus. Nullam ac felis nibh. Aenean eu porta lorem. Fusce vestibulum lorem id porta accumsan. Curabitur sit amet ultrices mauris. Nunc tempus nibh facilisis dolor pretium, tempor pretium leo suscipit. Ut consectetur nunc nisi, quis ornare lorem fringilla ac. Sed fringilla risus sodales, eleifend lectus ac, interdum lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris et egestas purus, id egestas nisi.

Cras non mattis purus. Vivamus dignissim pulvinar orci, eu interdum quam hendrerit eget. Nunc elementum imperdiet volutpat. Phasellus enim nibh, lacinia sed orci eu, laoreet lacinia ligula. Morbi ullamcorper finibus magna eu interdum. Aenean nec dolor sed nunc dapibus malesuada vitae in massa. Nam semper mi risus, dictum vehicula nisi hendrerit ut. Ut posuere pulvinar ipsum in semper. Cras magna enim, hendrerit eget nisi ac, rutrum malesuada tortor. Pellentesque rutrum pretium mauris, sed tincidunt nunc dapibus non. Nunc semper neque felis, auctor fringilla justo faucibus ac. Aliquam imperdiet dapibus orci, ut bibendum libero iaculis id. Duis at mauris non felis scelerisque maximus. Ut nec nisl urna. Quisque ullamcorper arcu quis ante laoreet, vitae semper ex accumsan. Ut auctor id nisl vel rhoncus.

Nulla egestas massa in libero blandit, vel auctor mi feugiat. In non nulla vitae turpis sollicitudin consectetur a eget lacus. Mauris arcu ex, vestibulum in hendrerit id, blandit eu erat. Nullam nec commodo ex, vel hendrerit mi. Mauris vitae dolor ac purus dignissim varius. In vel faucibus erat, a commodo ante. Phasellus a nisi non arcu volutpat imperdiet vitae ac neque. Pellentesque convallis nunc et mi fermentum pharetra. Nullam tincidunt libero eu est finibus rhoncus. Proin eu lacus sed erat malesuada rhoncus vitae sed odio. Nullam tempus euismod elit, sit amet scelerisque ante tristique vel. In ac libero at diam pulvinar bibendum. Pellentesque gravida neque in ipsum sagittis bibendum.

Sed libero lectus, facilisis et volutpat in, congue vel ex. Morbi ac facilisis diam, eget pellentesque lectus. Vestibulum in ex in eros vulputate accumsan. Donec maximus velit tortor, at euismod purus commodo et. Curabitur vitae consequat lectus. Suspendisse vitae nunc elit. Quisque nec bibendum urna, maximus lobortis metus. Integer tincidunt pulvinar dui, sed euismod metus pulvinar vitae. Aenean lacus augue, consequat quis commodo sed, imperdiet nec risus. Aliquam imperdiet, nisi id aliquam pellentesque, libero magna consequat est, ac facilisis nunc enim id ipsum. Nunc ullamcorper interdum quam, sed facilisis mi porttitor non. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer maximus tortor dui, pulvinar pretium neque tempus quis. Nullam fringilla, urna eu commodo eleifend, nunc velit egestas felis, vel consequat purus leo vel orci. Sed fringilla pellentesque magna.

Nullam eget faucibus risus. Ut tellus tellus, scelerisque sit amet risus nec, mattis condimentum augue. Donec orci justo, aliquet a quam sed, pulvinar sagittis augue. Mauris venenatis dolor eu lacus mattis, vel accumsan velit laoreet. Nulla dapibus vulputate volutpat. Sed eget dictum elit. Morbi a volutpat justo. Suspendisse non diam lorem. Nulla hendrerit ut nisi sed mattis. Morbi vitae consequat velit, sit amet sollicitudin quam. Vestibulum dignissim eleifend mi, a tincidunt libero congue faucibus. Fusce semper posuere sapien, hendrerit molestie risus congue vitae. Ut eu auctor turpis. In hac habitasse platea dictumst. Etiam condimentum urna sit amet arcu venenatis, at commodo augue fermentum.',
        3,
        NULL
    ),
    (
        'Call of Duty 4: Modern Warfare',
        19.99,
        '2007-11-06',
        'images-jeux/Call-of-Duty-4-Modern-Warfare.webp',
        '',
        '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit turpis vitae ante maximus mollis id et dui. Phasellus convallis justo id ligula sagittis eleifend. Vestibulum vel finibus lectus. Nullam ac felis nibh. Aenean eu porta lorem. Fusce vestibulum lorem id porta accumsan. Curabitur sit amet ultrices mauris. Nunc tempus nibh facilisis dolor pretium, tempor pretium leo suscipit. Ut consectetur nunc nisi, quis ornare lorem fringilla ac. Sed fringilla risus sodales, eleifend lectus ac, interdum lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris et egestas purus, id egestas nisi.

Cras non mattis purus. Vivamus dignissim pulvinar orci, eu interdum quam hendrerit eget. Nunc elementum imperdiet volutpat. Phasellus enim nibh, lacinia sed orci eu, laoreet lacinia ligula. Morbi ullamcorper finibus magna eu interdum. Aenean nec dolor sed nunc dapibus malesuada vitae in massa. Nam semper mi risus, dictum vehicula nisi hendrerit ut. Ut posuere pulvinar ipsum in semper. Cras magna enim, hendrerit eget nisi ac, rutrum malesuada tortor. Pellentesque rutrum pretium mauris, sed tincidunt nunc dapibus non. Nunc semper neque felis, auctor fringilla justo faucibus ac. Aliquam imperdiet dapibus orci, ut bibendum libero iaculis id. Duis at mauris non felis scelerisque maximus. Ut nec nisl urna. Quisque ullamcorper arcu quis ante laoreet, vitae semper ex accumsan. Ut auctor id nisl vel rhoncus.

Nulla egestas massa in libero blandit, vel auctor mi feugiat. In non nulla vitae turpis sollicitudin consectetur a eget lacus. Mauris arcu ex, vestibulum in hendrerit id, blandit eu erat. Nullam nec commodo ex, vel hendrerit mi. Mauris vitae dolor ac purus dignissim varius. In vel faucibus erat, a commodo ante. Phasellus a nisi non arcu volutpat imperdiet vitae ac neque. Pellentesque convallis nunc et mi fermentum pharetra. Nullam tincidunt libero eu est finibus rhoncus. Proin eu lacus sed erat malesuada rhoncus vitae sed odio. Nullam tempus euismod elit, sit amet scelerisque ante tristique vel. In ac libero at diam pulvinar bibendum. Pellentesque gravida neque in ipsum sagittis bibendum.

Sed libero lectus, facilisis et volutpat in, congue vel ex. Morbi ac facilisis diam, eget pellentesque lectus. Vestibulum in ex in eros vulputate accumsan. Donec maximus velit tortor, at euismod purus commodo et. Curabitur vitae consequat lectus. Suspendisse vitae nunc elit. Quisque nec bibendum urna, maximus lobortis metus. Integer tincidunt pulvinar dui, sed euismod metus pulvinar vitae. Aenean lacus augue, consequat quis commodo sed, imperdiet nec risus. Aliquam imperdiet, nisi id aliquam pellentesque, libero magna consequat est, ac facilisis nunc enim id ipsum. Nunc ullamcorper interdum quam, sed facilisis mi porttitor non. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer maximus tortor dui, pulvinar pretium neque tempus quis. Nullam fringilla, urna eu commodo eleifend, nunc velit egestas felis, vel consequat purus leo vel orci. Sed fringilla pellentesque magna.

Nullam eget faucibus risus. Ut tellus tellus, scelerisque sit amet risus nec, mattis condimentum augue. Donec orci justo, aliquet a quam sed, pulvinar sagittis augue. Mauris venenatis dolor eu lacus mattis, vel accumsan velit laoreet. Nulla dapibus vulputate volutpat. Sed eget dictum elit. Morbi a volutpat justo. Suspendisse non diam lorem. Nulla hendrerit ut nisi sed mattis. Morbi vitae consequat velit, sit amet sollicitudin quam. Vestibulum dignissim eleifend mi, a tincidunt libero congue faucibus. Fusce semper posuere sapien, hendrerit molestie risus congue vitae. Ut eu auctor turpis. In hac habitasse platea dictumst. Etiam condimentum urna sit amet arcu venenatis, at commodo augue fermentum.',
        3,
        NULL
    ),
    (
        'DayZ',
        57.99,
        '2018-12-13',
        'images-jeux/DayZ.webp',
        '',
        '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit turpis vitae ante maximus mollis id et dui. Phasellus convallis justo id ligula sagittis eleifend. Vestibulum vel finibus lectus. Nullam ac felis nibh. Aenean eu porta lorem. Fusce vestibulum lorem id porta accumsan. Curabitur sit amet ultrices mauris. Nunc tempus nibh facilisis dolor pretium, tempor pretium leo suscipit. Ut consectetur nunc nisi, quis ornare lorem fringilla ac. Sed fringilla risus sodales, eleifend lectus ac, interdum lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris et egestas purus, id egestas nisi.

Cras non mattis purus. Vivamus dignissim pulvinar orci, eu interdum quam hendrerit eget. Nunc elementum imperdiet volutpat. Phasellus enim nibh, lacinia sed orci eu, laoreet lacinia ligula. Morbi ullamcorper finibus magna eu interdum. Aenean nec dolor sed nunc dapibus malesuada vitae in massa. Nam semper mi risus, dictum vehicula nisi hendrerit ut. Ut posuere pulvinar ipsum in semper. Cras magna enim, hendrerit eget nisi ac, rutrum malesuada tortor. Pellentesque rutrum pretium mauris, sed tincidunt nunc dapibus non. Nunc semper neque felis, auctor fringilla justo faucibus ac. Aliquam imperdiet dapibus orci, ut bibendum libero iaculis id. Duis at mauris non felis scelerisque maximus. Ut nec nisl urna. Quisque ullamcorper arcu quis ante laoreet, vitae semper ex accumsan. Ut auctor id nisl vel rhoncus.

Nulla egestas massa in libero blandit, vel auctor mi feugiat. In non nulla vitae turpis sollicitudin consectetur a eget lacus. Mauris arcu ex, vestibulum in hendrerit id, blandit eu erat. Nullam nec commodo ex, vel hendrerit mi. Mauris vitae dolor ac purus dignissim varius. In vel faucibus erat, a commodo ante. Phasellus a nisi non arcu volutpat imperdiet vitae ac neque. Pellentesque convallis nunc et mi fermentum pharetra. Nullam tincidunt libero eu est finibus rhoncus. Proin eu lacus sed erat malesuada rhoncus vitae sed odio. Nullam tempus euismod elit, sit amet scelerisque ante tristique vel. In ac libero at diam pulvinar bibendum. Pellentesque gravida neque in ipsum sagittis bibendum.

Sed libero lectus, facilisis et volutpat in, congue vel ex. Morbi ac facilisis diam, eget pellentesque lectus. Vestibulum in ex in eros vulputate accumsan. Donec maximus velit tortor, at euismod purus commodo et. Curabitur vitae consequat lectus. Suspendisse vitae nunc elit. Quisque nec bibendum urna, maximus lobortis metus. Integer tincidunt pulvinar dui, sed euismod metus pulvinar vitae. Aenean lacus augue, consequat quis commodo sed, imperdiet nec risus. Aliquam imperdiet, nisi id aliquam pellentesque, libero magna consequat est, ac facilisis nunc enim id ipsum. Nunc ullamcorper interdum quam, sed facilisis mi porttitor non. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer maximus tortor dui, pulvinar pretium neque tempus quis. Nullam fringilla, urna eu commodo eleifend, nunc velit egestas felis, vel consequat purus leo vel orci. Sed fringilla pellentesque magna.

Nullam eget faucibus risus. Ut tellus tellus, scelerisque sit amet risus nec, mattis condimentum augue. Donec orci justo, aliquet a quam sed, pulvinar sagittis augue. Mauris venenatis dolor eu lacus mattis, vel accumsan velit laoreet. Nulla dapibus vulputate volutpat. Sed eget dictum elit. Morbi a volutpat justo. Suspendisse non diam lorem. Nulla hendrerit ut nisi sed mattis. Morbi vitae consequat velit, sit amet sollicitudin quam. Vestibulum dignissim eleifend mi, a tincidunt libero congue faucibus. Fusce semper posuere sapien, hendrerit molestie risus congue vitae. Ut eu auctor turpis. In hac habitasse platea dictumst. Etiam condimentum urna sit amet arcu venenatis, at commodo augue fermentum.',
        15,
        NULL
    ),
    (
        'Fortnite',
        0,
        '2017-07-25',
        'images-jeux/Fortnite.webp',
        '',
        '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit turpis vitae ante maximus mollis id et dui. Phasellus convallis justo id ligula sagittis eleifend. Vestibulum vel finibus lectus. Nullam ac felis nibh. Aenean eu porta lorem. Fusce vestibulum lorem id porta accumsan. Curabitur sit amet ultrices mauris. Nunc tempus nibh facilisis dolor pretium, tempor pretium leo suscipit. Ut consectetur nunc nisi, quis ornare lorem fringilla ac. Sed fringilla risus sodales, eleifend lectus ac, interdum lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris et egestas purus, id egestas nisi.

Cras non mattis purus. Vivamus dignissim pulvinar orci, eu interdum quam hendrerit eget. Nunc elementum imperdiet volutpat. Phasellus enim nibh, lacinia sed orci eu, laoreet lacinia ligula. Morbi ullamcorper finibus magna eu interdum. Aenean nec dolor sed nunc dapibus malesuada vitae in massa. Nam semper mi risus, dictum vehicula nisi hendrerit ut. Ut posuere pulvinar ipsum in semper. Cras magna enim, hendrerit eget nisi ac, rutrum malesuada tortor. Pellentesque rutrum pretium mauris, sed tincidunt nunc dapibus non. Nunc semper neque felis, auctor fringilla justo faucibus ac. Aliquam imperdiet dapibus orci, ut bibendum libero iaculis id. Duis at mauris non felis scelerisque maximus. Ut nec nisl urna. Quisque ullamcorper arcu quis ante laoreet, vitae semper ex accumsan. Ut auctor id nisl vel rhoncus.

Nulla egestas massa in libero blandit, vel auctor mi feugiat. In non nulla vitae turpis sollicitudin consectetur a eget lacus. Mauris arcu ex, vestibulum in hendrerit id, blandit eu erat. Nullam nec commodo ex, vel hendrerit mi. Mauris vitae dolor ac purus dignissim varius. In vel faucibus erat, a commodo ante. Phasellus a nisi non arcu volutpat imperdiet vitae ac neque. Pellentesque convallis nunc et mi fermentum pharetra. Nullam tincidunt libero eu est finibus rhoncus. Proin eu lacus sed erat malesuada rhoncus vitae sed odio. Nullam tempus euismod elit, sit amet scelerisque ante tristique vel. In ac libero at diam pulvinar bibendum. Pellentesque gravida neque in ipsum sagittis bibendum.

Sed libero lectus, facilisis et volutpat in, congue vel ex. Morbi ac facilisis diam, eget pellentesque lectus. Vestibulum in ex in eros vulputate accumsan. Donec maximus velit tortor, at euismod purus commodo et. Curabitur vitae consequat lectus. Suspendisse vitae nunc elit. Quisque nec bibendum urna, maximus lobortis metus. Integer tincidunt pulvinar dui, sed euismod metus pulvinar vitae. Aenean lacus augue, consequat quis commodo sed, imperdiet nec risus. Aliquam imperdiet, nisi id aliquam pellentesque, libero magna consequat est, ac facilisis nunc enim id ipsum. Nunc ullamcorper interdum quam, sed facilisis mi porttitor non. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer maximus tortor dui, pulvinar pretium neque tempus quis. Nullam fringilla, urna eu commodo eleifend, nunc velit egestas felis, vel consequat purus leo vel orci. Sed fringilla pellentesque magna.

Nullam eget faucibus risus. Ut tellus tellus, scelerisque sit amet risus nec, mattis condimentum augue. Donec orci justo, aliquet a quam sed, pulvinar sagittis augue. Mauris venenatis dolor eu lacus mattis, vel accumsan velit laoreet. Nulla dapibus vulputate volutpat. Sed eget dictum elit. Morbi a volutpat justo. Suspendisse non diam lorem. Nulla hendrerit ut nisi sed mattis. Morbi vitae consequat velit, sit amet sollicitudin quam. Vestibulum dignissim eleifend mi, a tincidunt libero congue faucibus. Fusce semper posuere sapien, hendrerit molestie risus congue vitae. Ut eu auctor turpis. In hac habitasse platea dictumst. Etiam condimentum urna sit amet arcu venenatis, at commodo augue fermentum.',
        12,
        'trending'
    ),
    (
        'Genshin Impact',
        0,
        '2020-09-28',
        'images-jeux/Genshin-Impact.webp',
        '',
        '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit turpis vitae ante maximus mollis id et dui. Phasellus convallis justo id ligula sagittis eleifend. Vestibulum vel finibus lectus. Nullam ac felis nibh. Aenean eu porta lorem. Fusce vestibulum lorem id porta accumsan. Curabitur sit amet ultrices mauris. Nunc tempus nibh facilisis dolor pretium, tempor pretium leo suscipit. Ut consectetur nunc nisi, quis ornare lorem fringilla ac. Sed fringilla risus sodales, eleifend lectus ac, interdum lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris et egestas purus, id egestas nisi.

Cras non mattis purus. Vivamus dignissim pulvinar orci, eu interdum quam hendrerit eget. Nunc elementum imperdiet volutpat. Phasellus enim nibh, lacinia sed orci eu, laoreet lacinia ligula. Morbi ullamcorper finibus magna eu interdum. Aenean nec dolor sed nunc dapibus malesuada vitae in massa. Nam semper mi risus, dictum vehicula nisi hendrerit ut. Ut posuere pulvinar ipsum in semper. Cras magna enim, hendrerit eget nisi ac, rutrum malesuada tortor. Pellentesque rutrum pretium mauris, sed tincidunt nunc dapibus non. Nunc semper neque felis, auctor fringilla justo faucibus ac. Aliquam imperdiet dapibus orci, ut bibendum libero iaculis id. Duis at mauris non felis scelerisque maximus. Ut nec nisl urna. Quisque ullamcorper arcu quis ante laoreet, vitae semper ex accumsan. Ut auctor id nisl vel rhoncus.

Nulla egestas massa in libero blandit, vel auctor mi feugiat. In non nulla vitae turpis sollicitudin consectetur a eget lacus. Mauris arcu ex, vestibulum in hendrerit id, blandit eu erat. Nullam nec commodo ex, vel hendrerit mi. Mauris vitae dolor ac purus dignissim varius. In vel faucibus erat, a commodo ante. Phasellus a nisi non arcu volutpat imperdiet vitae ac neque. Pellentesque convallis nunc et mi fermentum pharetra. Nullam tincidunt libero eu est finibus rhoncus. Proin eu lacus sed erat malesuada rhoncus vitae sed odio. Nullam tempus euismod elit, sit amet scelerisque ante tristique vel. In ac libero at diam pulvinar bibendum. Pellentesque gravida neque in ipsum sagittis bibendum.

Sed libero lectus, facilisis et volutpat in, congue vel ex. Morbi ac facilisis diam, eget pellentesque lectus. Vestibulum in ex in eros vulputate accumsan. Donec maximus velit tortor, at euismod purus commodo et. Curabitur vitae consequat lectus. Suspendisse vitae nunc elit. Quisque nec bibendum urna, maximus lobortis metus. Integer tincidunt pulvinar dui, sed euismod metus pulvinar vitae. Aenean lacus augue, consequat quis commodo sed, imperdiet nec risus. Aliquam imperdiet, nisi id aliquam pellentesque, libero magna consequat est, ac facilisis nunc enim id ipsum. Nunc ullamcorper interdum quam, sed facilisis mi porttitor non. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer maximus tortor dui, pulvinar pretium neque tempus quis. Nullam fringilla, urna eu commodo eleifend, nunc velit egestas felis, vel consequat purus leo vel orci. Sed fringilla pellentesque magna.

Nullam eget faucibus risus. Ut tellus tellus, scelerisque sit amet risus nec, mattis condimentum augue. Donec orci justo, aliquet a quam sed, pulvinar sagittis augue. Mauris venenatis dolor eu lacus mattis, vel accumsan velit laoreet. Nulla dapibus vulputate volutpat. Sed eget dictum elit. Morbi a volutpat justo. Suspendisse non diam lorem. Nulla hendrerit ut nisi sed mattis. Morbi vitae consequat velit, sit amet sollicitudin quam. Vestibulum dignissim eleifend mi, a tincidunt libero congue faucibus. Fusce semper posuere sapien, hendrerit molestie risus congue vitae. Ut eu auctor turpis. In hac habitasse platea dictumst. Etiam condimentum urna sit amet arcu venenatis, at commodo augue fermentum.',
        13,
        'trending'
    ),
    (
        'Grand Theft Auto VI',
        99.99,
        '2026-11-19',
        'images-jeux/Grand-Theft-Auto-VI.webp',
        '',
        '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit turpis vitae ante maximus mollis id et dui. Phasellus convallis justo id ligula sagittis eleifend. Vestibulum vel finibus lectus. Nullam ac felis nibh. Aenean eu porta lorem. Fusce vestibulum lorem id porta accumsan. Curabitur sit amet ultrices mauris. Nunc tempus nibh facilisis dolor pretium, tempor pretium leo suscipit. Ut consectetur nunc nisi, quis ornare lorem fringilla ac. Sed fringilla risus sodales, eleifend lectus ac, interdum lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris et egestas purus, id egestas nisi.

Cras non mattis purus. Vivamus dignissim pulvinar orci, eu interdum quam hendrerit eget. Nunc elementum imperdiet volutpat. Phasellus enim nibh, lacinia sed orci eu, laoreet lacinia ligula. Morbi ullamcorper finibus magna eu interdum. Aenean nec dolor sed nunc dapibus malesuada vitae in massa. Nam semper mi risus, dictum vehicula nisi hendrerit ut. Ut posuere pulvinar ipsum in semper. Cras magna enim, hendrerit eget nisi ac, rutrum malesuada tortor. Pellentesque rutrum pretium mauris, sed tincidunt nunc dapibus non. Nunc semper neque felis, auctor fringilla justo faucibus ac. Aliquam imperdiet dapibus orci, ut bibendum libero iaculis id. Duis at mauris non felis scelerisque maximus. Ut nec nisl urna. Quisque ullamcorper arcu quis ante laoreet, vitae semper ex accumsan. Ut auctor id nisl vel rhoncus.

Nulla egestas massa in libero blandit, vel auctor mi feugiat. In non nulla vitae turpis sollicitudin consectetur a eget lacus. Mauris arcu ex, vestibulum in hendrerit id, blandit eu erat. Nullam nec commodo ex, vel hendrerit mi. Mauris vitae dolor ac purus dignissim varius. In vel faucibus erat, a commodo ante. Phasellus a nisi non arcu volutpat imperdiet vitae ac neque. Pellentesque convallis nunc et mi fermentum pharetra. Nullam tincidunt libero eu est finibus rhoncus. Proin eu lacus sed erat malesuada rhoncus vitae sed odio. Nullam tempus euismod elit, sit amet scelerisque ante tristique vel. In ac libero at diam pulvinar bibendum. Pellentesque gravida neque in ipsum sagittis bibendum.

Sed libero lectus, facilisis et volutpat in, congue vel ex. Morbi ac facilisis diam, eget pellentesque lectus. Vestibulum in ex in eros vulputate accumsan. Donec maximus velit tortor, at euismod purus commodo et. Curabitur vitae consequat lectus. Suspendisse vitae nunc elit. Quisque nec bibendum urna, maximus lobortis metus. Integer tincidunt pulvinar dui, sed euismod metus pulvinar vitae. Aenean lacus augue, consequat quis commodo sed, imperdiet nec risus. Aliquam imperdiet, nisi id aliquam pellentesque, libero magna consequat est, ac facilisis nunc enim id ipsum. Nunc ullamcorper interdum quam, sed facilisis mi porttitor non. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer maximus tortor dui, pulvinar pretium neque tempus quis. Nullam fringilla, urna eu commodo eleifend, nunc velit egestas felis, vel consequat purus leo vel orci. Sed fringilla pellentesque magna.

Nullam eget faucibus risus. Ut tellus tellus, scelerisque sit amet risus nec, mattis condimentum augue. Donec orci justo, aliquet a quam sed, pulvinar sagittis augue. Mauris venenatis dolor eu lacus mattis, vel accumsan velit laoreet. Nulla dapibus vulputate volutpat. Sed eget dictum elit. Morbi a volutpat justo. Suspendisse non diam lorem. Nulla hendrerit ut nisi sed mattis. Morbi vitae consequat velit, sit amet sollicitudin quam. Vestibulum dignissim eleifend mi, a tincidunt libero congue faucibus. Fusce semper posuere sapien, hendrerit molestie risus congue vitae. Ut eu auctor turpis. In hac habitasse platea dictumst. Etiam condimentum urna sit amet arcu venenatis, at commodo augue fermentum.',
        1,
        'coming_soon'
    ),
    (
        'League of Legends',
        0,
        '2009-10-27',
        'images-jeux/League-of-Legends.webp',
        '',
        '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit turpis vitae ante maximus mollis id et dui. Phasellus convallis justo id ligula sagittis eleifend. Vestibulum vel finibus lectus. Nullam ac felis nibh. Aenean eu porta lorem. Fusce vestibulum lorem id porta accumsan. Curabitur sit amet ultrices mauris. Nunc tempus nibh facilisis dolor pretium, tempor pretium leo suscipit. Ut consectetur nunc nisi, quis ornare lorem fringilla ac. Sed fringilla risus sodales, eleifend lectus ac, interdum lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris et egestas purus, id egestas nisi.

Cras non mattis purus. Vivamus dignissim pulvinar orci, eu interdum quam hendrerit eget. Nunc elementum imperdiet volutpat. Phasellus enim nibh, lacinia sed orci eu, laoreet lacinia ligula. Morbi ullamcorper finibus magna eu interdum. Aenean nec dolor sed nunc dapibus malesuada vitae in massa. Nam semper mi risus, dictum vehicula nisi hendrerit ut. Ut posuere pulvinar ipsum in semper. Cras magna enim, hendrerit eget nisi ac, rutrum malesuada tortor. Pellentesque rutrum pretium mauris, sed tincidunt nunc dapibus non. Nunc semper neque felis, auctor fringilla justo faucibus ac. Aliquam imperdiet dapibus orci, ut bibendum libero iaculis id. Duis at mauris non felis scelerisque maximus. Ut nec nisl urna. Quisque ullamcorper arcu quis ante laoreet, vitae semper ex accumsan. Ut auctor id nisl vel rhoncus.

Nulla egestas massa in libero blandit, vel auctor mi feugiat. In non nulla vitae turpis sollicitudin consectetur a eget lacus. Mauris arcu ex, vestibulum in hendrerit id, blandit eu erat. Nullam nec commodo ex, vel hendrerit mi. Mauris vitae dolor ac purus dignissim varius. In vel faucibus erat, a commodo ante. Phasellus a nisi non arcu volutpat imperdiet vitae ac neque. Pellentesque convallis nunc et mi fermentum pharetra. Nullam tincidunt libero eu est finibus rhoncus. Proin eu lacus sed erat malesuada rhoncus vitae sed odio. Nullam tempus euismod elit, sit amet scelerisque ante tristique vel. In ac libero at diam pulvinar bibendum. Pellentesque gravida neque in ipsum sagittis bibendum.

Sed libero lectus, facilisis et volutpat in, congue vel ex. Morbi ac facilisis diam, eget pellentesque lectus. Vestibulum in ex in eros vulputate accumsan. Donec maximus velit tortor, at euismod purus commodo et. Curabitur vitae consequat lectus. Suspendisse vitae nunc elit. Quisque nec bibendum urna, maximus lobortis metus. Integer tincidunt pulvinar dui, sed euismod metus pulvinar vitae. Aenean lacus augue, consequat quis commodo sed, imperdiet nec risus. Aliquam imperdiet, nisi id aliquam pellentesque, libero magna consequat est, ac facilisis nunc enim id ipsum. Nunc ullamcorper interdum quam, sed facilisis mi porttitor non. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer maximus tortor dui, pulvinar pretium neque tempus quis. Nullam fringilla, urna eu commodo eleifend, nunc velit egestas felis, vel consequat purus leo vel orci. Sed fringilla pellentesque magna.

Nullam eget faucibus risus. Ut tellus tellus, scelerisque sit amet risus nec, mattis condimentum augue. Donec orci justo, aliquet a quam sed, pulvinar sagittis augue. Mauris venenatis dolor eu lacus mattis, vel accumsan velit laoreet. Nulla dapibus vulputate volutpat. Sed eget dictum elit. Morbi a volutpat justo. Suspendisse non diam lorem. Nulla hendrerit ut nisi sed mattis. Morbi vitae consequat velit, sit amet sollicitudin quam. Vestibulum dignissim eleifend mi, a tincidunt libero congue faucibus. Fusce semper posuere sapien, hendrerit molestie risus congue vitae. Ut eu auctor turpis. In hac habitasse platea dictumst. Etiam condimentum urna sit amet arcu venenatis, at commodo augue fermentum.',
        11,
        'trending'
    ),
    (
        'Minecraft',
        29.99,
        '2011-11-18',
        'images-jeux/Minecraft.webp',
        '',
        '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit turpis vitae ante maximus mollis id et dui. Phasellus convallis justo id ligula sagittis eleifend. Vestibulum vel finibus lectus. Nullam ac felis nibh. Aenean eu porta lorem. Fusce vestibulum lorem id porta accumsan. Curabitur sit amet ultrices mauris. Nunc tempus nibh facilisis dolor pretium, tempor pretium leo suscipit. Ut consectetur nunc nisi, quis ornare lorem fringilla ac. Sed fringilla risus sodales, eleifend lectus ac, interdum lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris et egestas purus, id egestas nisi.

Cras non mattis purus. Vivamus dignissim pulvinar orci, eu interdum quam hendrerit eget. Nunc elementum imperdiet volutpat. Phasellus enim nibh, lacinia sed orci eu, laoreet lacinia ligula. Morbi ullamcorper finibus magna eu interdum. Aenean nec dolor sed nunc dapibus malesuada vitae in massa. Nam semper mi risus, dictum vehicula nisi hendrerit ut. Ut posuere pulvinar ipsum in semper. Cras magna enim, hendrerit eget nisi ac, rutrum malesuada tortor. Pellentesque rutrum pretium mauris, sed tincidunt nunc dapibus non. Nunc semper neque felis, auctor fringilla justo faucibus ac. Aliquam imperdiet dapibus orci, ut bibendum libero iaculis id. Duis at mauris non felis scelerisque maximus. Ut nec nisl urna. Quisque ullamcorper arcu quis ante laoreet, vitae semper ex accumsan. Ut auctor id nisl vel rhoncus.

Nulla egestas massa in libero blandit, vel auctor mi feugiat. In non nulla vitae turpis sollicitudin consectetur a eget lacus. Mauris arcu ex, vestibulum in hendrerit id, blandit eu erat. Nullam nec commodo ex, vel hendrerit mi. Mauris vitae dolor ac purus dignissim varius. In vel faucibus erat, a commodo ante. Phasellus a nisi non arcu volutpat imperdiet vitae ac neque. Pellentesque convallis nunc et mi fermentum pharetra. Nullam tincidunt libero eu est finibus rhoncus. Proin eu lacus sed erat malesuada rhoncus vitae sed odio. Nullam tempus euismod elit, sit amet scelerisque ante tristique vel. In ac libero at diam pulvinar bibendum. Pellentesque gravida neque in ipsum sagittis bibendum.

Sed libero lectus, facilisis et volutpat in, congue vel ex. Morbi ac facilisis diam, eget pellentesque lectus. Vestibulum in ex in eros vulputate accumsan. Donec maximus velit tortor, at euismod purus commodo et. Curabitur vitae consequat lectus. Suspendisse vitae nunc elit. Quisque nec bibendum urna, maximus lobortis metus. Integer tincidunt pulvinar dui, sed euismod metus pulvinar vitae. Aenean lacus augue, consequat quis commodo sed, imperdiet nec risus. Aliquam imperdiet, nisi id aliquam pellentesque, libero magna consequat est, ac facilisis nunc enim id ipsum. Nunc ullamcorper interdum quam, sed facilisis mi porttitor non. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer maximus tortor dui, pulvinar pretium neque tempus quis. Nullam fringilla, urna eu commodo eleifend, nunc velit egestas felis, vel consequat purus leo vel orci. Sed fringilla pellentesque magna.

Nullam eget faucibus risus. Ut tellus tellus, scelerisque sit amet risus nec, mattis condimentum augue. Donec orci justo, aliquet a quam sed, pulvinar sagittis augue. Mauris venenatis dolor eu lacus mattis, vel accumsan velit laoreet. Nulla dapibus vulputate volutpat. Sed eget dictum elit. Morbi a volutpat justo. Suspendisse non diam lorem. Nulla hendrerit ut nisi sed mattis. Morbi vitae consequat velit, sit amet sollicitudin quam. Vestibulum dignissim eleifend mi, a tincidunt libero congue faucibus. Fusce semper posuere sapien, hendrerit molestie risus congue vitae. Ut eu auctor turpis. In hac habitasse platea dictumst. Etiam condimentum urna sit amet arcu venenatis, at commodo augue fermentum.',
        14,
        'trending'
    ),
    (
        'Call of Duty: Modern Warfare 2',
        19.99,
        '2009-11-10',
        'images-jeux/Call-of-Duty-Modern-Warfare-2.webp',
        '',
        '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit turpis vitae ante maximus mollis id et dui. Phasellus convallis justo id ligula sagittis eleifend. Vestibulum vel finibus lectus. Nullam ac felis nibh. Aenean eu porta lorem. Fusce vestibulum lorem id porta accumsan. Curabitur sit amet ultrices mauris. Nunc tempus nibh facilisis dolor pretium, tempor pretium leo suscipit. Ut consectetur nunc nisi, quis ornare lorem fringilla ac. Sed fringilla risus sodales, eleifend lectus ac, interdum lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris et egestas purus, id egestas nisi.

Cras non mattis purus. Vivamus dignissim pulvinar orci, eu interdum quam hendrerit eget. Nunc elementum imperdiet volutpat. Phasellus enim nibh, lacinia sed orci eu, laoreet lacinia ligula. Morbi ullamcorper finibus magna eu interdum. Aenean nec dolor sed nunc dapibus malesuada vitae in massa. Nam semper mi risus, dictum vehicula nisi hendrerit ut. Ut posuere pulvinar ipsum in semper. Cras magna enim, hendrerit eget nisi ac, rutrum malesuada tortor. Pellentesque rutrum pretium mauris, sed tincidunt nunc dapibus non. Nunc semper neque felis, auctor fringilla justo faucibus ac. Aliquam imperdiet dapibus orci, ut bibendum libero iaculis id. Duis at mauris non felis scelerisque maximus. Ut nec nisl urna. Quisque ullamcorper arcu quis ante laoreet, vitae semper ex accumsan. Ut auctor id nisl vel rhoncus.

Nulla egestas massa in libero blandit, vel auctor mi feugiat. In non nulla vitae turpis sollicitudin consectetur a eget lacus. Mauris arcu ex, vestibulum in hendrerit id, blandit eu erat. Nullam nec commodo ex, vel hendrerit mi. Mauris vitae dolor ac purus dignissim varius. In vel faucibus erat, a commodo ante. Phasellus a nisi non arcu volutpat imperdiet vitae ac neque. Pellentesque convallis nunc et mi fermentum pharetra. Nullam tincidunt libero eu est finibus rhoncus. Proin eu lacus sed erat malesuada rhoncus vitae sed odio. Nullam tempus euismod elit, sit amet scelerisque ante tristique vel. In ac libero at diam pulvinar bibendum. Pellentesque gravida neque in ipsum sagittis bibendum.

Sed libero lectus, facilisis et volutpat in, congue vel ex. Morbi ac facilisis diam, eget pellentesque lectus. Vestibulum in ex in eros vulputate accumsan. Donec maximus velit tortor, at euismod purus commodo et. Curabitur vitae consequat lectus. Suspendisse vitae nunc elit. Quisque nec bibendum urna, maximus lobortis metus. Integer tincidunt pulvinar dui, sed euismod metus pulvinar vitae. Aenean lacus augue, consequat quis commodo sed, imperdiet nec risus. Aliquam imperdiet, nisi id aliquam pellentesque, libero magna consequat est, ac facilisis nunc enim id ipsum. Nunc ullamcorper interdum quam, sed facilisis mi porttitor non. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer maximus tortor dui, pulvinar pretium neque tempus quis. Nullam fringilla, urna eu commodo eleifend, nunc velit egestas felis, vel consequat purus leo vel orci. Sed fringilla pellentesque magna.

Nullam eget faucibus risus. Ut tellus tellus, scelerisque sit amet risus nec, mattis condimentum augue. Donec orci justo, aliquet a quam sed, pulvinar sagittis augue. Mauris venenatis dolor eu lacus mattis, vel accumsan velit laoreet. Nulla dapibus vulputate volutpat. Sed eget dictum elit. Morbi a volutpat justo. Suspendisse non diam lorem. Nulla hendrerit ut nisi sed mattis. Morbi vitae consequat velit, sit amet sollicitudin quam. Vestibulum dignissim eleifend mi, a tincidunt libero congue faucibus. Fusce semper posuere sapien, hendrerit molestie risus congue vitae. Ut eu auctor turpis. In hac habitasse platea dictumst. Etiam condimentum urna sit amet arcu venenatis, at commodo augue fermentum.',
        3,
        'trending'
    ),
    (
        'Rocket League',
        0,
        '2015-07-07',
        'images-jeux/Rocket-League.jpg',
        '',
        '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit turpis vitae ante maximus mollis id et dui. Phasellus convallis justo id ligula sagittis eleifend. Vestibulum vel finibus lectus. Nullam ac felis nibh. Aenean eu porta lorem. Fusce vestibulum lorem id porta accumsan. Curabitur sit amet ultrices mauris. Nunc tempus nibh facilisis dolor pretium, tempor pretium leo suscipit. Ut consectetur nunc nisi, quis ornare lorem fringilla ac. Sed fringilla risus sodales, eleifend lectus ac, interdum lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris et egestas purus, id egestas nisi.

Cras non mattis purus. Vivamus dignissim pulvinar orci, eu interdum quam hendrerit eget. Nunc elementum imperdiet volutpat. Phasellus enim nibh, lacinia sed orci eu, laoreet lacinia ligula. Morbi ullamcorper finibus magna eu interdum. Aenean nec dolor sed nunc dapibus malesuada vitae in massa. Nam semper mi risus, dictum vehicula nisi hendrerit ut. Ut posuere pulvinar ipsum in semper. Cras magna enim, hendrerit eget nisi ac, rutrum malesuada tortor. Pellentesque rutrum pretium mauris, sed tincidunt nunc dapibus non. Nunc semper neque felis, auctor fringilla justo faucibus ac. Aliquam imperdiet dapibus orci, ut bibendum libero iaculis id. Duis at mauris non felis scelerisque maximus. Ut nec nisl urna. Quisque ullamcorper arcu quis ante laoreet, vitae semper ex accumsan. Ut auctor id nisl vel rhoncus.

Nulla egestas massa in libero blandit, vel auctor mi feugiat. In non nulla vitae turpis sollicitudin consectetur a eget lacus. Mauris arcu ex, vestibulum in hendrerit id, blandit eu erat. Nullam nec commodo ex, vel hendrerit mi. Mauris vitae dolor ac purus dignissim varius. In vel faucibus erat, a commodo ante. Phasellus a nisi non arcu volutpat imperdiet vitae ac neque. Pellentesque convallis nunc et mi fermentum pharetra. Nullam tincidunt libero eu est finibus rhoncus. Proin eu lacus sed erat malesuada rhoncus vitae sed odio. Nullam tempus euismod elit, sit amet scelerisque ante tristique vel. In ac libero at diam pulvinar bibendum. Pellentesque gravida neque in ipsum sagittis bibendum.

Sed libero lectus, facilisis et volutpat in, congue vel ex. Morbi ac facilisis diam, eget pellentesque lectus. Vestibulum in ex in eros vulputate accumsan. Donec maximus velit tortor, at euismod purus commodo et. Curabitur vitae consequat lectus. Suspendisse vitae nunc elit. Quisque nec bibendum urna, maximus lobortis metus. Integer tincidunt pulvinar dui, sed euismod metus pulvinar vitae. Aenean lacus augue, consequat quis commodo sed, imperdiet nec risus. Aliquam imperdiet, nisi id aliquam pellentesque, libero magna consequat est, ac facilisis nunc enim id ipsum. Nunc ullamcorper interdum quam, sed facilisis mi porttitor non. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer maximus tortor dui, pulvinar pretium neque tempus quis. Nullam fringilla, urna eu commodo eleifend, nunc velit egestas felis, vel consequat purus leo vel orci. Sed fringilla pellentesque magna.

Nullam eget faucibus risus. Ut tellus tellus, scelerisque sit amet risus nec, mattis condimentum augue. Donec orci justo, aliquet a quam sed, pulvinar sagittis augue. Mauris venenatis dolor eu lacus mattis, vel accumsan velit laoreet. Nulla dapibus vulputate volutpat. Sed eget dictum elit. Morbi a volutpat justo. Suspendisse non diam lorem. Nulla hendrerit ut nisi sed mattis. Morbi vitae consequat velit, sit amet sollicitudin quam. Vestibulum dignissim eleifend mi, a tincidunt libero congue faucibus. Fusce semper posuere sapien, hendrerit molestie risus congue vitae. Ut eu auctor turpis. In hac habitasse platea dictumst. Etiam condimentum urna sit amet arcu venenatis, at commodo augue fermentum.',
        6,
        'trending'
    ),
    (
        'Warframe',
        0,
        '2013-03-25',
        'images-jeux/Warframe.webp',
        '',
        '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit turpis vitae ante maximus mollis id et dui. Phasellus convallis justo id ligula sagittis eleifend. Vestibulum vel finibus lectus. Nullam ac felis nibh. Aenean eu porta lorem. Fusce vestibulum lorem id porta accumsan. Curabitur sit amet ultrices mauris. Nunc tempus nibh facilisis dolor pretium, tempor pretium leo suscipit. Ut consectetur nunc nisi, quis ornare lorem fringilla ac. Sed fringilla risus sodales, eleifend lectus ac, interdum lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris et egestas purus, id egestas nisi.

Cras non mattis purus. Vivamus dignissim pulvinar orci, eu interdum quam hendrerit eget. Nunc elementum imperdiet volutpat. Phasellus enim nibh, lacinia sed orci eu, laoreet lacinia ligula. Morbi ullamcorper finibus magna eu interdum. Aenean nec dolor sed nunc dapibus malesuada vitae in massa. Nam semper mi risus, dictum vehicula nisi hendrerit ut. Ut posuere pulvinar ipsum in semper. Cras magna enim, hendrerit eget nisi ac, rutrum malesuada tortor. Pellentesque rutrum pretium mauris, sed tincidunt nunc dapibus non. Nunc semper neque felis, auctor fringilla justo faucibus ac. Aliquam imperdiet dapibus orci, ut bibendum libero iaculis id. Duis at mauris non felis scelerisque maximus. Ut nec nisl urna. Quisque ullamcorper arcu quis ante laoreet, vitae semper ex accumsan. Ut auctor id nisl vel rhoncus.

Nulla egestas massa in libero blandit, vel auctor mi feugiat. In non nulla vitae turpis sollicitudin consectetur a eget lacus. Mauris arcu ex, vestibulum in hendrerit id, blandit eu erat. Nullam nec commodo ex, vel hendrerit mi. Mauris vitae dolor ac purus dignissim varius. In vel faucibus erat, a commodo ante. Phasellus a nisi non arcu volutpat imperdiet vitae ac neque. Pellentesque convallis nunc et mi fermentum pharetra. Nullam tincidunt libero eu est finibus rhoncus. Proin eu lacus sed erat malesuada rhoncus vitae sed odio. Nullam tempus euismod elit, sit amet scelerisque ante tristique vel. In ac libero at diam pulvinar bibendum. Pellentesque gravida neque in ipsum sagittis bibendum.

Sed libero lectus, facilisis et volutpat in, congue vel ex. Morbi ac facilisis diam, eget pellentesque lectus. Vestibulum in ex in eros vulputate accumsan. Donec maximus velit tortor, at euismod purus commodo et. Curabitur vitae consequat lectus. Suspendisse vitae nunc elit. Quisque nec bibendum urna, maximus lobortis metus. Integer tincidunt pulvinar dui, sed euismod metus pulvinar vitae. Aenean lacus augue, consequat quis commodo sed, imperdiet nec risus. Aliquam imperdiet, nisi id aliquam pellentesque, libero magna consequat est, ac facilisis nunc enim id ipsum. Nunc ullamcorper interdum quam, sed facilisis mi porttitor non. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer maximus tortor dui, pulvinar pretium neque tempus quis. Nullam fringilla, urna eu commodo eleifend, nunc velit egestas felis, vel consequat purus leo vel orci. Sed fringilla pellentesque magna.

Nullam eget faucibus risus. Ut tellus tellus, scelerisque sit amet risus nec, mattis condimentum augue. Donec orci justo, aliquet a quam sed, pulvinar sagittis augue. Mauris venenatis dolor eu lacus mattis, vel accumsan velit laoreet. Nulla dapibus vulputate volutpat. Sed eget dictum elit. Morbi a volutpat justo. Suspendisse non diam lorem. Nulla hendrerit ut nisi sed mattis. Morbi vitae consequat velit, sit amet sollicitudin quam. Vestibulum dignissim eleifend mi, a tincidunt libero congue faucibus. Fusce semper posuere sapien, hendrerit molestie risus congue vitae. Ut eu auctor turpis. In hac habitasse platea dictumst. Etiam condimentum urna sit amet arcu venenatis, at commodo augue fermentum.',
        3,
        'trending'
    ),
    (
        'Wuthering Waves',
        0,
        '2024-05-22',
        'images-jeux/Wuthering-Waves.webp',
        '',
        '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit turpis vitae ante maximus mollis id et dui. Phasellus convallis justo id ligula sagittis eleifend. Vestibulum vel finibus lectus. Nullam ac felis nibh. Aenean eu porta lorem. Fusce vestibulum lorem id porta accumsan. Curabitur sit amet ultrices mauris. Nunc tempus nibh facilisis dolor pretium, tempor pretium leo suscipit. Ut consectetur nunc nisi, quis ornare lorem fringilla ac. Sed fringilla risus sodales, eleifend lectus ac, interdum lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris et egestas purus, id egestas nisi.

Cras non mattis purus. Vivamus dignissim pulvinar orci, eu interdum quam hendrerit eget. Nunc elementum imperdiet volutpat. Phasellus enim nibh, lacinia sed orci eu, laoreet lacinia ligula. Morbi ullamcorper finibus magna eu interdum. Aenean nec dolor sed nunc dapibus malesuada vitae in massa. Nam semper mi risus, dictum vehicula nisi hendrerit ut. Ut posuere pulvinar ipsum in semper. Cras magna enim, hendrerit eget nisi ac, rutrum malesuada tortor. Pellentesque rutrum pretium mauris, sed tincidunt nunc dapibus non. Nunc semper neque felis, auctor fringilla justo faucibus ac. Aliquam imperdiet dapibus orci, ut bibendum libero iaculis id. Duis at mauris non felis scelerisque maximus. Ut nec nisl urna. Quisque ullamcorper arcu quis ante laoreet, vitae semper ex accumsan. Ut auctor id nisl vel rhoncus.

Nulla egestas massa in libero blandit, vel auctor mi feugiat. In non nulla vitae turpis sollicitudin consectetur a eget lacus. Mauris arcu ex, vestibulum in hendrerit id, blandit eu erat. Nullam nec commodo ex, vel hendrerit mi. Mauris vitae dolor ac purus dignissim varius. In vel faucibus erat, a commodo ante. Phasellus a nisi non arcu volutpat imperdiet vitae ac neque. Pellentesque convallis nunc et mi fermentum pharetra. Nullam tincidunt libero eu est finibus rhoncus. Proin eu lacus sed erat malesuada rhoncus vitae sed odio. Nullam tempus euismod elit, sit amet scelerisque ante tristique vel. In ac libero at diam pulvinar bibendum. Pellentesque gravida neque in ipsum sagittis bibendum.

Sed libero lectus, facilisis et volutpat in, congue vel ex. Morbi ac facilisis diam, eget pellentesque lectus. Vestibulum in ex in eros vulputate accumsan. Donec maximus velit tortor, at euismod purus commodo et. Curabitur vitae consequat lectus. Suspendisse vitae nunc elit. Quisque nec bibendum urna, maximus lobortis metus. Integer tincidunt pulvinar dui, sed euismod metus pulvinar vitae. Aenean lacus augue, consequat quis commodo sed, imperdiet nec risus. Aliquam imperdiet, nisi id aliquam pellentesque, libero magna consequat est, ac facilisis nunc enim id ipsum. Nunc ullamcorper interdum quam, sed facilisis mi porttitor non. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer maximus tortor dui, pulvinar pretium neque tempus quis. Nullam fringilla, urna eu commodo eleifend, nunc velit egestas felis, vel consequat purus leo vel orci. Sed fringilla pellentesque magna.

Nullam eget faucibus risus. Ut tellus tellus, scelerisque sit amet risus nec, mattis condimentum augue. Donec orci justo, aliquet a quam sed, pulvinar sagittis augue. Mauris venenatis dolor eu lacus mattis, vel accumsan velit laoreet. Nulla dapibus vulputate volutpat. Sed eget dictum elit. Morbi a volutpat justo. Suspendisse non diam lorem. Nulla hendrerit ut nisi sed mattis. Morbi vitae consequat velit, sit amet sollicitudin quam. Vestibulum dignissim eleifend mi, a tincidunt libero congue faucibus. Fusce semper posuere sapien, hendrerit molestie risus congue vitae. Ut eu auctor turpis. In hac habitasse platea dictumst. Etiam condimentum urna sit amet arcu venenatis, at commodo augue fermentum.',
        13,
        'new'
    ),
    (
        'Tom Clancy''s Rainbow Six Siege',
        0,
        '2015-12-01',
        'images-jeux/Tom-Clancys-Rainbow-Six-Siege.webp',
        '',
        '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit turpis vitae ante maximus mollis id et dui. Phasellus convallis justo id ligula sagittis eleifend. Vestibulum vel finibus lectus. Nullam ac felis nibh. Aenean eu porta lorem. Fusce vestibulum lorem id porta accumsan. Curabitur sit amet ultrices mauris. Nunc tempus nibh facilisis dolor pretium, tempor pretium leo suscipit. Ut consectetur nunc nisi, quis ornare lorem fringilla ac. Sed fringilla risus sodales, eleifend lectus ac, interdum lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris et egestas purus, id egestas nisi.

Cras non mattis purus. Vivamus dignissim pulvinar orci, eu interdum quam hendrerit eget. Nunc elementum imperdiet volutpat. Phasellus enim nibh, lacinia sed orci eu, laoreet lacinia ligula. Morbi ullamcorper finibus magna eu interdum. Aenean nec dolor sed nunc dapibus malesuada vitae in massa. Nam semper mi risus, dictum vehicula nisi hendrerit ut. Ut posuere pulvinar ipsum in semper. Cras magna enim, hendrerit eget nisi ac, rutrum malesuada tortor. Pellentesque rutrum pretium mauris, sed tincidunt nunc dapibus non. Nunc semper neque felis, auctor fringilla justo faucibus ac. Aliquam imperdiet dapibus orci, ut bibendum libero iaculis id. Duis at mauris non felis scelerisque maximus. Ut nec nisl urna. Quisque ullamcorper arcu quis ante laoreet, vitae semper ex accumsan. Ut auctor id nisl vel rhoncus.

Nulla egestas massa in libero blandit, vel auctor mi feugiat. In non nulla vitae turpis sollicitudin consectetur a eget lacus. Mauris arcu ex, vestibulum in hendrerit id, blandit eu erat. Nullam nec commodo ex, vel hendrerit mi. Mauris vitae dolor ac purus dignissim varius. In vel faucibus erat, a commodo ante. Phasellus a nisi non arcu volutpat imperdiet vitae ac neque. Pellentesque convallis nunc et mi fermentum pharetra. Nullam tincidunt libero eu est finibus rhoncus. Proin eu lacus sed erat malesuada rhoncus vitae sed odio. Nullam tempus euismod elit, sit amet scelerisque ante tristique vel. In ac libero at diam pulvinar bibendum. Pellentesque gravida neque in ipsum sagittis bibendum.

Sed libero lectus, facilisis et volutpat in, congue vel ex. Morbi ac facilisis diam, eget pellentesque lectus. Vestibulum in ex in eros vulputate accumsan. Donec maximus velit tortor, at euismod purus commodo et. Curabitur vitae consequat lectus. Suspendisse vitae nunc elit. Quisque nec bibendum urna, maximus lobortis metus. Integer tincidunt pulvinar dui, sed euismod metus pulvinar vitae. Aenean lacus augue, consequat quis commodo sed, imperdiet nec risus. Aliquam imperdiet, nisi id aliquam pellentesque, libero magna consequat est, ac facilisis nunc enim id ipsum. Nunc ullamcorper interdum quam, sed facilisis mi porttitor non. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer maximus tortor dui, pulvinar pretium neque tempus quis. Nullam fringilla, urna eu commodo eleifend, nunc velit egestas felis, vel consequat purus leo vel orci. Sed fringilla pellentesque magna.

Nullam eget faucibus risus. Ut tellus tellus, scelerisque sit amet risus nec, mattis condimentum augue. Donec orci justo, aliquet a quam sed, pulvinar sagittis augue. Mauris venenatis dolor eu lacus mattis, vel accumsan velit laoreet. Nulla dapibus vulputate volutpat. Sed eget dictum elit. Morbi a volutpat justo. Suspendisse non diam lorem. Nulla hendrerit ut nisi sed mattis. Morbi vitae consequat velit, sit amet sollicitudin quam. Vestibulum dignissim eleifend mi, a tincidunt libero congue faucibus. Fusce semper posuere sapien, hendrerit molestie risus congue vitae. Ut eu auctor turpis. In hac habitasse platea dictumst. Etiam condimentum urna sit amet arcu venenatis, at commodo augue fermentum.',
        3,
        'trending'
    ),
    (
        'Sekiro: Shadows Die Twice',
        59.99,
        '2019-03-22',
        'images-jeux/Sekiro.webp',
        '',
        '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit turpis vitae ante maximus mollis id et dui. Phasellus convallis justo id ligula sagittis eleifend. Vestibulum vel finibus lectus. Nullam ac felis nibh. Aenean eu porta lorem. Fusce vestibulum lorem id porta accumsan. Curabitur sit amet ultrices mauris. Nunc tempus nibh facilisis dolor pretium, tempor pretium leo suscipit. Ut consectetur nunc nisi, quis ornare lorem fringilla ac. Sed fringilla risus sodales, eleifend lectus ac, interdum lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris et egestas purus, id egestas nisi.

Cras non mattis purus. Vivamus dignissim pulvinar orci, eu interdum quam hendrerit eget. Nunc elementum imperdiet volutpat. Phasellus enim nibh, lacinia sed orci eu, laoreet lacinia ligula. Morbi ullamcorper finibus magna eu interdum. Aenean nec dolor sed nunc dapibus malesuada vitae in massa. Nam semper mi risus, dictum vehicula nisi hendrerit ut. Ut posuere pulvinar ipsum in semper. Cras magna enim, hendrerit eget nisi ac, rutrum malesuada tortor. Pellentesque rutrum pretium mauris, sed tincidunt nunc dapibus non. Nunc semper neque felis, auctor fringilla justo faucibus ac. Aliquam imperdiet dapibus orci, ut bibendum libero iaculis id. Duis at mauris non felis scelerisque maximus. Ut nec nisl urna. Quisque ullamcorper arcu quis ante laoreet, vitae semper ex accumsan. Ut auctor id nisl vel rhoncus.

Nulla egestas massa in libero blandit, vel auctor mi feugiat. In non nulla vitae turpis sollicitudin consectetur a eget lacus. Mauris arcu ex, vestibulum in hendrerit id, blandit eu erat. Nullam nec commodo ex, vel hendrerit mi. Mauris vitae dolor ac purus dignissim varius. In vel faucibus erat, a commodo ante. Phasellus a nisi non arcu volutpat imperdiet vitae ac neque. Pellentesque convallis nunc et mi fermentum pharetra. Nullam tincidunt libero eu est finibus rhoncus. Proin eu lacus sed erat malesuada rhoncus vitae sed odio. Nullam tempus euismod elit, sit amet scelerisque ante tristique vel. In ac libero at diam pulvinar bibendum. Pellentesque gravida neque in ipsum sagittis bibendum.

Sed libero lectus, facilisis et volutpat in, congue vel ex. Morbi ac facilisis diam, eget pellentesque lectus. Vestibulum in ex in eros vulputate accumsan. Donec maximus velit tortor, at euismod purus commodo et. Curabitur vitae consequat lectus. Suspendisse vitae nunc elit. Quisque nec bibendum urna, maximus lobortis metus. Integer tincidunt pulvinar dui, sed euismod metus pulvinar vitae. Aenean lacus augue, consequat quis commodo sed, imperdiet nec risus. Aliquam imperdiet, nisi id aliquam pellentesque, libero magna consequat est, ac facilisis nunc enim id ipsum. Nunc ullamcorper interdum quam, sed facilisis mi porttitor non. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer maximus tortor dui, pulvinar pretium neque tempus quis. Nullam fringilla, urna eu commodo eleifend, nunc velit egestas felis, vel consequat purus leo vel orci. Sed fringilla pellentesque magna.

Nullam eget faucibus risus. Ut tellus tellus, scelerisque sit amet risus nec, mattis condimentum augue. Donec orci justo, aliquet a quam sed, pulvinar sagittis augue. Mauris venenatis dolor eu lacus mattis, vel accumsan velit laoreet. Nulla dapibus vulputate volutpat. Sed eget dictum elit. Morbi a volutpat justo. Suspendisse non diam lorem. Nulla hendrerit ut nisi sed mattis. Morbi vitae consequat velit, sit amet sollicitudin quam. Vestibulum dignissim eleifend mi, a tincidunt libero congue faucibus. Fusce semper posuere sapien, hendrerit molestie risus congue vitae. Ut eu auctor turpis. In hac habitasse platea dictumst. Etiam condimentum urna sit amet arcu venenatis, at commodo augue fermentum.',
        1,
        NULL
    ),
    (
        'Subnautica',
        29.99,
        '2018-01-23',
        'images-jeux/Subnautica.webp',
        '',
        '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit turpis vitae ante maximus mollis id et dui. Phasellus convallis justo id ligula sagittis eleifend. Vestibulum vel finibus lectus. Nullam ac felis nibh. Aenean eu porta lorem. Fusce vestibulum lorem id porta accumsan. Curabitur sit amet ultrices mauris. Nunc tempus nibh facilisis dolor pretium, tempor pretium leo suscipit. Ut consectetur nunc nisi, quis ornare lorem fringilla ac. Sed fringilla risus sodales, eleifend lectus ac, interdum lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris et egestas purus, id egestas nisi.

Cras non mattis purus. Vivamus dignissim pulvinar orci, eu interdum quam hendrerit eget. Nunc elementum imperdiet volutpat. Phasellus enim nibh, lacinia sed orci eu, laoreet lacinia ligula. Morbi ullamcorper finibus magna eu interdum. Aenean nec dolor sed nunc dapibus malesuada vitae in massa. Nam semper mi risus, dictum vehicula nisi hendrerit ut. Ut posuere pulvinar ipsum in semper. Cras magna enim, hendrerit eget nisi ac, rutrum malesuada tortor. Pellentesque rutrum pretium mauris, sed tincidunt nunc dapibus non. Nunc semper neque felis, auctor fringilla justo faucibus ac. Aliquam imperdiet dapibus orci, ut bibendum libero iaculis id. Duis at mauris non felis scelerisque maximus. Ut nec nisl urna. Quisque ullamcorper arcu quis ante laoreet, vitae semper ex accumsan. Ut auctor id nisl vel rhoncus.

Nulla egestas massa in libero blandit, vel auctor mi feugiat. In non nulla vitae turpis sollicitudin consectetur a eget lacus. Mauris arcu ex, vestibulum in hendrerit id, blandit eu erat. Nullam nec commodo ex, vel hendrerit mi. Mauris vitae dolor ac purus dignissim varius. In vel faucibus erat, a commodo ante. Phasellus a nisi non arcu volutpat imperdiet vitae ac neque. Pellentesque convallis nunc et mi fermentum pharetra. Nullam tincidunt libero eu est finibus rhoncus. Proin eu lacus sed erat malesuada rhoncus vitae sed odio. Nullam tempus euismod elit, sit amet scelerisque ante tristique vel. In ac libero at diam pulvinar bibendum. Pellentesque gravida neque in ipsum sagittis bibendum.

Sed libero lectus, facilisis et volutpat in, congue vel ex. Morbi ac facilisis diam, eget pellentesque lectus. Vestibulum in ex in eros vulputate accumsan. Donec maximus velit tortor, at euismod purus commodo et. Curabitur vitae consequat lectus. Suspendisse vitae nunc elit. Quisque nec bibendum urna, maximus lobortis metus. Integer tincidunt pulvinar dui, sed euismod metus pulvinar vitae. Aenean lacus augue, consequat quis commodo sed, imperdiet nec risus. Aliquam imperdiet, nisi id aliquam pellentesque, libero magna consequat est, ac facilisis nunc enim id ipsum. Nunc ullamcorper interdum quam, sed facilisis mi porttitor non. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer maximus tortor dui, pulvinar pretium neque tempus quis. Nullam fringilla, urna eu commodo eleifend, nunc velit egestas felis, vel consequat purus leo vel orci. Sed fringilla pellentesque magna.

Nullam eget faucibus risus. Ut tellus tellus, scelerisque sit amet risus nec, mattis condimentum augue. Donec orci justo, aliquet a quam sed, pulvinar sagittis augue. Mauris venenatis dolor eu lacus mattis, vel accumsan velit laoreet. Nulla dapibus vulputate volutpat. Sed eget dictum elit. Morbi a volutpat justo. Suspendisse non diam lorem. Nulla hendrerit ut nisi sed mattis. Morbi vitae consequat velit, sit amet sollicitudin quam. Vestibulum dignissim eleifend mi, a tincidunt libero congue faucibus. Fusce semper posuere sapien, hendrerit molestie risus congue vitae. Ut eu auctor turpis. In hac habitasse platea dictumst. Etiam condimentum urna sit amet arcu venenatis, at commodo augue fermentum.',
        15,
        NULL
    ),
    (
        'Factorio',
        30,
        '2020-08-14',
        'images-jeux/Factorio.webp',
        '',
        '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit turpis vitae ante maximus mollis id et dui. Phasellus convallis justo id ligula sagittis eleifend. Vestibulum vel finibus lectus. Nullam ac felis nibh. Aenean eu porta lorem. Fusce vestibulum lorem id porta accumsan. Curabitur sit amet ultrices mauris. Nunc tempus nibh facilisis dolor pretium, tempor pretium leo suscipit. Ut consectetur nunc nisi, quis ornare lorem fringilla ac. Sed fringilla risus sodales, eleifend lectus ac, interdum lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris et egestas purus, id egestas nisi.

Cras non mattis purus. Vivamus dignissim pulvinar orci, eu interdum quam hendrerit eget. Nunc elementum imperdiet volutpat. Phasellus enim nibh, lacinia sed orci eu, laoreet lacinia ligula. Morbi ullamcorper finibus magna eu interdum. Aenean nec dolor sed nunc dapibus malesuada vitae in massa. Nam semper mi risus, dictum vehicula nisi hendrerit ut. Ut posuere pulvinar ipsum in semper. Cras magna enim, hendrerit eget nisi ac, rutrum malesuada tortor. Pellentesque rutrum pretium mauris, sed tincidunt nunc dapibus non. Nunc semper neque felis, auctor fringilla justo faucibus ac. Aliquam imperdiet dapibus orci, ut bibendum libero iaculis id. Duis at mauris non felis scelerisque maximus. Ut nec nisl urna. Quisque ullamcorper arcu quis ante laoreet, vitae semper ex accumsan. Ut auctor id nisl vel rhoncus.

Nulla egestas massa in libero blandit, vel auctor mi feugiat. In non nulla vitae turpis sollicitudin consectetur a eget lacus. Mauris arcu ex, vestibulum in hendrerit id, blandit eu erat. Nullam nec commodo ex, vel hendrerit mi. Mauris vitae dolor ac purus dignissim varius. In vel faucibus erat, a commodo ante. Phasellus a nisi non arcu volutpat imperdiet vitae ac neque. Pellentesque convallis nunc et mi fermentum pharetra. Nullam tincidunt libero eu est finibus rhoncus. Proin eu lacus sed erat malesuada rhoncus vitae sed odio. Nullam tempus euismod elit, sit amet scelerisque ante tristique vel. In ac libero at diam pulvinar bibendum. Pellentesque gravida neque in ipsum sagittis bibendum.

Sed libero lectus, facilisis et volutpat in, congue vel ex. Morbi ac facilisis diam, eget pellentesque lectus. Vestibulum in ex in eros vulputate accumsan. Donec maximus velit tortor, at euismod purus commodo et. Curabitur vitae consequat lectus. Suspendisse vitae nunc elit. Quisque nec bibendum urna, maximus lobortis metus. Integer tincidunt pulvinar dui, sed euismod metus pulvinar vitae. Aenean lacus augue, consequat quis commodo sed, imperdiet nec risus. Aliquam imperdiet, nisi id aliquam pellentesque, libero magna consequat est, ac facilisis nunc enim id ipsum. Nunc ullamcorper interdum quam, sed facilisis mi porttitor non. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer maximus tortor dui, pulvinar pretium neque tempus quis. Nullam fringilla, urna eu commodo eleifend, nunc velit egestas felis, vel consequat purus leo vel orci. Sed fringilla pellentesque magna.

Nullam eget faucibus risus. Ut tellus tellus, scelerisque sit amet risus nec, mattis condimentum augue. Donec orci justo, aliquet a quam sed, pulvinar sagittis augue. Mauris venenatis dolor eu lacus mattis, vel accumsan velit laoreet. Nulla dapibus vulputate volutpat. Sed eget dictum elit. Morbi a volutpat justo. Suspendisse non diam lorem. Nulla hendrerit ut nisi sed mattis. Morbi vitae consequat velit, sit amet sollicitudin quam. Vestibulum dignissim eleifend mi, a tincidunt libero congue faucibus. Fusce semper posuere sapien, hendrerit molestie risus congue vitae. Ut eu auctor turpis. In hac habitasse platea dictumst. Etiam condimentum urna sit amet arcu venenatis, at commodo augue fermentum.',
        5,
        NULL
    ),
    (
        'Dead Cells',
        24.99,
        '2018-08-07',
        'images-jeux/Dead-Cells.webp',
        '',
        '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit turpis vitae ante maximus mollis id et dui. Phasellus convallis justo id ligula sagittis eleifend. Vestibulum vel finibus lectus. Nullam ac felis nibh. Aenean eu porta lorem. Fusce vestibulum lorem id porta accumsan. Curabitur sit amet ultrices mauris. Nunc tempus nibh facilisis dolor pretium, tempor pretium leo suscipit. Ut consectetur nunc nisi, quis ornare lorem fringilla ac. Sed fringilla risus sodales, eleifend lectus ac, interdum lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris et egestas purus, id egestas nisi.

Cras non mattis purus. Vivamus dignissim pulvinar orci, eu interdum quam hendrerit eget. Nunc elementum imperdiet volutpat. Phasellus enim nibh, lacinia sed orci eu, laoreet lacinia ligula. Morbi ullamcorper finibus magna eu interdum. Aenean nec dolor sed nunc dapibus malesuada vitae in massa. Nam semper mi risus, dictum vehicula nisi hendrerit ut. Ut posuere pulvinar ipsum in semper. Cras magna enim, hendrerit eget nisi ac, rutrum malesuada tortor. Pellentesque rutrum pretium mauris, sed tincidunt nunc dapibus non. Nunc semper neque felis, auctor fringilla justo faucibus ac. Aliquam imperdiet dapibus orci, ut bibendum libero iaculis id. Duis at mauris non felis scelerisque maximus. Ut nec nisl urna. Quisque ullamcorper arcu quis ante laoreet, vitae semper ex accumsan. Ut auctor id nisl vel rhoncus.

Nulla egestas massa in libero blandit, vel auctor mi feugiat. In non nulla vitae turpis sollicitudin consectetur a eget lacus. Mauris arcu ex, vestibulum in hendrerit id, blandit eu erat. Nullam nec commodo ex, vel hendrerit mi. Mauris vitae dolor ac purus dignissim varius. In vel faucibus erat, a commodo ante. Phasellus a nisi non arcu volutpat imperdiet vitae ac neque. Pellentesque convallis nunc et mi fermentum pharetra. Nullam tincidunt libero eu est finibus rhoncus. Proin eu lacus sed erat malesuada rhoncus vitae sed odio. Nullam tempus euismod elit, sit amet scelerisque ante tristique vel. In ac libero at diam pulvinar bibendum. Pellentesque gravida neque in ipsum sagittis bibendum.

Sed libero lectus, facilisis et volutpat in, congue vel ex. Morbi ac facilisis diam, eget pellentesque lectus. Vestibulum in ex in eros vulputate accumsan. Donec maximus velit tortor, at euismod purus commodo et. Curabitur vitae consequat lectus. Suspendisse vitae nunc elit. Quisque nec bibendum urna, maximus lobortis metus. Integer tincidunt pulvinar dui, sed euismod metus pulvinar vitae. Aenean lacus augue, consequat quis commodo sed, imperdiet nec risus. Aliquam imperdiet, nisi id aliquam pellentesque, libero magna consequat est, ac facilisis nunc enim id ipsum. Nunc ullamcorper interdum quam, sed facilisis mi porttitor non. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer maximus tortor dui, pulvinar pretium neque tempus quis. Nullam fringilla, urna eu commodo eleifend, nunc velit egestas felis, vel consequat purus leo vel orci. Sed fringilla pellentesque magna.

Nullam eget faucibus risus. Ut tellus tellus, scelerisque sit amet risus nec, mattis condimentum augue. Donec orci justo, aliquet a quam sed, pulvinar sagittis augue. Mauris venenatis dolor eu lacus mattis, vel accumsan velit laoreet. Nulla dapibus vulputate volutpat. Sed eget dictum elit. Morbi a volutpat justo. Suspendisse non diam lorem. Nulla hendrerit ut nisi sed mattis. Morbi vitae consequat velit, sit amet sollicitudin quam. Vestibulum dignissim eleifend mi, a tincidunt libero congue faucibus. Fusce semper posuere sapien, hendrerit molestie risus congue vitae. Ut eu auctor turpis. In hac habitasse platea dictumst. Etiam condimentum urna sit amet arcu venenatis, at commodo augue fermentum.',
        16,
        NULL
    ),
    (
        'Cuphead',
        19.99,
        '2017-09-29',
        'images-jeux/Cuphead.webp',
        '',
        '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit turpis vitae ante maximus mollis id et dui. Phasellus convallis justo id ligula sagittis eleifend. Vestibulum vel finibus lectus. Nullam ac felis nibh. Aenean eu porta lorem. Fusce vestibulum lorem id porta accumsan. Curabitur sit amet ultrices mauris. Nunc tempus nibh facilisis dolor pretium, tempor pretium leo suscipit. Ut consectetur nunc nisi, quis ornare lorem fringilla ac. Sed fringilla risus sodales, eleifend lectus ac, interdum lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris et egestas purus, id egestas nisi.

Cras non mattis purus. Vivamus dignissim pulvinar orci, eu interdum quam hendrerit eget. Nunc elementum imperdiet volutpat. Phasellus enim nibh, lacinia sed orci eu, laoreet lacinia ligula. Morbi ullamcorper finibus magna eu interdum. Aenean nec dolor sed nunc dapibus malesuada vitae in massa. Nam semper mi risus, dictum vehicula nisi hendrerit ut. Ut posuere pulvinar ipsum in semper. Cras magna enim, hendrerit eget nisi ac, rutrum malesuada tortor. Pellentesque rutrum pretium mauris, sed tincidunt nunc dapibus non. Nunc semper neque felis, auctor fringilla justo faucibus ac. Aliquam imperdiet dapibus orci, ut bibendum libero iaculis id. Duis at mauris non felis scelerisque maximus. Ut nec nisl urna. Quisque ullamcorper arcu quis ante laoreet, vitae semper ex accumsan. Ut auctor id nisl vel rhoncus.

Nulla egestas massa in libero blandit, vel auctor mi feugiat. In non nulla vitae turpis sollicitudin consectetur a eget lacus. Mauris arcu ex, vestibulum in hendrerit id, blandit eu erat. Nullam nec commodo ex, vel hendrerit mi. Mauris vitae dolor ac purus dignissim varius. In vel faucibus erat, a commodo ante. Phasellus a nisi non arcu volutpat imperdiet vitae ac neque. Pellentesque convallis nunc et mi fermentum pharetra. Nullam tincidunt libero eu est finibus rhoncus. Proin eu lacus sed erat malesuada rhoncus vitae sed odio. Nullam tempus euismod elit, sit amet scelerisque ante tristique vel. In ac libero at diam pulvinar bibendum. Pellentesque gravida neque in ipsum sagittis bibendum.

Sed libero lectus, facilisis et volutpat in, congue vel ex. Morbi ac facilisis diam, eget pellentesque lectus. Vestibulum in ex in eros vulputate accumsan. Donec maximus velit tortor, at euismod purus commodo et. Curabitur vitae consequat lectus. Suspendisse vitae nunc elit. Quisque nec bibendum urna, maximus lobortis metus. Integer tincidunt pulvinar dui, sed euismod metus pulvinar vitae. Aenean lacus augue, consequat quis commodo sed, imperdiet nec risus. Aliquam imperdiet, nisi id aliquam pellentesque, libero magna consequat est, ac facilisis nunc enim id ipsum. Nunc ullamcorper interdum quam, sed facilisis mi porttitor non. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer maximus tortor dui, pulvinar pretium neque tempus quis. Nullam fringilla, urna eu commodo eleifend, nunc velit egestas felis, vel consequat purus leo vel orci. Sed fringilla pellentesque magna.

Nullam eget faucibus risus. Ut tellus tellus, scelerisque sit amet risus nec, mattis condimentum augue. Donec orci justo, aliquet a quam sed, pulvinar sagittis augue. Mauris venenatis dolor eu lacus mattis, vel accumsan velit laoreet. Nulla dapibus vulputate volutpat. Sed eget dictum elit. Morbi a volutpat justo. Suspendisse non diam lorem. Nulla hendrerit ut nisi sed mattis. Morbi vitae consequat velit, sit amet sollicitudin quam. Vestibulum dignissim eleifend mi, a tincidunt libero congue faucibus. Fusce semper posuere sapien, hendrerit molestie risus congue vitae. Ut eu auctor turpis. In hac habitasse platea dictumst. Etiam condimentum urna sit amet arcu venenatis, at commodo augue fermentum.',
        10,
        NULL
    ),
    (
        'Stardew Valley',
        14.99,
        '2016-02-26',
        'images-jeux/Stardew-Valley.webp',
        '',
        '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit turpis vitae ante maximus mollis id et dui. Phasellus convallis justo id ligula sagittis eleifend. Vestibulum vel finibus lectus. Nullam ac felis nibh. Aenean eu porta lorem. Fusce vestibulum lorem id porta accumsan. Curabitur sit amet ultrices mauris. Nunc tempus nibh facilisis dolor pretium, tempor pretium leo suscipit. Ut consectetur nunc nisi, quis ornare lorem fringilla ac. Sed fringilla risus sodales, eleifend lectus ac, interdum lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris et egestas purus, id egestas nisi.

Cras non mattis purus. Vivamus dignissim pulvinar orci, eu interdum quam hendrerit eget. Nunc elementum imperdiet volutpat. Phasellus enim nibh, lacinia sed orci eu, laoreet lacinia ligula. Morbi ullamcorper finibus magna eu interdum. Aenean nec dolor sed nunc dapibus malesuada vitae in massa. Nam semper mi risus, dictum vehicula nisi hendrerit ut. Ut posuere pulvinar ipsum in semper. Cras magna enim, hendrerit eget nisi ac, rutrum malesuada tortor. Pellentesque rutrum pretium mauris, sed tincidunt nunc dapibus non. Nunc semper neque felis, auctor fringilla justo faucibus ac. Aliquam imperdiet dapibus orci, ut bibendum libero iaculis id. Duis at mauris non felis scelerisque maximus. Ut nec nisl urna. Quisque ullamcorper arcu quis ante laoreet, vitae semper ex accumsan. Ut auctor id nisl vel rhoncus.

Nulla egestas massa in libero blandit, vel auctor mi feugiat. In non nulla vitae turpis sollicitudin consectetur a eget lacus. Mauris arcu ex, vestibulum in hendrerit id, blandit eu erat. Nullam nec commodo ex, vel hendrerit mi. Mauris vitae dolor ac purus dignissim varius. In vel faucibus erat, a commodo ante. Phasellus a nisi non arcu volutpat imperdiet vitae ac neque. Pellentesque convallis nunc et mi fermentum pharetra. Nullam tincidunt libero eu est finibus rhoncus. Proin eu lacus sed erat malesuada rhoncus vitae sed odio. Nullam tempus euismod elit, sit amet scelerisque ante tristique vel. In ac libero at diam pulvinar bibendum. Pellentesque gravida neque in ipsum sagittis bibendum.

Sed libero lectus, facilisis et volutpat in, congue vel ex. Morbi ac facilisis diam, eget pellentesque lectus. Vestibulum in ex in eros vulputate accumsan. Donec maximus velit tortor, at euismod purus commodo et. Curabitur vitae consequat lectus. Suspendisse vitae nunc elit. Quisque nec bibendum urna, maximus lobortis metus. Integer tincidunt pulvinar dui, sed euismod metus pulvinar vitae. Aenean lacus augue, consequat quis commodo sed, imperdiet nec risus. Aliquam imperdiet, nisi id aliquam pellentesque, libero magna consequat est, ac facilisis nunc enim id ipsum. Nunc ullamcorper interdum quam, sed facilisis mi porttitor non. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer maximus tortor dui, pulvinar pretium neque tempus quis. Nullam fringilla, urna eu commodo eleifend, nunc velit egestas felis, vel consequat purus leo vel orci. Sed fringilla pellentesque magna.

Nullam eget faucibus risus. Ut tellus tellus, scelerisque sit amet risus nec, mattis condimentum augue. Donec orci justo, aliquet a quam sed, pulvinar sagittis augue. Mauris venenatis dolor eu lacus mattis, vel accumsan velit laoreet. Nulla dapibus vulputate volutpat. Sed eget dictum elit. Morbi a volutpat justo. Suspendisse non diam lorem. Nulla hendrerit ut nisi sed mattis. Morbi vitae consequat velit, sit amet sollicitudin quam. Vestibulum dignissim eleifend mi, a tincidunt libero congue faucibus. Fusce semper posuere sapien, hendrerit molestie risus congue vitae. Ut eu auctor turpis. In hac habitasse platea dictumst. Etiam condimentum urna sit amet arcu venenatis, at commodo augue fermentum.',
        5,
        NULL
    ),
    (
        'Terraria',
        9.99,
        '2011-05-16',
        'images-jeux/Terraria.webp',
        '',
        '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit turpis vitae ante maximus mollis id et dui. Phasellus convallis justo id ligula sagittis eleifend. Vestibulum vel finibus lectus. Nullam ac felis nibh. Aenean eu porta lorem. Fusce vestibulum lorem id porta accumsan. Curabitur sit amet ultrices mauris. Nunc tempus nibh facilisis dolor pretium, tempor pretium leo suscipit. Ut consectetur nunc nisi, quis ornare lorem fringilla ac. Sed fringilla risus sodales, eleifend lectus ac, interdum lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris et egestas purus, id egestas nisi.

Cras non mattis purus. Vivamus dignissim pulvinar orci, eu interdum quam hendrerit eget. Nunc elementum imperdiet volutpat. Phasellus enim nibh, lacinia sed orci eu, laoreet lacinia ligula. Morbi ullamcorper finibus magna eu interdum. Aenean nec dolor sed nunc dapibus malesuada vitae in massa. Nam semper mi risus, dictum vehicula nisi hendrerit ut. Ut posuere pulvinar ipsum in semper. Cras magna enim, hendrerit eget nisi ac, rutrum malesuada tortor. Pellentesque rutrum pretium mauris, sed tincidunt nunc dapibus non. Nunc semper neque felis, auctor fringilla justo faucibus ac. Aliquam imperdiet dapibus orci, ut bibendum libero iaculis id. Duis at mauris non felis scelerisque maximus. Ut nec nisl urna. Quisque ullamcorper arcu quis ante laoreet, vitae semper ex accumsan. Ut auctor id nisl vel rhoncus.

Nulla egestas massa in libero blandit, vel auctor mi feugiat. In non nulla vitae turpis sollicitudin consectetur a eget lacus. Mauris arcu ex, vestibulum in hendrerit id, blandit eu erat. Nullam nec commodo ex, vel hendrerit mi. Mauris vitae dolor ac purus dignissim varius. In vel faucibus erat, a commodo ante. Phasellus a nisi non arcu volutpat imperdiet vitae ac neque. Pellentesque convallis nunc et mi fermentum pharetra. Nullam tincidunt libero eu est finibus rhoncus. Proin eu lacus sed erat malesuada rhoncus vitae sed odio. Nullam tempus euismod elit, sit amet scelerisque ante tristique vel. In ac libero at diam pulvinar bibendum. Pellentesque gravida neque in ipsum sagittis bibendum.

Sed libero lectus, facilisis et volutpat in, congue vel ex. Morbi ac facilisis diam, eget pellentesque lectus. Vestibulum in ex in eros vulputate accumsan. Donec maximus velit tortor, at euismod purus commodo et. Curabitur vitae consequat lectus. Suspendisse vitae nunc elit. Quisque nec bibendum urna, maximus lobortis metus. Integer tincidunt pulvinar dui, sed euismod metus pulvinar vitae. Aenean lacus augue, consequat quis commodo sed, imperdiet nec risus. Aliquam imperdiet, nisi id aliquam pellentesque, libero magna consequat est, ac facilisis nunc enim id ipsum. Nunc ullamcorper interdum quam, sed facilisis mi porttitor non. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer maximus tortor dui, pulvinar pretium neque tempus quis. Nullam fringilla, urna eu commodo eleifend, nunc velit egestas felis, vel consequat purus leo vel orci. Sed fringilla pellentesque magna.

Nullam eget faucibus risus. Ut tellus tellus, scelerisque sit amet risus nec, mattis condimentum augue. Donec orci justo, aliquet a quam sed, pulvinar sagittis augue. Mauris venenatis dolor eu lacus mattis, vel accumsan velit laoreet. Nulla dapibus vulputate volutpat. Sed eget dictum elit. Morbi a volutpat justo. Suspendisse non diam lorem. Nulla hendrerit ut nisi sed mattis. Morbi vitae consequat velit, sit amet sollicitudin quam. Vestibulum dignissim eleifend mi, a tincidunt libero congue faucibus. Fusce semper posuere sapien, hendrerit molestie risus congue vitae. Ut eu auctor turpis. In hac habitasse platea dictumst. Etiam condimentum urna sit amet arcu venenatis, at commodo augue fermentum.',
        17,
        NULL
    ),
    (
        'Among Us',
        4.99,
        '2018-11-16',
        'images-jeux/Among-Us.webp',
        '',
        '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit turpis vitae ante maximus mollis id et dui. Phasellus convallis justo id ligula sagittis eleifend. Vestibulum vel finibus lectus. Nullam ac felis nibh. Aenean eu porta lorem. Fusce vestibulum lorem id porta accumsan. Curabitur sit amet ultrices mauris. Nunc tempus nibh facilisis dolor pretium, tempor pretium leo suscipit. Ut consectetur nunc nisi, quis ornare lorem fringilla ac. Sed fringilla risus sodales, eleifend lectus ac, interdum lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris et egestas purus, id egestas nisi.

Cras non mattis purus. Vivamus dignissim pulvinar orci, eu interdum quam hendrerit eget. Nunc elementum imperdiet volutpat. Phasellus enim nibh, lacinia sed orci eu, laoreet lacinia ligula. Morbi ullamcorper finibus magna eu interdum. Aenean nec dolor sed nunc dapibus malesuada vitae in massa. Nam semper mi risus, dictum vehicula nisi hendrerit ut. Ut posuere pulvinar ipsum in semper. Cras magna enim, hendrerit eget nisi ac, rutrum malesuada tortor. Pellentesque rutrum pretium mauris, sed tincidunt nunc dapibus non. Nunc semper neque felis, auctor fringilla justo faucibus ac. Aliquam imperdiet dapibus orci, ut bibendum libero iaculis id. Duis at mauris non felis scelerisque maximus. Ut nec nisl urna. Quisque ullamcorper arcu quis ante laoreet, vitae semper ex accumsan. Ut auctor id nisl vel rhoncus.

Nulla egestas massa in libero blandit, vel auctor mi feugiat. In non nulla vitae turpis sollicitudin consectetur a eget lacus. Mauris arcu ex, vestibulum in hendrerit id, blandit eu erat. Nullam nec commodo ex, vel hendrerit mi. Mauris vitae dolor ac purus dignissim varius. In vel faucibus erat, a commodo ante. Phasellus a nisi non arcu volutpat imperdiet vitae ac neque. Pellentesque convallis nunc et mi fermentum pharetra. Nullam tincidunt libero eu est finibus rhoncus. Proin eu lacus sed erat malesuada rhoncus vitae sed odio. Nullam tempus euismod elit, sit amet scelerisque ante tristique vel. In ac libero at diam pulvinar bibendum. Pellentesque gravida neque in ipsum sagittis bibendum.

Sed libero lectus, facilisis et volutpat in, congue vel ex. Morbi ac facilisis diam, eget pellentesque lectus. Vestibulum in ex in eros vulputate accumsan. Donec maximus velit tortor, at euismod purus commodo et. Curabitur vitae consequat lectus. Suspendisse vitae nunc elit. Quisque nec bibendum urna, maximus lobortis metus. Integer tincidunt pulvinar dui, sed euismod metus pulvinar vitae. Aenean lacus augue, consequat quis commodo sed, imperdiet nec risus. Aliquam imperdiet, nisi id aliquam pellentesque, libero magna consequat est, ac facilisis nunc enim id ipsum. Nunc ullamcorper interdum quam, sed facilisis mi porttitor non. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer maximus tortor dui, pulvinar pretium neque tempus quis. Nullam fringilla, urna eu commodo eleifend, nunc velit egestas felis, vel consequat purus leo vel orci. Sed fringilla pellentesque magna.

Nullam eget faucibus risus. Ut tellus tellus, scelerisque sit amet risus nec, mattis condimentum augue. Donec orci justo, aliquet a quam sed, pulvinar sagittis augue. Mauris venenatis dolor eu lacus mattis, vel accumsan velit laoreet. Nulla dapibus vulputate volutpat. Sed eget dictum elit. Morbi a volutpat justo. Suspendisse non diam lorem. Nulla hendrerit ut nisi sed mattis. Morbi vitae consequat velit, sit amet sollicitudin quam. Vestibulum dignissim eleifend mi, a tincidunt libero congue faucibus. Fusce semper posuere sapien, hendrerit molestie risus congue vitae. Ut eu auctor turpis. In hac habitasse platea dictumst. Etiam condimentum urna sit amet arcu venenatis, at commodo augue fermentum.',
        12,
        NULL
    ),
    (
        'Phasmophobia',
        13.99,
        '2020-09-18',
        'images-jeux/Phasmophobia.webp',
        '',
        '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit turpis vitae ante maximus mollis id et dui. Phasellus convallis justo id ligula sagittis eleifend. Vestibulum vel finibus lectus. Nullam ac felis nibh. Aenean eu porta lorem. Fusce vestibulum lorem id porta accumsan. Curabitur sit amet ultrices mauris. Nunc tempus nibh facilisis dolor pretium, tempor pretium leo suscipit. Ut consectetur nunc nisi, quis ornare lorem fringilla ac. Sed fringilla risus sodales, eleifend lectus ac, interdum lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris et egestas purus, id egestas nisi.

Cras non mattis purus. Vivamus dignissim pulvinar orci, eu interdum quam hendrerit eget. Nunc elementum imperdiet volutpat. Phasellus enim nibh, lacinia sed orci eu, laoreet lacinia ligula. Morbi ullamcorper finibus magna eu interdum. Aenean nec dolor sed nunc dapibus malesuada vitae in massa. Nam semper mi risus, dictum vehicula nisi hendrerit ut. Ut posuere pulvinar ipsum in semper. Cras magna enim, hendrerit eget nisi ac, rutrum malesuada tortor. Pellentesque rutrum pretium mauris, sed tincidunt nunc dapibus non. Nunc semper neque felis, auctor fringilla justo faucibus ac. Aliquam imperdiet dapibus orci, ut bibendum libero iaculis id. Duis at mauris non felis scelerisque maximus. Ut nec nisl urna. Quisque ullamcorper arcu quis ante laoreet, vitae semper ex accumsan. Ut auctor id nisl vel rhoncus.

Nulla egestas massa in libero blandit, vel auctor mi feugiat. In non nulla vitae turpis sollicitudin consectetur a eget lacus. Mauris arcu ex, vestibulum in hendrerit id, blandit eu erat. Nullam nec commodo ex, vel hendrerit mi. Mauris vitae dolor ac purus dignissim varius. In vel faucibus erat, a commodo ante. Phasellus a nisi non arcu volutpat imperdiet vitae ac neque. Pellentesque convallis nunc et mi fermentum pharetra. Nullam tincidunt libero eu est finibus rhoncus. Proin eu lacus sed erat malesuada rhoncus vitae sed odio. Nullam tempus euismod elit, sit amet scelerisque ante tristique vel. In ac libero at diam pulvinar bibendum. Pellentesque gravida neque in ipsum sagittis bibendum.

Sed libero lectus, facilisis et volutpat in, congue vel ex. Morbi ac facilisis diam, eget pellentesque lectus. Vestibulum in ex in eros vulputate accumsan. Donec maximus velit tortor, at euismod purus commodo et. Curabitur vitae consequat lectus. Suspendisse vitae nunc elit. Quisque nec bibendum urna, maximus lobortis metus. Integer tincidunt pulvinar dui, sed euismod metus pulvinar vitae. Aenean lacus augue, consequat quis commodo sed, imperdiet nec risus. Aliquam imperdiet, nisi id aliquam pellentesque, libero magna consequat est, ac facilisis nunc enim id ipsum. Nunc ullamcorper interdum quam, sed facilisis mi porttitor non. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer maximus tortor dui, pulvinar pretium neque tempus quis. Nullam fringilla, urna eu commodo eleifend, nunc velit egestas felis, vel consequat purus leo vel orci. Sed fringilla pellentesque magna.

Nullam eget faucibus risus. Ut tellus tellus, scelerisque sit amet risus nec, mattis condimentum augue. Donec orci justo, aliquet a quam sed, pulvinar sagittis augue. Mauris venenatis dolor eu lacus mattis, vel accumsan velit laoreet. Nulla dapibus vulputate volutpat. Sed eget dictum elit. Morbi a volutpat justo. Suspendisse non diam lorem. Nulla hendrerit ut nisi sed mattis. Morbi vitae consequat velit, sit amet sollicitudin quam. Vestibulum dignissim eleifend mi, a tincidunt libero congue faucibus. Fusce semper posuere sapien, hendrerit molestie risus congue vitae. Ut eu auctor turpis. In hac habitasse platea dictumst. Etiam condimentum urna sit amet arcu venenatis, at commodo augue fermentum.',
        8,
        NULL
    ),
    (
        'Outlast',
        19.99,
        '2013-09-04',
        'images-jeux/Outlast.webp',
        '',
        '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit turpis vitae ante maximus mollis id et dui. Phasellus convallis justo id ligula sagittis eleifend. Vestibulum vel finibus lectus. Nullam ac felis nibh. Aenean eu porta lorem. Fusce vestibulum lorem id porta accumsan. Curabitur sit amet ultrices mauris. Nunc tempus nibh facilisis dolor pretium, tempor pretium leo suscipit. Ut consectetur nunc nisi, quis ornare lorem fringilla ac. Sed fringilla risus sodales, eleifend lectus ac, interdum lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris et egestas purus, id egestas nisi.

Cras non mattis purus. Vivamus dignissim pulvinar orci, eu interdum quam hendrerit eget. Nunc elementum imperdiet volutpat. Phasellus enim nibh, lacinia sed orci eu, laoreet lacinia ligula. Morbi ullamcorper finibus magna eu interdum. Aenean nec dolor sed nunc dapibus malesuada vitae in massa. Nam semper mi risus, dictum vehicula nisi hendrerit ut. Ut posuere pulvinar ipsum in semper. Cras magna enim, hendrerit eget nisi ac, rutrum malesuada tortor. Pellentesque rutrum pretium mauris, sed tincidunt nunc dapibus non. Nunc semper neque felis, auctor fringilla justo faucibus ac. Aliquam imperdiet dapibus orci, ut bibendum libero iaculis id. Duis at mauris non felis scelerisque maximus. Ut nec nisl urna. Quisque ullamcorper arcu quis ante laoreet, vitae semper ex accumsan. Ut auctor id nisl vel rhoncus.

Nulla egestas massa in libero blandit, vel auctor mi feugiat. In non nulla vitae turpis sollicitudin consectetur a eget lacus. Mauris arcu ex, vestibulum in hendrerit id, blandit eu erat. Nullam nec commodo ex, vel hendrerit mi. Mauris vitae dolor ac purus dignissim varius. In vel faucibus erat, a commodo ante. Phasellus a nisi non arcu volutpat imperdiet vitae ac neque. Pellentesque convallis nunc et mi fermentum pharetra. Nullam tincidunt libero eu est finibus rhoncus. Proin eu lacus sed erat malesuada rhoncus vitae sed odio. Nullam tempus euismod elit, sit amet scelerisque ante tristique vel. In ac libero at diam pulvinar bibendum. Pellentesque gravida neque in ipsum sagittis bibendum.

Sed libero lectus, facilisis et volutpat in, congue vel ex. Morbi ac facilisis diam, eget pellentesque lectus. Vestibulum in ex in eros vulputate accumsan. Donec maximus velit tortor, at euismod purus commodo et. Curabitur vitae consequat lectus. Suspendisse vitae nunc elit. Quisque nec bibendum urna, maximus lobortis metus. Integer tincidunt pulvinar dui, sed euismod metus pulvinar vitae. Aenean lacus augue, consequat quis commodo sed, imperdiet nec risus. Aliquam imperdiet, nisi id aliquam pellentesque, libero magna consequat est, ac facilisis nunc enim id ipsum. Nunc ullamcorper interdum quam, sed facilisis mi porttitor non. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer maximus tortor dui, pulvinar pretium neque tempus quis. Nullam fringilla, urna eu commodo eleifend, nunc velit egestas felis, vel consequat purus leo vel orci. Sed fringilla pellentesque magna.

Nullam eget faucibus risus. Ut tellus tellus, scelerisque sit amet risus nec, mattis condimentum augue. Donec orci justo, aliquet a quam sed, pulvinar sagittis augue. Mauris venenatis dolor eu lacus mattis, vel accumsan velit laoreet. Nulla dapibus vulputate volutpat. Sed eget dictum elit. Morbi a volutpat justo. Suspendisse non diam lorem. Nulla hendrerit ut nisi sed mattis. Morbi vitae consequat velit, sit amet sollicitudin quam. Vestibulum dignissim eleifend mi, a tincidunt libero congue faucibus. Fusce semper posuere sapien, hendrerit molestie risus congue vitae. Ut eu auctor turpis. In hac habitasse platea dictumst. Etiam condimentum urna sit amet arcu venenatis, at commodo augue fermentum.',
        8,
        NULL
    ),
    (
        'The Forest',
        19.99,
        '2018-04-30',
        'images-jeux/The-Forest.webp',
        '',
        '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit turpis vitae ante maximus mollis id et dui. Phasellus convallis justo id ligula sagittis eleifend. Vestibulum vel finibus lectus. Nullam ac felis nibh. Aenean eu porta lorem. Fusce vestibulum lorem id porta accumsan. Curabitur sit amet ultrices mauris. Nunc tempus nibh facilisis dolor pretium, tempor pretium leo suscipit. Ut consectetur nunc nisi, quis ornare lorem fringilla ac. Sed fringilla risus sodales, eleifend lectus ac, interdum lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris et egestas purus, id egestas nisi.

Cras non mattis purus. Vivamus dignissim pulvinar orci, eu interdum quam hendrerit eget. Nunc elementum imperdiet volutpat. Phasellus enim nibh, lacinia sed orci eu, laoreet lacinia ligula. Morbi ullamcorper finibus magna eu interdum. Aenean nec dolor sed nunc dapibus malesuada vitae in massa. Nam semper mi risus, dictum vehicula nisi hendrerit ut. Ut posuere pulvinar ipsum in semper. Cras magna enim, hendrerit eget nisi ac, rutrum malesuada tortor. Pellentesque rutrum pretium mauris, sed tincidunt nunc dapibus non. Nunc semper neque felis, auctor fringilla justo faucibus ac. Aliquam imperdiet dapibus orci, ut bibendum libero iaculis id. Duis at mauris non felis scelerisque maximus. Ut nec nisl urna. Quisque ullamcorper arcu quis ante laoreet, vitae semper ex accumsan. Ut auctor id nisl vel rhoncus.

Nulla egestas massa in libero blandit, vel auctor mi feugiat. In non nulla vitae turpis sollicitudin consectetur a eget lacus. Mauris arcu ex, vestibulum in hendrerit id, blandit eu erat. Nullam nec commodo ex, vel hendrerit mi. Mauris vitae dolor ac purus dignissim varius. In vel faucibus erat, a commodo ante. Phasellus a nisi non arcu volutpat imperdiet vitae ac neque. Pellentesque convallis nunc et mi fermentum pharetra. Nullam tincidunt libero eu est finibus rhoncus. Proin eu lacus sed erat malesuada rhoncus vitae sed odio. Nullam tempus euismod elit, sit amet scelerisque ante tristique vel. In ac libero at diam pulvinar bibendum. Pellentesque gravida neque in ipsum sagittis bibendum.

Sed libero lectus, facilisis et volutpat in, congue vel ex. Morbi ac facilisis diam, eget pellentesque lectus. Vestibulum in ex in eros vulputate accumsan. Donec maximus velit tortor, at euismod purus commodo et. Curabitur vitae consequat lectus. Suspendisse vitae nunc elit. Quisque nec bibendum urna, maximus lobortis metus. Integer tincidunt pulvinar dui, sed euismod metus pulvinar vitae. Aenean lacus augue, consequat quis commodo sed, imperdiet nec risus. Aliquam imperdiet, nisi id aliquam pellentesque, libero magna consequat est, ac facilisis nunc enim id ipsum. Nunc ullamcorper interdum quam, sed facilisis mi porttitor non. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer maximus tortor dui, pulvinar pretium neque tempus quis. Nullam fringilla, urna eu commodo eleifend, nunc velit egestas felis, vel consequat purus leo vel orci. Sed fringilla pellentesque magna.

Nullam eget faucibus risus. Ut tellus tellus, scelerisque sit amet risus nec, mattis condimentum augue. Donec orci justo, aliquet a quam sed, pulvinar sagittis augue. Mauris venenatis dolor eu lacus mattis, vel accumsan velit laoreet. Nulla dapibus vulputate volutpat. Sed eget dictum elit. Morbi a volutpat justo. Suspendisse non diam lorem. Nulla hendrerit ut nisi sed mattis. Morbi vitae consequat velit, sit amet sollicitudin quam. Vestibulum dignissim eleifend mi, a tincidunt libero congue faucibus. Fusce semper posuere sapien, hendrerit molestie risus congue vitae. Ut eu auctor turpis. In hac habitasse platea dictumst. Etiam condimentum urna sit amet arcu venenatis, at commodo augue fermentum.',
        15,
        NULL
    ),
    (
        'Valheim',
        19.99,
        '2021-02-02',
        'images-jeux/Valheim.webp',
        '',
        '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit turpis vitae ante maximus mollis id et dui. Phasellus convallis justo id ligula sagittis eleifend. Vestibulum vel finibus lectus. Nullam ac felis nibh. Aenean eu porta lorem. Fusce vestibulum lorem id porta accumsan. Curabitur sit amet ultrices mauris. Nunc tempus nibh facilisis dolor pretium, tempor pretium leo suscipit. Ut consectetur nunc nisi, quis ornare lorem fringilla ac. Sed fringilla risus sodales, eleifend lectus ac, interdum lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris et egestas purus, id egestas nisi.

Cras non mattis purus. Vivamus dignissim pulvinar orci, eu interdum quam hendrerit eget. Nunc elementum imperdiet volutpat. Phasellus enim nibh, lacinia sed orci eu, laoreet lacinia ligula. Morbi ullamcorper finibus magna eu interdum. Aenean nec dolor sed nunc dapibus malesuada vitae in massa. Nam semper mi risus, dictum vehicula nisi hendrerit ut. Ut posuere pulvinar ipsum in semper. Cras magna enim, hendrerit eget nisi ac, rutrum malesuada tortor. Pellentesque rutrum pretium mauris, sed tincidunt nunc dapibus non. Nunc semper neque felis, auctor fringilla justo faucibus ac. Aliquam imperdiet dapibus orci, ut bibendum libero iaculis id. Duis at mauris non felis scelerisque maximus. Ut nec nisl urna. Quisque ullamcorper arcu quis ante laoreet, vitae semper ex accumsan. Ut auctor id nisl vel rhoncus.

Nulla egestas massa in libero blandit, vel auctor mi feugiat. In non nulla vitae turpis sollicitudin consectetur a eget lacus. Mauris arcu ex, vestibulum in hendrerit id, blandit eu erat. Nullam nec commodo ex, vel hendrerit mi. Mauris vitae dolor ac purus dignissim varius. In vel faucibus erat, a commodo ante. Phasellus a nisi non arcu volutpat imperdiet vitae ac neque. Pellentesque convallis nunc et mi fermentum pharetra. Nullam tincidunt libero eu est finibus rhoncus. Proin eu lacus sed erat malesuada rhoncus vitae sed odio. Nullam tempus euismod elit, sit amet scelerisque ante tristique vel. In ac libero at diam pulvinar bibendum. Pellentesque gravida neque in ipsum sagittis bibendum.

Sed libero lectus, facilisis et volutpat in, congue vel ex. Morbi ac facilisis diam, eget pellentesque lectus. Vestibulum in ex in eros vulputate accumsan. Donec maximus velit tortor, at euismod purus commodo et. Curabitur vitae consequat lectus. Suspendisse vitae nunc elit. Quisque nec bibendum urna, maximus lobortis metus. Integer tincidunt pulvinar dui, sed euismod metus pulvinar vitae. Aenean lacus augue, consequat quis commodo sed, imperdiet nec risus. Aliquam imperdiet, nisi id aliquam pellentesque, libero magna consequat est, ac facilisis nunc enim id ipsum. Nunc ullamcorper interdum quam, sed facilisis mi porttitor non. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer maximus tortor dui, pulvinar pretium neque tempus quis. Nullam fringilla, urna eu commodo eleifend, nunc velit egestas felis, vel consequat purus leo vel orci. Sed fringilla pellentesque magna.

Nullam eget faucibus risus. Ut tellus tellus, scelerisque sit amet risus nec, mattis condimentum augue. Donec orci justo, aliquet a quam sed, pulvinar sagittis augue. Mauris venenatis dolor eu lacus mattis, vel accumsan velit laoreet. Nulla dapibus vulputate volutpat. Sed eget dictum elit. Morbi a volutpat justo. Suspendisse non diam lorem. Nulla hendrerit ut nisi sed mattis. Morbi vitae consequat velit, sit amet sollicitudin quam. Vestibulum dignissim eleifend mi, a tincidunt libero congue faucibus. Fusce semper posuere sapien, hendrerit molestie risus congue vitae. Ut eu auctor turpis. In hac habitasse platea dictumst. Etiam condimentum urna sit amet arcu venenatis, at commodo augue fermentum.',
        15,
        NULL
    ),
    (
        'Forza Horizon 5',
        69.99,
        '2021-11-09',
        'images-jeux/Forza-Horizon-5.webp',
        '',
        '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit turpis vitae ante maximus mollis id et dui. Phasellus convallis justo id ligula sagittis eleifend. Vestibulum vel finibus lectus. Nullam ac felis nibh. Aenean eu porta lorem. Fusce vestibulum lorem id porta accumsan. Curabitur sit amet ultrices mauris. Nunc tempus nibh facilisis dolor pretium, tempor pretium leo suscipit. Ut consectetur nunc nisi, quis ornare lorem fringilla ac. Sed fringilla risus sodales, eleifend lectus ac, interdum lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris et egestas purus, id egestas nisi.

Cras non mattis purus. Vivamus dignissim pulvinar orci, eu interdum quam hendrerit eget. Nunc elementum imperdiet volutpat. Phasellus enim nibh, lacinia sed orci eu, laoreet lacinia ligula. Morbi ullamcorper finibus magna eu interdum. Aenean nec dolor sed nunc dapibus malesuada vitae in massa. Nam semper mi risus, dictum vehicula nisi hendrerit ut. Ut posuere pulvinar ipsum in semper. Cras magna enim, hendrerit eget nisi ac, rutrum malesuada tortor. Pellentesque rutrum pretium mauris, sed tincidunt nunc dapibus non. Nunc semper neque felis, auctor fringilla justo faucibus ac. Aliquam imperdiet dapibus orci, ut bibendum libero iaculis id. Duis at mauris non felis scelerisque maximus. Ut nec nisl urna. Quisque ullamcorper arcu quis ante laoreet, vitae semper ex accumsan. Ut auctor id nisl vel rhoncus.

Nulla egestas massa in libero blandit, vel auctor mi feugiat. In non nulla vitae turpis sollicitudin consectetur a eget lacus. Mauris arcu ex, vestibulum in hendrerit id, blandit eu erat. Nullam nec commodo ex, vel hendrerit mi. Mauris vitae dolor ac purus dignissim varius. In vel faucibus erat, a commodo ante. Phasellus a nisi non arcu volutpat imperdiet vitae ac neque. Pellentesque convallis nunc et mi fermentum pharetra. Nullam tincidunt libero eu est finibus rhoncus. Proin eu lacus sed erat malesuada rhoncus vitae sed odio. Nullam tempus euismod elit, sit amet scelerisque ante tristique vel. In ac libero at diam pulvinar bibendum. Pellentesque gravida neque in ipsum sagittis bibendum.

Sed libero lectus, facilisis et volutpat in, congue vel ex. Morbi ac facilisis diam, eget pellentesque lectus. Vestibulum in ex in eros vulputate accumsan. Donec maximus velit tortor, at euismod purus commodo et. Curabitur vitae consequat lectus. Suspendisse vitae nunc elit. Quisque nec bibendum urna, maximus lobortis metus. Integer tincidunt pulvinar dui, sed euismod metus pulvinar vitae. Aenean lacus augue, consequat quis commodo sed, imperdiet nec risus. Aliquam imperdiet, nisi id aliquam pellentesque, libero magna consequat est, ac facilisis nunc enim id ipsum. Nunc ullamcorper interdum quam, sed facilisis mi porttitor non. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer maximus tortor dui, pulvinar pretium neque tempus quis. Nullam fringilla, urna eu commodo eleifend, nunc velit egestas felis, vel consequat purus leo vel orci. Sed fringilla pellentesque magna.

Nullam eget faucibus risus. Ut tellus tellus, scelerisque sit amet risus nec, mattis condimentum augue. Donec orci justo, aliquet a quam sed, pulvinar sagittis augue. Mauris venenatis dolor eu lacus mattis, vel accumsan velit laoreet. Nulla dapibus vulputate volutpat. Sed eget dictum elit. Morbi a volutpat justo. Suspendisse non diam lorem. Nulla hendrerit ut nisi sed mattis. Morbi vitae consequat velit, sit amet sollicitudin quam. Vestibulum dignissim eleifend mi, a tincidunt libero congue faucibus. Fusce semper posuere sapien, hendrerit molestie risus congue vitae. Ut eu auctor turpis. In hac habitasse platea dictumst. Etiam condimentum urna sit amet arcu venenatis, at commodo augue fermentum.',
        6,
        'trending'
    ),
    (
        'FIFA 23',
        69.99,
        '2022-09-30',
        'images-jeux/FIFA-23.webp',
        '',
        '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit turpis vitae ante maximus mollis id et dui. Phasellus convallis justo id ligula sagittis eleifend. Vestibulum vel finibus lectus. Nullam ac felis nibh. Aenean eu porta lorem. Fusce vestibulum lorem id porta accumsan. Curabitur sit amet ultrices mauris. Nunc tempus nibh facilisis dolor pretium, tempor pretium leo suscipit. Ut consectetur nunc nisi, quis ornare lorem fringilla ac. Sed fringilla risus sodales, eleifend lectus ac, interdum lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris et egestas purus, id egestas nisi.

Cras non mattis purus. Vivamus dignissim pulvinar orci, eu interdum quam hendrerit eget. Nunc elementum imperdiet volutpat. Phasellus enim nibh, lacinia sed orci eu, laoreet lacinia ligula. Morbi ullamcorper finibus magna eu interdum. Aenean nec dolor sed nunc dapibus malesuada vitae in massa. Nam semper mi risus, dictum vehicula nisi hendrerit ut. Ut posuere pulvinar ipsum in semper. Cras magna enim, hendrerit eget nisi ac, rutrum malesuada tortor. Pellentesque rutrum pretium mauris, sed tincidunt nunc dapibus non. Nunc semper neque felis, auctor fringilla justo faucibus ac. Aliquam imperdiet dapibus orci, ut bibendum libero iaculis id. Duis at mauris non felis scelerisque maximus. Ut nec nisl urna. Quisque ullamcorper arcu quis ante laoreet, vitae semper ex accumsan. Ut auctor id nisl vel rhoncus.

Nulla egestas massa in libero blandit, vel auctor mi feugiat. In non nulla vitae turpis sollicitudin consectetur a eget lacus. Mauris arcu ex, vestibulum in hendrerit id, blandit eu erat. Nullam nec commodo ex, vel hendrerit mi. Mauris vitae dolor ac purus dignissim varius. In vel faucibus erat, a commodo ante. Phasellus a nisi non arcu volutpat imperdiet vitae ac neque. Pellentesque convallis nunc et mi fermentum pharetra. Nullam tincidunt libero eu est finibus rhoncus. Proin eu lacus sed erat malesuada rhoncus vitae sed odio. Nullam tempus euismod elit, sit amet scelerisque ante tristique vel. In ac libero at diam pulvinar bibendum. Pellentesque gravida neque in ipsum sagittis bibendum.

Sed libero lectus, facilisis et volutpat in, congue vel ex. Morbi ac facilisis diam, eget pellentesque lectus. Vestibulum in ex in eros vulputate accumsan. Donec maximus velit tortor, at euismod purus commodo et. Curabitur vitae consequat lectus. Suspendisse vitae nunc elit. Quisque nec bibendum urna, maximus lobortis metus. Integer tincidunt pulvinar dui, sed euismod metus pulvinar vitae. Aenean lacus augue, consequat quis commodo sed, imperdiet nec risus. Aliquam imperdiet, nisi id aliquam pellentesque, libero magna consequat est, ac facilisis nunc enim id ipsum. Nunc ullamcorper interdum quam, sed facilisis mi porttitor non. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer maximus tortor dui, pulvinar pretium neque tempus quis. Nullam fringilla, urna eu commodo eleifend, nunc velit egestas felis, vel consequat purus leo vel orci. Sed fringilla pellentesque magna.

Nullam eget faucibus risus. Ut tellus tellus, scelerisque sit amet risus nec, mattis condimentum augue. Donec orci justo, aliquet a quam sed, pulvinar sagittis augue. Mauris venenatis dolor eu lacus mattis, vel accumsan velit laoreet. Nulla dapibus vulputate volutpat. Sed eget dictum elit. Morbi a volutpat justo. Suspendisse non diam lorem. Nulla hendrerit ut nisi sed mattis. Morbi vitae consequat velit, sit amet sollicitudin quam. Vestibulum dignissim eleifend mi, a tincidunt libero congue faucibus. Fusce semper posuere sapien, hendrerit molestie risus congue vitae. Ut eu auctor turpis. In hac habitasse platea dictumst. Etiam condimentum urna sit amet arcu venenatis, at commodo augue fermentum.',
        7,
        'trending'
    ),
    (
        'NBA 2K24',
        69.99,
        '2023-09-08',
        'images-jeux/NBA-2K24.webp',
        '',
        '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit turpis vitae ante maximus mollis id et dui. Phasellus convallis justo id ligula sagittis eleifend. Vestibulum vel finibus lectus. Nullam ac felis nibh. Aenean eu porta lorem. Fusce vestibulum lorem id porta accumsan. Curabitur sit amet ultrices mauris. Nunc tempus nibh facilisis dolor pretium, tempor pretium leo suscipit. Ut consectetur nunc nisi, quis ornare lorem fringilla ac. Sed fringilla risus sodales, eleifend lectus ac, interdum lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris et egestas purus, id egestas nisi.

Cras non mattis purus. Vivamus dignissim pulvinar orci, eu interdum quam hendrerit eget. Nunc elementum imperdiet volutpat. Phasellus enim nibh, lacinia sed orci eu, laoreet lacinia ligula. Morbi ullamcorper finibus magna eu interdum. Aenean nec dolor sed nunc dapibus malesuada vitae in massa. Nam semper mi risus, dictum vehicula nisi hendrerit ut. Ut posuere pulvinar ipsum in semper. Cras magna enim, hendrerit eget nisi ac, rutrum malesuada tortor. Pellentesque rutrum pretium mauris, sed tincidunt nunc dapibus non. Nunc semper neque felis, auctor fringilla justo faucibus ac. Aliquam imperdiet dapibus orci, ut bibendum libero iaculis id. Duis at mauris non felis scelerisque maximus. Ut nec nisl urna. Quisque ullamcorper arcu quis ante laoreet, vitae semper ex accumsan. Ut auctor id nisl vel rhoncus.

Nulla egestas massa in libero blandit, vel auctor mi feugiat. In non nulla vitae turpis sollicitudin consectetur a eget lacus. Mauris arcu ex, vestibulum in hendrerit id, blandit eu erat. Nullam nec commodo ex, vel hendrerit mi. Mauris vitae dolor ac purus dignissim varius. In vel faucibus erat, a commodo ante. Phasellus a nisi non arcu volutpat imperdiet vitae ac neque. Pellentesque convallis nunc et mi fermentum pharetra. Nullam tincidunt libero eu est finibus rhoncus. Proin eu lacus sed erat malesuada rhoncus vitae sed odio. Nullam tempus euismod elit, sit amet scelerisque ante tristique vel. In ac libero at diam pulvinar bibendum. Pellentesque gravida neque in ipsum sagittis bibendum.

Sed libero lectus, facilisis et volutpat in, congue vel ex. Morbi ac facilisis diam, eget pellentesque lectus. Vestibulum in ex in eros vulputate accumsan. Donec maximus velit tortor, at euismod purus commodo et. Curabitur vitae consequat lectus. Suspendisse vitae nunc elit. Quisque nec bibendum urna, maximus lobortis metus. Integer tincidunt pulvinar dui, sed euismod metus pulvinar vitae. Aenean lacus augue, consequat quis commodo sed, imperdiet nec risus. Aliquam imperdiet, nisi id aliquam pellentesque, libero magna consequat est, ac facilisis nunc enim id ipsum. Nunc ullamcorper interdum quam, sed facilisis mi porttitor non. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer maximus tortor dui, pulvinar pretium neque tempus quis. Nullam fringilla, urna eu commodo eleifend, nunc velit egestas felis, vel consequat purus leo vel orci. Sed fringilla pellentesque magna.

Nullam eget faucibus risus. Ut tellus tellus, scelerisque sit amet risus nec, mattis condimentum augue. Donec orci justo, aliquet a quam sed, pulvinar sagittis augue. Mauris venenatis dolor eu lacus mattis, vel accumsan velit laoreet. Nulla dapibus vulputate volutpat. Sed eget dictum elit. Morbi a volutpat justo. Suspendisse non diam lorem. Nulla hendrerit ut nisi sed mattis. Morbi vitae consequat velit, sit amet sollicitudin quam. Vestibulum dignissim eleifend mi, a tincidunt libero congue faucibus. Fusce semper posuere sapien, hendrerit molestie risus congue vitae. Ut eu auctor turpis. In hac habitasse platea dictumst. Etiam condimentum urna sit amet arcu venenatis, at commodo augue fermentum.',
        7,
        'trending'
    ),
    (
        'Tekken 8',
        69.99,
        '2024-01-26',
        'images-jeux/Tekken-8.webp',
        '',
        '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit turpis vitae ante maximus mollis id et dui. Phasellus convallis justo id ligula sagittis eleifend. Vestibulum vel finibus lectus. Nullam ac felis nibh. Aenean eu porta lorem. Fusce vestibulum lorem id porta accumsan. Curabitur sit amet ultrices mauris. Nunc tempus nibh facilisis dolor pretium, tempor pretium leo suscipit. Ut consectetur nunc nisi, quis ornare lorem fringilla ac. Sed fringilla risus sodales, eleifend lectus ac, interdum lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris et egestas purus, id egestas nisi.

Cras non mattis purus. Vivamus dignissim pulvinar orci, eu interdum quam hendrerit eget. Nunc elementum imperdiet volutpat. Phasellus enim nibh, lacinia sed orci eu, laoreet lacinia ligula. Morbi ullamcorper finibus magna eu interdum. Aenean nec dolor sed nunc dapibus malesuada vitae in massa. Nam semper mi risus, dictum vehicula nisi hendrerit ut. Ut posuere pulvinar ipsum in semper. Cras magna enim, hendrerit eget nisi ac, rutrum malesuada tortor. Pellentesque rutrum pretium mauris, sed tincidunt nunc dapibus non. Nunc semper neque felis, auctor fringilla justo faucibus ac. Aliquam imperdiet dapibus orci, ut bibendum libero iaculis id. Duis at mauris non felis scelerisque maximus. Ut nec nisl urna. Quisque ullamcorper arcu quis ante laoreet, vitae semper ex accumsan. Ut auctor id nisl vel rhoncus.

Nulla egestas massa in libero blandit, vel auctor mi feugiat. In non nulla vitae turpis sollicitudin consectetur a eget lacus. Mauris arcu ex, vestibulum in hendrerit id, blandit eu erat. Nullam nec commodo ex, vel hendrerit mi. Mauris vitae dolor ac purus dignissim varius. In vel faucibus erat, a commodo ante. Phasellus a nisi non arcu volutpat imperdiet vitae ac neque. Pellentesque convallis nunc et mi fermentum pharetra. Nullam tincidunt libero eu est finibus rhoncus. Proin eu lacus sed erat malesuada rhoncus vitae sed odio. Nullam tempus euismod elit, sit amet scelerisque ante tristique vel. In ac libero at diam pulvinar bibendum. Pellentesque gravida neque in ipsum sagittis bibendum.

Sed libero lectus, facilisis et volutpat in, congue vel ex. Morbi ac facilisis diam, eget pellentesque lectus. Vestibulum in ex in eros vulputate accumsan. Donec maximus velit tortor, at euismod purus commodo et. Curabitur vitae consequat lectus. Suspendisse vitae nunc elit. Quisque nec bibendum urna, maximus lobortis metus. Integer tincidunt pulvinar dui, sed euismod metus pulvinar vitae. Aenean lacus augue, consequat quis commodo sed, imperdiet nec risus. Aliquam imperdiet, nisi id aliquam pellentesque, libero magna consequat est, ac facilisis nunc enim id ipsum. Nunc ullamcorper interdum quam, sed facilisis mi porttitor non. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer maximus tortor dui, pulvinar pretium neque tempus quis. Nullam fringilla, urna eu commodo eleifend, nunc velit egestas felis, vel consequat purus leo vel orci. Sed fringilla pellentesque magna.

Nullam eget faucibus risus. Ut tellus tellus, scelerisque sit amet risus nec, mattis condimentum augue. Donec orci justo, aliquet a quam sed, pulvinar sagittis augue. Mauris venenatis dolor eu lacus mattis, vel accumsan velit laoreet. Nulla dapibus vulputate volutpat. Sed eget dictum elit. Morbi a volutpat justo. Suspendisse non diam lorem. Nulla hendrerit ut nisi sed mattis. Morbi vitae consequat velit, sit amet sollicitudin quam. Vestibulum dignissim eleifend mi, a tincidunt libero congue faucibus. Fusce semper posuere sapien, hendrerit molestie risus congue vitae. Ut eu auctor turpis. In hac habitasse platea dictumst. Etiam condimentum urna sit amet arcu venenatis, at commodo augue fermentum.',
        16,
        'trending'
    ),
    (
        'Street Fighter 6',
        59.99,
        '2023-06-02',
        'images-jeux/Street-Fighter-6.webp',
        '',
        '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit turpis vitae ante maximus mollis id et dui. Phasellus convallis justo id ligula sagittis eleifend. Vestibulum vel finibus lectus. Nullam ac felis nibh. Aenean eu porta lorem. Fusce vestibulum lorem id porta accumsan. Curabitur sit amet ultrices mauris. Nunc tempus nibh facilisis dolor pretium, tempor pretium leo suscipit. Ut consectetur nunc nisi, quis ornare lorem fringilla ac. Sed fringilla risus sodales, eleifend lectus ac, interdum lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris et egestas purus, id egestas nisi.

Cras non mattis purus. Vivamus dignissim pulvinar orci, eu interdum quam hendrerit eget. Nunc elementum imperdiet volutpat. Phasellus enim nibh, lacinia sed orci eu, laoreet lacinia ligula. Morbi ullamcorper finibus magna eu interdum. Aenean nec dolor sed nunc dapibus malesuada vitae in massa. Nam semper mi risus, dictum vehicula nisi hendrerit ut. Ut posuere pulvinar ipsum in semper. Cras magna enim, hendrerit eget nisi ac, rutrum malesuada tortor. Pellentesque rutrum pretium mauris, sed tincidunt nunc dapibus non. Nunc semper neque felis, auctor fringilla justo faucibus ac. Aliquam imperdiet dapibus orci, ut bibendum libero iaculis id. Duis at mauris non felis scelerisque maximus. Ut nec nisl urna. Quisque ullamcorper arcu quis ante laoreet, vitae semper ex accumsan. Ut auctor id nisl vel rhoncus.

Nulla egestas massa in libero blandit, vel auctor mi feugiat. In non nulla vitae turpis sollicitudin consectetur a eget lacus. Mauris arcu ex, vestibulum in hendrerit id, blandit eu erat. Nullam nec commodo ex, vel hendrerit mi. Mauris vitae dolor ac purus dignissim varius. In vel faucibus erat, a commodo ante. Phasellus a nisi non arcu volutpat imperdiet vitae ac neque. Pellentesque convallis nunc et mi fermentum pharetra. Nullam tincidunt libero eu est finibus rhoncus. Proin eu lacus sed erat malesuada rhoncus vitae sed odio. Nullam tempus euismod elit, sit amet scelerisque ante tristique vel. In ac libero at diam pulvinar bibendum. Pellentesque gravida neque in ipsum sagittis bibendum.

Sed libero lectus, facilisis et volutpat in, congue vel ex. Morbi ac facilisis diam, eget pellentesque lectus. Vestibulum in ex in eros vulputate accumsan. Donec maximus velit tortor, at euismod purus commodo et. Curabitur vitae consequat lectus. Suspendisse vitae nunc elit. Quisque nec bibendum urna, maximus lobortis metus. Integer tincidunt pulvinar dui, sed euismod metus pulvinar vitae. Aenean lacus augue, consequat quis commodo sed, imperdiet nec risus. Aliquam imperdiet, nisi id aliquam pellentesque, libero magna consequat est, ac facilisis nunc enim id ipsum. Nunc ullamcorper interdum quam, sed facilisis mi porttitor non. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer maximus tortor dui, pulvinar pretium neque tempus quis. Nullam fringilla, urna eu commodo eleifend, nunc velit egestas felis, vel consequat purus leo vel orci. Sed fringilla pellentesque magna.

Nullam eget faucibus risus. Ut tellus tellus, scelerisque sit amet risus nec, mattis condimentum augue. Donec orci justo, aliquet a quam sed, pulvinar sagittis augue. Mauris venenatis dolor eu lacus mattis, vel accumsan velit laoreet. Nulla dapibus vulputate volutpat. Sed eget dictum elit. Morbi a volutpat justo. Suspendisse non diam lorem. Nulla hendrerit ut nisi sed mattis. Morbi vitae consequat velit, sit amet sollicitudin quam. Vestibulum dignissim eleifend mi, a tincidunt libero congue faucibus. Fusce semper posuere sapien, hendrerit molestie risus congue vitae. Ut eu auctor turpis. In hac habitasse platea dictumst. Etiam condimentum urna sit amet arcu venenatis, at commodo augue fermentum.',
        16,
        'trending'
    ),
    (
        'Monster Hunter: World',
        29.99,
        '2018-01-26',
        'images-jeux/Monster-Hunter-World.webp',
        '',
        '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit turpis vitae ante maximus mollis id et dui. Phasellus convallis justo id ligula sagittis eleifend. Vestibulum vel finibus lectus. Nullam ac felis nibh. Aenean eu porta lorem. Fusce vestibulum lorem id porta accumsan. Curabitur sit amet ultrices mauris. Nunc tempus nibh facilisis dolor pretium, tempor pretium leo suscipit. Ut consectetur nunc nisi, quis ornare lorem fringilla ac. Sed fringilla risus sodales, eleifend lectus ac, interdum lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris et egestas purus, id egestas nisi.

Cras non mattis purus. Vivamus dignissim pulvinar orci, eu interdum quam hendrerit eget. Nunc elementum imperdiet volutpat. Phasellus enim nibh, lacinia sed orci eu, laoreet lacinia ligula. Morbi ullamcorper finibus magna eu interdum. Aenean nec dolor sed nunc dapibus malesuada vitae in massa. Nam semper mi risus, dictum vehicula nisi hendrerit ut. Ut posuere pulvinar ipsum in semper. Cras magna enim, hendrerit eget nisi ac, rutrum malesuada tortor. Pellentesque rutrum pretium mauris, sed tincidunt nunc dapibus non. Nunc semper neque felis, auctor fringilla justo faucibus ac. Aliquam imperdiet dapibus orci, ut bibendum libero iaculis id. Duis at mauris non felis scelerisque maximus. Ut nec nisl urna. Quisque ullamcorper arcu quis ante laoreet, vitae semper ex accumsan. Ut auctor id nisl vel rhoncus.

Nulla egestas massa in libero blandit, vel auctor mi feugiat. In non nulla vitae turpis sollicitudin consectetur a eget lacus. Mauris arcu ex, vestibulum in hendrerit id, blandit eu erat. Nullam nec commodo ex, vel hendrerit mi. Mauris vitae dolor ac purus dignissim varius. In vel faucibus erat, a commodo ante. Phasellus a nisi non arcu volutpat imperdiet vitae ac neque. Pellentesque convallis nunc et mi fermentum pharetra. Nullam tincidunt libero eu est finibus rhoncus. Proin eu lacus sed erat malesuada rhoncus vitae sed odio. Nullam tempus euismod elit, sit amet scelerisque ante tristique vel. In ac libero at diam pulvinar bibendum. Pellentesque gravida neque in ipsum sagittis bibendum.

Sed libero lectus, facilisis et volutpat in, congue vel ex. Morbi ac facilisis diam, eget pellentesque lectus. Vestibulum in ex in eros vulputate accumsan. Donec maximus velit tortor, at euismod purus commodo et. Curabitur vitae consequat lectus. Suspendisse vitae nunc elit. Quisque nec bibendum urna, maximus lobortis metus. Integer tincidunt pulvinar dui, sed euismod metus pulvinar vitae. Aenean lacus augue, consequat quis commodo sed, imperdiet nec risus. Aliquam imperdiet, nisi id aliquam pellentesque, libero magna consequat est, ac facilisis nunc enim id ipsum. Nunc ullamcorper interdum quam, sed facilisis mi porttitor non. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer maximus tortor dui, pulvinar pretium neque tempus quis. Nullam fringilla, urna eu commodo eleifend, nunc velit egestas felis, vel consequat purus leo vel orci. Sed fringilla pellentesque magna.

Nullam eget faucibus risus. Ut tellus tellus, scelerisque sit amet risus nec, mattis condimentum augue. Donec orci justo, aliquet a quam sed, pulvinar sagittis augue. Mauris venenatis dolor eu lacus mattis, vel accumsan velit laoreet. Nulla dapibus vulputate volutpat. Sed eget dictum elit. Morbi a volutpat justo. Suspendisse non diam lorem. Nulla hendrerit ut nisi sed mattis. Morbi vitae consequat velit, sit amet sollicitudin quam. Vestibulum dignissim eleifend mi, a tincidunt libero congue faucibus. Fusce semper posuere sapien, hendrerit molestie risus congue vitae. Ut eu auctor turpis. In hac habitasse platea dictumst. Etiam condimentum urna sit amet arcu venenatis, at commodo augue fermentum.',
        1,
        NULL
    ),
    (
        'Valorant',
        0,
        '2020-06-02',
        'images-jeux/Valorant.webp',
        '',
        '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit turpis vitae ante maximus mollis id et dui. Phasellus convallis justo id ligula sagittis eleifend. Vestibulum vel finibus lectus. Nullam ac felis nibh. Aenean eu porta lorem. Fusce vestibulum lorem id porta accumsan. Curabitur sit amet ultrices mauris. Nunc tempus nibh facilisis dolor pretium, tempor pretium leo suscipit. Ut consectetur nunc nisi, quis ornare lorem fringilla ac. Sed fringilla risus sodales, eleifend lectus ac, interdum lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris et egestas purus, id egestas nisi.

Cras non mattis purus. Vivamus dignissim pulvinar orci, eu interdum quam hendrerit eget. Nunc elementum imperdiet volutpat. Phasellus enim nibh, lacinia sed orci eu, laoreet lacinia ligula. Morbi ullamcorper finibus magna eu interdum. Aenean nec dolor sed nunc dapibus malesuada vitae in massa. Nam semper mi risus, dictum vehicula nisi hendrerit ut. Ut posuere pulvinar ipsum in semper. Cras magna enim, hendrerit eget nisi ac, rutrum malesuada tortor. Pellentesque rutrum pretium mauris, sed tincidunt nunc dapibus non. Nunc semper neque felis, auctor fringilla justo faucibus ac. Aliquam imperdiet dapibus orci, ut bibendum libero iaculis id. Duis at mauris non felis scelerisque maximus. Ut nec nisl urna. Quisque ullamcorper arcu quis ante laoreet, vitae semper ex accumsan. Ut auctor id nisl vel rhoncus.

Nulla egestas massa in libero blandit, vel auctor mi feugiat. In non nulla vitae turpis sollicitudin consectetur a eget lacus. Mauris arcu ex, vestibulum in hendrerit id, blandit eu erat. Nullam nec commodo ex, vel hendrerit mi. Mauris vitae dolor ac purus dignissim varius. In vel faucibus erat, a commodo ante. Phasellus a nisi non arcu volutpat imperdiet vitae ac neque. Pellentesque convallis nunc et mi fermentum pharetra. Nullam tincidunt libero eu est finibus rhoncus. Proin eu lacus sed erat malesuada rhoncus vitae sed odio. Nullam tempus euismod elit, sit amet scelerisque ante tristique vel. In ac libero at diam pulvinar bibendum. Pellentesque gravida neque in ipsum sagittis bibendum.

Sed libero lectus, facilisis et volutpat in, congue vel ex. Morbi ac facilisis diam, eget pellentesque lectus. Vestibulum in ex in eros vulputate accumsan. Donec maximus velit tortor, at euismod purus commodo et. Curabitur vitae consequat lectus. Suspendisse vitae nunc elit. Quisque nec bibendum urna, maximus lobortis metus. Integer tincidunt pulvinar dui, sed euismod metus pulvinar vitae. Aenean lacus augue, consequat quis commodo sed, imperdiet nec risus. Aliquam imperdiet, nisi id aliquam pellentesque, libero magna consequat est, ac facilisis nunc enim id ipsum. Nunc ullamcorper interdum quam, sed facilisis mi porttitor non. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer maximus tortor dui, pulvinar pretium neque tempus quis. Nullam fringilla, urna eu commodo eleifend, nunc velit egestas felis, vel consequat purus leo vel orci. Sed fringilla pellentesque magna.

Nullam eget faucibus risus. Ut tellus tellus, scelerisque sit amet risus nec, mattis condimentum augue. Donec orci justo, aliquet a quam sed, pulvinar sagittis augue. Mauris venenatis dolor eu lacus mattis, vel accumsan velit laoreet. Nulla dapibus vulputate volutpat. Sed eget dictum elit. Morbi a volutpat justo. Suspendisse non diam lorem. Nulla hendrerit ut nisi sed mattis. Morbi vitae consequat velit, sit amet sollicitudin quam. Vestibulum dignissim eleifend mi, a tincidunt libero congue faucibus. Fusce semper posuere sapien, hendrerit molestie risus congue vitae. Ut eu auctor turpis. In hac habitasse platea dictumst. Etiam condimentum urna sit amet arcu venenatis, at commodo augue fermentum.',
        3,
        'trending'
    ),
    (
        'RimWorld',
        34.99,
        '2018-10-17',
        'images-jeux/RimWorld.webp',
        '',
        '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit turpis vitae ante maximus mollis id et dui. Phasellus convallis justo id ligula sagittis eleifend. Vestibulum vel finibus lectus. Nullam ac felis nibh. Aenean eu porta lorem. Fusce vestibulum lorem id porta accumsan. Curabitur sit amet ultrices mauris. Nunc tempus nibh facilisis dolor pretium, tempor pretium leo suscipit. Ut consectetur nunc nisi, quis ornare lorem fringilla ac. Sed fringilla risus sodales, eleifend lectus ac, interdum lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris et egestas purus, id egestas nisi.

Cras non mattis purus. Vivamus dignissim pulvinar orci, eu interdum quam hendrerit eget. Nunc elementum imperdiet volutpat. Phasellus enim nibh, lacinia sed orci eu, laoreet lacinia ligula. Morbi ullamcorper finibus magna eu interdum. Aenean nec dolor sed nunc dapibus malesuada vitae in massa. Nam semper mi risus, dictum vehicula nisi hendrerit ut. Ut posuere pulvinar ipsum in semper. Cras magna enim, hendrerit eget nisi ac, rutrum malesuada tortor. Pellentesque rutrum pretium mauris, sed tincidunt nunc dapibus non. Nunc semper neque felis, auctor fringilla justo faucibus ac. Aliquam imperdiet dapibus orci, ut bibendum libero iaculis id. Duis at mauris non felis scelerisque maximus. Ut nec nisl urna. Quisque ullamcorper arcu quis ante laoreet, vitae semper ex accumsan. Ut auctor id nisl vel rhoncus.

Nulla egestas massa in libero blandit, vel auctor mi feugiat. In non nulla vitae turpis sollicitudin consectetur a eget lacus. Mauris arcu ex, vestibulum in hendrerit id, blandit eu erat. Nullam nec commodo ex, vel hendrerit mi. Mauris vitae dolor ac purus dignissim varius. In vel faucibus erat, a commodo ante. Phasellus a nisi non arcu volutpat imperdiet vitae ac neque. Pellentesque convallis nunc et mi fermentum pharetra. Nullam tincidunt libero eu est finibus rhoncus. Proin eu lacus sed erat malesuada rhoncus vitae sed odio. Nullam tempus euismod elit, sit amet scelerisque ante tristique vel. In ac libero at diam pulvinar bibendum. Pellentesque gravida neque in ipsum sagittis bibendum.

Sed libero lectus, facilisis et volutpat in, congue vel ex. Morbi ac facilisis diam, eget pellentesque lectus. Vestibulum in ex in eros vulputate accumsan. Donec maximus velit tortor, at euismod purus commodo et. Curabitur vitae consequat lectus. Suspendisse vitae nunc elit. Quisque nec bibendum urna, maximus lobortis metus. Integer tincidunt pulvinar dui, sed euismod metus pulvinar vitae. Aenean lacus augue, consequat quis commodo sed, imperdiet nec risus. Aliquam imperdiet, nisi id aliquam pellentesque, libero magna consequat est, ac facilisis nunc enim id ipsum. Nunc ullamcorper interdum quam, sed facilisis mi porttitor non. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer maximus tortor dui, pulvinar pretium neque tempus quis. Nullam fringilla, urna eu commodo eleifend, nunc velit egestas felis, vel consequat purus leo vel orci. Sed fringilla pellentesque magna.

Nullam eget faucibus risus. Ut tellus tellus, scelerisque sit amet risus nec, mattis condimentum augue. Donec orci justo, aliquet a quam sed, pulvinar sagittis augue. Mauris venenatis dolor eu lacus mattis, vel accumsan velit laoreet. Nulla dapibus vulputate volutpat. Sed eget dictum elit. Morbi a volutpat justo. Suspendisse non diam lorem. Nulla hendrerit ut nisi sed mattis. Morbi vitae consequat velit, sit amet sollicitudin quam. Vestibulum dignissim eleifend mi, a tincidunt libero congue faucibus. Fusce semper posuere sapien, hendrerit molestie risus congue vitae. Ut eu auctor turpis. In hac habitasse platea dictumst. Etiam condimentum urna sit amet arcu venenatis, at commodo augue fermentum.',
        5,
        NULL
    ),
    (
        'Diablo IV',
        69.99,
        '2023-06-06',
        'images-jeux/Diablo-IV.webp',
        '',
        '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit turpis vitae ante maximus mollis id et dui. Phasellus convallis justo id ligula sagittis eleifend. Vestibulum vel finibus lectus. Nullam ac felis nibh. Aenean eu porta lorem. Fusce vestibulum lorem id porta accumsan. Curabitur sit amet ultrices mauris. Nunc tempus nibh facilisis dolor pretium, tempor pretium leo suscipit. Ut consectetur nunc nisi, quis ornare lorem fringilla ac. Sed fringilla risus sodales, eleifend lectus ac, interdum lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris et egestas purus, id egestas nisi.

Cras non mattis purus. Vivamus dignissim pulvinar orci, eu interdum quam hendrerit eget. Nunc elementum imperdiet volutpat. Phasellus enim nibh, lacinia sed orci eu, laoreet lacinia ligula. Morbi ullamcorper finibus magna eu interdum. Aenean nec dolor sed nunc dapibus malesuada vitae in massa. Nam semper mi risus, dictum vehicula nisi hendrerit ut. Ut posuere pulvinar ipsum in semper. Cras magna enim, hendrerit eget nisi ac, rutrum malesuada tortor. Pellentesque rutrum pretium mauris, sed tincidunt nunc dapibus non. Nunc semper neque felis, auctor fringilla justo faucibus ac. Aliquam imperdiet dapibus orci, ut bibendum libero iaculis id. Duis at mauris non felis scelerisque maximus. Ut nec nisl urna. Quisque ullamcorper arcu quis ante laoreet, vitae semper ex accumsan. Ut auctor id nisl vel rhoncus.

Nulla egestas massa in libero blandit, vel auctor mi feugiat. In non nulla vitae turpis sollicitudin consectetur a eget lacus. Mauris arcu ex, vestibulum in hendrerit id, blandit eu erat. Nullam nec commodo ex, vel hendrerit mi. Mauris vitae dolor ac purus dignissim varius. In vel faucibus erat, a commodo ante. Phasellus a nisi non arcu volutpat imperdiet vitae ac neque. Pellentesque convallis nunc et mi fermentum pharetra. Nullam tincidunt libero eu est finibus rhoncus. Proin eu lacus sed erat malesuada rhoncus vitae sed odio. Nullam tempus euismod elit, sit amet scelerisque ante tristique vel. In ac libero at diam pulvinar bibendum. Pellentesque gravida neque in ipsum sagittis bibendum.

Sed libero lectus, facilisis et volutpat in, congue vel ex. Morbi ac facilisis diam, eget pellentesque lectus. Vestibulum in ex in eros vulputate accumsan. Donec maximus velit tortor, at euismod purus commodo et. Curabitur vitae consequat lectus. Suspendisse vitae nunc elit. Quisque nec bibendum urna, maximus lobortis metus. Integer tincidunt pulvinar dui, sed euismod metus pulvinar vitae. Aenean lacus augue, consequat quis commodo sed, imperdiet nec risus. Aliquam imperdiet, nisi id aliquam pellentesque, libero magna consequat est, ac facilisis nunc enim id ipsum. Nunc ullamcorper interdum quam, sed facilisis mi porttitor non. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer maximus tortor dui, pulvinar pretium neque tempus quis. Nullam fringilla, urna eu commodo eleifend, nunc velit egestas felis, vel consequat purus leo vel orci. Sed fringilla pellentesque magna.

Nullam eget faucibus risus. Ut tellus tellus, scelerisque sit amet risus nec, mattis condimentum augue. Donec orci justo, aliquet a quam sed, pulvinar sagittis augue. Mauris venenatis dolor eu lacus mattis, vel accumsan velit laoreet. Nulla dapibus vulputate volutpat. Sed eget dictum elit. Morbi a volutpat justo. Suspendisse non diam lorem. Nulla hendrerit ut nisi sed mattis. Morbi vitae consequat velit, sit amet sollicitudin quam. Vestibulum dignissim eleifend mi, a tincidunt libero congue faucibus. Fusce semper posuere sapien, hendrerit molestie risus congue vitae. Ut eu auctor turpis. In hac habitasse platea dictumst. Etiam condimentum urna sit amet arcu venenatis, at commodo augue fermentum.',
        13,
        'trending'
    ),
    (
        'Rust',
        39.99,
        '2018-02-08',
        'images-jeux/Rust.webp',
        '',
        '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit turpis vitae ante maximus mollis id et dui. Phasellus convallis justo id ligula sagittis eleifend. Vestibulum vel finibus lectus. Nullam ac felis nibh. Aenean eu porta lorem. Fusce vestibulum lorem id porta accumsan. Curabitur sit amet ultrices mauris. Nunc tempus nibh facilisis dolor pretium, tempor pretium leo suscipit. Ut consectetur nunc nisi, quis ornare lorem fringilla ac. Sed fringilla risus sodales, eleifend lectus ac, interdum lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris et egestas purus, id egestas nisi.

Cras non mattis purus. Vivamus dignissim pulvinar orci, eu interdum quam hendrerit eget. Nunc elementum imperdiet volutpat. Phasellus enim nibh, lacinia sed orci eu, laoreet lacinia ligula. Morbi ullamcorper finibus magna eu interdum. Aenean nec dolor sed nunc dapibus malesuada vitae in massa. Nam semper mi risus, dictum vehicula nisi hendrerit ut. Ut posuere pulvinar ipsum in semper. Cras magna enim, hendrerit eget nisi ac, rutrum malesuada tortor. Pellentesque rutrum pretium mauris, sed tincidunt nunc dapibus non. Nunc semper neque felis, auctor fringilla justo faucibus ac. Aliquam imperdiet dapibus orci, ut bibendum libero iaculis id. Duis at mauris non felis scelerisque maximus. Ut nec nisl urna. Quisque ullamcorper arcu quis ante laoreet, vitae semper ex accumsan. Ut auctor id nisl vel rhoncus.

Nulla egestas massa in libero blandit, vel auctor mi feugiat. In non nulla vitae turpis sollicitudin consectetur a eget lacus. Mauris arcu ex, vestibulum in hendrerit id, blandit eu erat. Nullam nec commodo ex, vel hendrerit mi. Mauris vitae dolor ac purus dignissim varius. In vel faucibus erat, a commodo ante. Phasellus a nisi non arcu volutpat imperdiet vitae ac neque. Pellentesque convallis nunc et mi fermentum pharetra. Nullam tincidunt libero eu est finibus rhoncus. Proin eu lacus sed erat malesuada rhoncus vitae sed odio. Nullam tempus euismod elit, sit amet scelerisque ante tristique vel. In ac libero at diam pulvinar bibendum. Pellentesque gravida neque in ipsum sagittis bibendum.

Sed libero lectus, facilisis et volutpat in, congue vel ex. Morbi ac facilisis diam, eget pellentesque lectus. Vestibulum in ex in eros vulputate accumsan. Donec maximus velit tortor, at euismod purus commodo et. Curabitur vitae consequat lectus. Suspendisse vitae nunc elit. Quisque nec bibendum urna, maximus lobortis metus. Integer tincidunt pulvinar dui, sed euismod metus pulvinar vitae. Aenean lacus augue, consequat quis commodo sed, imperdiet nec risus. Aliquam imperdiet, nisi id aliquam pellentesque, libero magna consequat est, ac facilisis nunc enim id ipsum. Nunc ullamcorper interdum quam, sed facilisis mi porttitor non. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer maximus tortor dui, pulvinar pretium neque tempus quis. Nullam fringilla, urna eu commodo eleifend, nunc velit egestas felis, vel consequat purus leo vel orci. Sed fringilla pellentesque magna.

Nullam eget faucibus risus. Ut tellus tellus, scelerisque sit amet risus nec, mattis condimentum augue. Donec orci justo, aliquet a quam sed, pulvinar sagittis augue. Mauris venenatis dolor eu lacus mattis, vel accumsan velit laoreet. Nulla dapibus vulputate volutpat. Sed eget dictum elit. Morbi a volutpat justo. Suspendisse non diam lorem. Nulla hendrerit ut nisi sed mattis. Morbi vitae consequat velit, sit amet sollicitudin quam. Vestibulum dignissim eleifend mi, a tincidunt libero congue faucibus. Fusce semper posuere sapien, hendrerit molestie risus congue vitae. Ut eu auctor turpis. In hac habitasse platea dictumst. Etiam condimentum urna sit amet arcu venenatis, at commodo augue fermentum.',
        15,
        NULL
    ),
    (
        'Ark: Survival Evolved',
        19.99,
        '2017-08-29',
        'images-jeux/Ark-Survival-Evolved.webp',
        '',
        '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit turpis vitae ante maximus mollis id et dui. Phasellus convallis justo id ligula sagittis eleifend. Vestibulum vel finibus lectus. Nullam ac felis nibh. Aenean eu porta lorem. Fusce vestibulum lorem id porta accumsan. Curabitur sit amet ultrices mauris. Nunc tempus nibh facilisis dolor pretium, tempor pretium leo suscipit. Ut consectetur nunc nisi, quis ornare lorem fringilla ac. Sed fringilla risus sodales, eleifend lectus ac, interdum lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris et egestas purus, id egestas nisi.

Cras non mattis purus. Vivamus dignissim pulvinar orci, eu interdum quam hendrerit eget. Nunc elementum imperdiet volutpat. Phasellus enim nibh, lacinia sed orci eu, laoreet lacinia ligula. Morbi ullamcorper finibus magna eu interdum. Aenean nec dolor sed nunc dapibus malesuada vitae in massa. Nam semper mi risus, dictum vehicula nisi hendrerit ut. Ut posuere pulvinar ipsum in semper. Cras magna enim, hendrerit eget nisi ac, rutrum malesuada tortor. Pellentesque rutrum pretium mauris, sed tincidunt nunc dapibus non. Nunc semper neque felis, auctor fringilla justo faucibus ac. Aliquam imperdiet dapibus orci, ut bibendum libero iaculis id. Duis at mauris non felis scelerisque maximus. Ut nec nisl urna. Quisque ullamcorper arcu quis ante laoreet, vitae semper ex accumsan. Ut auctor id nisl vel rhoncus.

Nulla egestas massa in libero blandit, vel auctor mi feugiat. In non nulla vitae turpis sollicitudin consectetur a eget lacus. Mauris arcu ex, vestibulum in hendrerit id, blandit eu erat. Nullam nec commodo ex, vel hendrerit mi. Mauris vitae dolor ac purus dignissim varius. In vel faucibus erat, a commodo ante. Phasellus a nisi non arcu volutpat imperdiet vitae ac neque. Pellentesque convallis nunc et mi fermentum pharetra. Nullam tincidunt libero eu est finibus rhoncus. Proin eu lacus sed erat malesuada rhoncus vitae sed odio. Nullam tempus euismod elit, sit amet scelerisque ante tristique vel. In ac libero at diam pulvinar bibendum. Pellentesque gravida neque in ipsum sagittis bibendum.

Sed libero lectus, facilisis et volutpat in, congue vel ex. Morbi ac facilisis diam, eget pellentesque lectus. Vestibulum in ex in eros vulputate accumsan. Donec maximus velit tortor, at euismod purus commodo et. Curabitur vitae consequat lectus. Suspendisse vitae nunc elit. Quisque nec bibendum urna, maximus lobortis metus. Integer tincidunt pulvinar dui, sed euismod metus pulvinar vitae. Aenean lacus augue, consequat quis commodo sed, imperdiet nec risus. Aliquam imperdiet, nisi id aliquam pellentesque, libero magna consequat est, ac facilisis nunc enim id ipsum. Nunc ullamcorper interdum quam, sed facilisis mi porttitor non. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer maximus tortor dui, pulvinar pretium neque tempus quis. Nullam fringilla, urna eu commodo eleifend, nunc velit egestas felis, vel consequat purus leo vel orci. Sed fringilla pellentesque magna.

Nullam eget faucibus risus. Ut tellus tellus, scelerisque sit amet risus nec, mattis condimentum augue. Donec orci justo, aliquet a quam sed, pulvinar sagittis augue. Mauris venenatis dolor eu lacus mattis, vel accumsan velit laoreet. Nulla dapibus vulputate volutpat. Sed eget dictum elit. Morbi a volutpat justo. Suspendisse non diam lorem. Nulla hendrerit ut nisi sed mattis. Morbi vitae consequat velit, sit amet sollicitudin quam. Vestibulum dignissim eleifend mi, a tincidunt libero congue faucibus. Fusce semper posuere sapien, hendrerit molestie risus congue vitae. Ut eu auctor turpis. In hac habitasse platea dictumst. Etiam condimentum urna sit amet arcu venenatis, at commodo augue fermentum.',
        15,
        NULL
    ),
    (
        'Sea of Thieves',
        39.99,
        '2018-03-20',
        'images-jeux/Sea-of-Thieves.webp',
        '',
        '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit turpis vitae ante maximus mollis id et dui. Phasellus convallis justo id ligula sagittis eleifend. Vestibulum vel finibus lectus. Nullam ac felis nibh. Aenean eu porta lorem. Fusce vestibulum lorem id porta accumsan. Curabitur sit amet ultrices mauris. Nunc tempus nibh facilisis dolor pretium, tempor pretium leo suscipit. Ut consectetur nunc nisi, quis ornare lorem fringilla ac. Sed fringilla risus sodales, eleifend lectus ac, interdum lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris et egestas purus, id egestas nisi.

Cras non mattis purus. Vivamus dignissim pulvinar orci, eu interdum quam hendrerit eget. Nunc elementum imperdiet volutpat. Phasellus enim nibh, lacinia sed orci eu, laoreet lacinia ligula. Morbi ullamcorper finibus magna eu interdum. Aenean nec dolor sed nunc dapibus malesuada vitae in massa. Nam semper mi risus, dictum vehicula nisi hendrerit ut. Ut posuere pulvinar ipsum in semper. Cras magna enim, hendrerit eget nisi ac, rutrum malesuada tortor. Pellentesque rutrum pretium mauris, sed tincidunt nunc dapibus non. Nunc semper neque felis, auctor fringilla justo faucibus ac. Aliquam imperdiet dapibus orci, ut bibendum libero iaculis id. Duis at mauris non felis scelerisque maximus. Ut nec nisl urna. Quisque ullamcorper arcu quis ante laoreet, vitae semper ex accumsan. Ut auctor id nisl vel rhoncus.

Nulla egestas massa in libero blandit, vel auctor mi feugiat. In non nulla vitae turpis sollicitudin consectetur a eget lacus. Mauris arcu ex, vestibulum in hendrerit id, blandit eu erat. Nullam nec commodo ex, vel hendrerit mi. Mauris vitae dolor ac purus dignissim varius. In vel faucibus erat, a commodo ante. Phasellus a nisi non arcu volutpat imperdiet vitae ac neque. Pellentesque convallis nunc et mi fermentum pharetra. Nullam tincidunt libero eu est finibus rhoncus. Proin eu lacus sed erat malesuada rhoncus vitae sed odio. Nullam tempus euismod elit, sit amet scelerisque ante tristique vel. In ac libero at diam pulvinar bibendum. Pellentesque gravida neque in ipsum sagittis bibendum.

Sed libero lectus, facilisis et volutpat in, congue vel ex. Morbi ac facilisis diam, eget pellentesque lectus. Vestibulum in ex in eros vulputate accumsan. Donec maximus velit tortor, at euismod purus commodo et. Curabitur vitae consequat lectus. Suspendisse vitae nunc elit. Quisque nec bibendum urna, maximus lobortis metus. Integer tincidunt pulvinar dui, sed euismod metus pulvinar vitae. Aenean lacus augue, consequat quis commodo sed, imperdiet nec risus. Aliquam imperdiet, nisi id aliquam pellentesque, libero magna consequat est, ac facilisis nunc enim id ipsum. Nunc ullamcorper interdum quam, sed facilisis mi porttitor non. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer maximus tortor dui, pulvinar pretium neque tempus quis. Nullam fringilla, urna eu commodo eleifend, nunc velit egestas felis, vel consequat purus leo vel orci. Sed fringilla pellentesque magna.

Nullam eget faucibus risus. Ut tellus tellus, scelerisque sit amet risus nec, mattis condimentum augue. Donec orci justo, aliquet a quam sed, pulvinar sagittis augue. Mauris venenatis dolor eu lacus mattis, vel accumsan velit laoreet. Nulla dapibus vulputate volutpat. Sed eget dictum elit. Morbi a volutpat justo. Suspendisse non diam lorem. Nulla hendrerit ut nisi sed mattis. Morbi vitae consequat velit, sit amet sollicitudin quam. Vestibulum dignissim eleifend mi, a tincidunt libero congue faucibus. Fusce semper posuere sapien, hendrerit molestie risus congue vitae. Ut eu auctor turpis. In hac habitasse platea dictumst. Etiam condimentum urna sit amet arcu venenatis, at commodo augue fermentum.',
        2,
        NULL
    ),
    (
        'Guild Wars 2',
        0,
        '2012-08-28',
        'images-jeux/Guild-Wars-2.webp',
        '',
        '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit turpis vitae ante maximus mollis id et dui. Phasellus convallis justo id ligula sagittis eleifend. Vestibulum vel finibus lectus. Nullam ac felis nibh. Aenean eu porta lorem. Fusce vestibulum lorem id porta accumsan. Curabitur sit amet ultrices mauris. Nunc tempus nibh facilisis dolor pretium, tempor pretium leo suscipit. Ut consectetur nunc nisi, quis ornare lorem fringilla ac. Sed fringilla risus sodales, eleifend lectus ac, interdum lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris et egestas purus, id egestas nisi.

Cras non mattis purus. Vivamus dignissim pulvinar orci, eu interdum quam hendrerit eget. Nunc elementum imperdiet volutpat. Phasellus enim nibh, lacinia sed orci eu, laoreet lacinia ligula. Morbi ullamcorper finibus magna eu interdum. Aenean nec dolor sed nunc dapibus malesuada vitae in massa. Nam semper mi risus, dictum vehicula nisi hendrerit ut. Ut posuere pulvinar ipsum in semper. Cras magna enim, hendrerit eget nisi ac, rutrum malesuada tortor. Pellentesque rutrum pretium mauris, sed tincidunt nunc dapibus non. Nunc semper neque felis, auctor fringilla justo faucibus ac. Aliquam imperdiet dapibus orci, ut bibendum libero iaculis id. Duis at mauris non felis scelerisque maximus. Ut nec nisl urna. Quisque ullamcorper arcu quis ante laoreet, vitae semper ex accumsan. Ut auctor id nisl vel rhoncus.

Nulla egestas massa in libero blandit, vel auctor mi feugiat. In non nulla vitae turpis sollicitudin consectetur a eget lacus. Mauris arcu ex, vestibulum in hendrerit id, blandit eu erat. Nullam nec commodo ex, vel hendrerit mi. Mauris vitae dolor ac purus dignissim varius. In vel faucibus erat, a commodo ante. Phasellus a nisi non arcu volutpat imperdiet vitae ac neque. Pellentesque convallis nunc et mi fermentum pharetra. Nullam tincidunt libero eu est finibus rhoncus. Proin eu lacus sed erat malesuada rhoncus vitae sed odio. Nullam tempus euismod elit, sit amet scelerisque ante tristique vel. In ac libero at diam pulvinar bibendum. Pellentesque gravida neque in ipsum sagittis bibendum.

Sed libero lectus, facilisis et volutpat in, congue vel ex. Morbi ac facilisis diam, eget pellentesque lectus. Vestibulum in ex in eros vulputate accumsan. Donec maximus velit tortor, at euismod purus commodo et. Curabitur vitae consequat lectus. Suspendisse vitae nunc elit. Quisque nec bibendum urna, maximus lobortis metus. Integer tincidunt pulvinar dui, sed euismod metus pulvinar vitae. Aenean lacus augue, consequat quis commodo sed, imperdiet nec risus. Aliquam imperdiet, nisi id aliquam pellentesque, libero magna consequat est, ac facilisis nunc enim id ipsum. Nunc ullamcorper interdum quam, sed facilisis mi porttitor non. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer maximus tortor dui, pulvinar pretium neque tempus quis. Nullam fringilla, urna eu commodo eleifend, nunc velit egestas felis, vel consequat purus leo vel orci. Sed fringilla pellentesque magna.

Nullam eget faucibus risus. Ut tellus tellus, scelerisque sit amet risus nec, mattis condimentum augue. Donec orci justo, aliquet a quam sed, pulvinar sagittis augue. Mauris venenatis dolor eu lacus mattis, vel accumsan velit laoreet. Nulla dapibus vulputate volutpat. Sed eget dictum elit. Morbi a volutpat justo. Suspendisse non diam lorem. Nulla hendrerit ut nisi sed mattis. Morbi vitae consequat velit, sit amet sollicitudin quam. Vestibulum dignissim eleifend mi, a tincidunt libero congue faucibus. Fusce semper posuere sapien, hendrerit molestie risus congue vitae. Ut eu auctor turpis. In hac habitasse platea dictumst. Etiam condimentum urna sit amet arcu venenatis, at commodo augue fermentum.',
        11,
        NULL
    ),
    (
        'Black Desert Online',
        9.99,
        '2016-03-03',
        'images-jeux/Black-Desert-Online.webp',
        '',
        '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit turpis vitae ante maximus mollis id et dui. Phasellus convallis justo id ligula sagittis eleifend. Vestibulum vel finibus lectus. Nullam ac felis nibh. Aenean eu porta lorem. Fusce vestibulum lorem id porta accumsan. Curabitur sit amet ultrices mauris. Nunc tempus nibh facilisis dolor pretium, tempor pretium leo suscipit. Ut consectetur nunc nisi, quis ornare lorem fringilla ac. Sed fringilla risus sodales, eleifend lectus ac, interdum lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris et egestas purus, id egestas nisi.

Cras non mattis purus. Vivamus dignissim pulvinar orci, eu interdum quam hendrerit eget. Nunc elementum imperdiet volutpat. Phasellus enim nibh, lacinia sed orci eu, laoreet lacinia ligula. Morbi ullamcorper finibus magna eu interdum. Aenean nec dolor sed nunc dapibus malesuada vitae in massa. Nam semper mi risus, dictum vehicula nisi hendrerit ut. Ut posuere pulvinar ipsum in semper. Cras magna enim, hendrerit eget nisi ac, rutrum malesuada tortor. Pellentesque rutrum pretium mauris, sed tincidunt nunc dapibus non. Nunc semper neque felis, auctor fringilla justo faucibus ac. Aliquam imperdiet dapibus orci, ut bibendum libero iaculis id. Duis at mauris non felis scelerisque maximus. Ut nec nisl urna. Quisque ullamcorper arcu quis ante laoreet, vitae semper ex accumsan. Ut auctor id nisl vel rhoncus.

Nulla egestas massa in libero blandit, vel auctor mi feugiat. In non nulla vitae turpis sollicitudin consectetur a eget lacus. Mauris arcu ex, vestibulum in hendrerit id, blandit eu erat. Nullam nec commodo ex, vel hendrerit mi. Mauris vitae dolor ac purus dignissim varius. In vel faucibus erat, a commodo ante. Phasellus a nisi non arcu volutpat imperdiet vitae ac neque. Pellentesque convallis nunc et mi fermentum pharetra. Nullam tincidunt libero eu est finibus rhoncus. Proin eu lacus sed erat malesuada rhoncus vitae sed odio. Nullam tempus euismod elit, sit amet scelerisque ante tristique vel. In ac libero at diam pulvinar bibendum. Pellentesque gravida neque in ipsum sagittis bibendum.

Sed libero lectus, facilisis et volutpat in, congue vel ex. Morbi ac facilisis diam, eget pellentesque lectus. Vestibulum in ex in eros vulputate accumsan. Donec maximus velit tortor, at euismod purus commodo et. Curabitur vitae consequat lectus. Suspendisse vitae nunc elit. Quisque nec bibendum urna, maximus lobortis metus. Integer tincidunt pulvinar dui, sed euismod metus pulvinar vitae. Aenean lacus augue, consequat quis commodo sed, imperdiet nec risus. Aliquam imperdiet, nisi id aliquam pellentesque, libero magna consequat est, ac facilisis nunc enim id ipsum. Nunc ullamcorper interdum quam, sed facilisis mi porttitor non. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer maximus tortor dui, pulvinar pretium neque tempus quis. Nullam fringilla, urna eu commodo eleifend, nunc velit egestas felis, vel consequat purus leo vel orci. Sed fringilla pellentesque magna.

Nullam eget faucibus risus. Ut tellus tellus, scelerisque sit amet risus nec, mattis condimentum augue. Donec orci justo, aliquet a quam sed, pulvinar sagittis augue. Mauris venenatis dolor eu lacus mattis, vel accumsan velit laoreet. Nulla dapibus vulputate volutpat. Sed eget dictum elit. Morbi a volutpat justo. Suspendisse non diam lorem. Nulla hendrerit ut nisi sed mattis. Morbi vitae consequat velit, sit amet sollicitudin quam. Vestibulum dignissim eleifend mi, a tincidunt libero congue faucibus. Fusce semper posuere sapien, hendrerit molestie risus congue vitae. Ut eu auctor turpis. In hac habitasse platea dictumst. Etiam condimentum urna sit amet arcu venenatis, at commodo augue fermentum.',
        11,
        NULL
    ),
    (
        'The Crew Motorfest',
        69.99,
        '2023-09-14',
        'images-jeux/The-Crew-Motorfest.webp',
        '',
        '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit turpis vitae ante maximus mollis id et dui. Phasellus convallis justo id ligula sagittis eleifend. Vestibulum vel finibus lectus. Nullam ac felis nibh. Aenean eu porta lorem. Fusce vestibulum lorem id porta accumsan. Curabitur sit amet ultrices mauris. Nunc tempus nibh facilisis dolor pretium, tempor pretium leo suscipit. Ut consectetur nunc nisi, quis ornare lorem fringilla ac. Sed fringilla risus sodales, eleifend lectus ac, interdum lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris et egestas purus, id egestas nisi.

Cras non mattis purus. Vivamus dignissim pulvinar orci, eu interdum quam hendrerit eget. Nunc elementum imperdiet volutpat. Phasellus enim nibh, lacinia sed orci eu, laoreet lacinia ligula. Morbi ullamcorper finibus magna eu interdum. Aenean nec dolor sed nunc dapibus malesuada vitae in massa. Nam semper mi risus, dictum vehicula nisi hendrerit ut. Ut posuere pulvinar ipsum in semper. Cras magna enim, hendrerit eget nisi ac, rutrum malesuada tortor. Pellentesque rutrum pretium mauris, sed tincidunt nunc dapibus non. Nunc semper neque felis, auctor fringilla justo faucibus ac. Aliquam imperdiet dapibus orci, ut bibendum libero iaculis id. Duis at mauris non felis scelerisque maximus. Ut nec nisl urna. Quisque ullamcorper arcu quis ante laoreet, vitae semper ex accumsan. Ut auctor id nisl vel rhoncus.

Nulla egestas massa in libero blandit, vel auctor mi feugiat. In non nulla vitae turpis sollicitudin consectetur a eget lacus. Mauris arcu ex, vestibulum in hendrerit id, blandit eu erat. Nullam nec commodo ex, vel hendrerit mi. Mauris vitae dolor ac purus dignissim varius. In vel faucibus erat, a commodo ante. Phasellus a nisi non arcu volutpat imperdiet vitae ac neque. Pellentesque convallis nunc et mi fermentum pharetra. Nullam tincidunt libero eu est finibus rhoncus. Proin eu lacus sed erat malesuada rhoncus vitae sed odio. Nullam tempus euismod elit, sit amet scelerisque ante tristique vel. In ac libero at diam pulvinar bibendum. Pellentesque gravida neque in ipsum sagittis bibendum.

Sed libero lectus, facilisis et volutpat in, congue vel ex. Morbi ac facilisis diam, eget pellentesque lectus. Vestibulum in ex in eros vulputate accumsan. Donec maximus velit tortor, at euismod purus commodo et. Curabitur vitae consequat lectus. Suspendisse vitae nunc elit. Quisque nec bibendum urna, maximus lobortis metus. Integer tincidunt pulvinar dui, sed euismod metus pulvinar vitae. Aenean lacus augue, consequat quis commodo sed, imperdiet nec risus. Aliquam imperdiet, nisi id aliquam pellentesque, libero magna consequat est, ac facilisis nunc enim id ipsum. Nunc ullamcorper interdum quam, sed facilisis mi porttitor non. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer maximus tortor dui, pulvinar pretium neque tempus quis. Nullam fringilla, urna eu commodo eleifend, nunc velit egestas felis, vel consequat purus leo vel orci. Sed fringilla pellentesque magna.

Nullam eget faucibus risus. Ut tellus tellus, scelerisque sit amet risus nec, mattis condimentum augue. Donec orci justo, aliquet a quam sed, pulvinar sagittis augue. Mauris venenatis dolor eu lacus mattis, vel accumsan velit laoreet. Nulla dapibus vulputate volutpat. Sed eget dictum elit. Morbi a volutpat justo. Suspendisse non diam lorem. Nulla hendrerit ut nisi sed mattis. Morbi vitae consequat velit, sit amet sollicitudin quam. Vestibulum dignissim eleifend mi, a tincidunt libero congue faucibus. Fusce semper posuere sapien, hendrerit molestie risus congue vitae. Ut eu auctor turpis. In hac habitasse platea dictumst. Etiam condimentum urna sit amet arcu venenatis, at commodo augue fermentum.',
        6,
        'trending'
    ),
    (
        'Gran Turismo 7',
        69.99,
        '2022-03-04',
        'images-jeux/Gran-Turismo-7.webp',
        '',
        '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit turpis vitae ante maximus mollis id et dui. Phasellus convallis justo id ligula sagittis eleifend. Vestibulum vel finibus lectus. Nullam ac felis nibh. Aenean eu porta lorem. Fusce vestibulum lorem id porta accumsan. Curabitur sit amet ultrices mauris. Nunc tempus nibh facilisis dolor pretium, tempor pretium leo suscipit. Ut consectetur nunc nisi, quis ornare lorem fringilla ac. Sed fringilla risus sodales, eleifend lectus ac, interdum lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris et egestas purus, id egestas nisi.

Cras non mattis purus. Vivamus dignissim pulvinar orci, eu interdum quam hendrerit eget. Nunc elementum imperdiet volutpat. Phasellus enim nibh, lacinia sed orci eu, laoreet lacinia ligula. Morbi ullamcorper finibus magna eu interdum. Aenean nec dolor sed nunc dapibus malesuada vitae in massa. Nam semper mi risus, dictum vehicula nisi hendrerit ut. Ut posuere pulvinar ipsum in semper. Cras magna enim, hendrerit eget nisi ac, rutrum malesuada tortor. Pellentesque rutrum pretium mauris, sed tincidunt nunc dapibus non. Nunc semper neque felis, auctor fringilla justo faucibus ac. Aliquam imperdiet dapibus orci, ut bibendum libero iaculis id. Duis at mauris non felis scelerisque maximus. Ut nec nisl urna. Quisque ullamcorper arcu quis ante laoreet, vitae semper ex accumsan. Ut auctor id nisl vel rhoncus.

Nulla egestas massa in libero blandit, vel auctor mi feugiat. In non nulla vitae turpis sollicitudin consectetur a eget lacus. Mauris arcu ex, vestibulum in hendrerit id, blandit eu erat. Nullam nec commodo ex, vel hendrerit mi. Mauris vitae dolor ac purus dignissim varius. In vel faucibus erat, a commodo ante. Phasellus a nisi non arcu volutpat imperdiet vitae ac neque. Pellentesque convallis nunc et mi fermentum pharetra. Nullam tincidunt libero eu est finibus rhoncus. Proin eu lacus sed erat malesuada rhoncus vitae sed odio. Nullam tempus euismod elit, sit amet scelerisque ante tristique vel. In ac libero at diam pulvinar bibendum. Pellentesque gravida neque in ipsum sagittis bibendum.

Sed libero lectus, facilisis et volutpat in, congue vel ex. Morbi ac facilisis diam, eget pellentesque lectus. Vestibulum in ex in eros vulputate accumsan. Donec maximus velit tortor, at euismod purus commodo et. Curabitur vitae consequat lectus. Suspendisse vitae nunc elit. Quisque nec bibendum urna, maximus lobortis metus. Integer tincidunt pulvinar dui, sed euismod metus pulvinar vitae. Aenean lacus augue, consequat quis commodo sed, imperdiet nec risus. Aliquam imperdiet, nisi id aliquam pellentesque, libero magna consequat est, ac facilisis nunc enim id ipsum. Nunc ullamcorper interdum quam, sed facilisis mi porttitor non. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer maximus tortor dui, pulvinar pretium neque tempus quis. Nullam fringilla, urna eu commodo eleifend, nunc velit egestas felis, vel consequat purus leo vel orci. Sed fringilla pellentesque magna.

Nullam eget faucibus risus. Ut tellus tellus, scelerisque sit amet risus nec, mattis condimentum augue. Donec orci justo, aliquet a quam sed, pulvinar sagittis augue. Mauris venenatis dolor eu lacus mattis, vel accumsan velit laoreet. Nulla dapibus vulputate volutpat. Sed eget dictum elit. Morbi a volutpat justo. Suspendisse non diam lorem. Nulla hendrerit ut nisi sed mattis. Morbi vitae consequat velit, sit amet sollicitudin quam. Vestibulum dignissim eleifend mi, a tincidunt libero congue faucibus. Fusce semper posuere sapien, hendrerit molestie risus congue vitae. Ut eu auctor turpis. In hac habitasse platea dictumst. Etiam condimentum urna sit amet arcu venenatis, at commodo augue fermentum.',
        6,
        'trending'
    ),
    (
        'Mortal Kombat 1',
        69.99,
        '2023-09-19',
        'images-jeux/Mortal-Kombat-1.webp',
        '',
        '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit turpis vitae ante maximus mollis id et dui. Phasellus convallis justo id ligula sagittis eleifend. Vestibulum vel finibus lectus. Nullam ac felis nibh. Aenean eu porta lorem. Fusce vestibulum lorem id porta accumsan. Curabitur sit amet ultrices mauris. Nunc tempus nibh facilisis dolor pretium, tempor pretium leo suscipit. Ut consectetur nunc nisi, quis ornare lorem fringilla ac. Sed fringilla risus sodales, eleifend lectus ac, interdum lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris et egestas purus, id egestas nisi.

Cras non mattis purus. Vivamus dignissim pulvinar orci, eu interdum quam hendrerit eget. Nunc elementum imperdiet volutpat. Phasellus enim nibh, lacinia sed orci eu, laoreet lacinia ligula. Morbi ullamcorper finibus magna eu interdum. Aenean nec dolor sed nunc dapibus malesuada vitae in massa. Nam semper mi risus, dictum vehicula nisi hendrerit ut. Ut posuere pulvinar ipsum in semper. Cras magna enim, hendrerit eget nisi ac, rutrum malesuada tortor. Pellentesque rutrum pretium mauris, sed tincidunt nunc dapibus non. Nunc semper neque felis, auctor fringilla justo faucibus ac. Aliquam imperdiet dapibus orci, ut bibendum libero iaculis id. Duis at mauris non felis scelerisque maximus. Ut nec nisl urna. Quisque ullamcorper arcu quis ante laoreet, vitae semper ex accumsan. Ut auctor id nisl vel rhoncus.

Nulla egestas massa in libero blandit, vel auctor mi feugiat. In non nulla vitae turpis sollicitudin consectetur a eget lacus. Mauris arcu ex, vestibulum in hendrerit id, blandit eu erat. Nullam nec commodo ex, vel hendrerit mi. Mauris vitae dolor ac purus dignissim varius. In vel faucibus erat, a commodo ante. Phasellus a nisi non arcu volutpat imperdiet vitae ac neque. Pellentesque convallis nunc et mi fermentum pharetra. Nullam tincidunt libero eu est finibus rhoncus. Proin eu lacus sed erat malesuada rhoncus vitae sed odio. Nullam tempus euismod elit, sit amet scelerisque ante tristique vel. In ac libero at diam pulvinar bibendum. Pellentesque gravida neque in ipsum sagittis bibendum.

Sed libero lectus, facilisis et volutpat in, congue vel ex. Morbi ac facilisis diam, eget pellentesque lectus. Vestibulum in ex in eros vulputate accumsan. Donec maximus velit tortor, at euismod purus commodo et. Curabitur vitae consequat lectus. Suspendisse vitae nunc elit. Quisque nec bibendum urna, maximus lobortis metus. Integer tincidunt pulvinar dui, sed euismod metus pulvinar vitae. Aenean lacus augue, consequat quis commodo sed, imperdiet nec risus. Aliquam imperdiet, nisi id aliquam pellentesque, libero magna consequat est, ac facilisis nunc enim id ipsum. Nunc ullamcorper interdum quam, sed facilisis mi porttitor non. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer maximus tortor dui, pulvinar pretium neque tempus quis. Nullam fringilla, urna eu commodo eleifend, nunc velit egestas felis, vel consequat purus leo vel orci. Sed fringilla pellentesque magna.

Nullam eget faucibus risus. Ut tellus tellus, scelerisque sit amet risus nec, mattis condimentum augue. Donec orci justo, aliquet a quam sed, pulvinar sagittis augue. Mauris venenatis dolor eu lacus mattis, vel accumsan velit laoreet. Nulla dapibus vulputate volutpat. Sed eget dictum elit. Morbi a volutpat justo. Suspendisse non diam lorem. Nulla hendrerit ut nisi sed mattis. Morbi vitae consequat velit, sit amet sollicitudin quam. Vestibulum dignissim eleifend mi, a tincidunt libero congue faucibus. Fusce semper posuere sapien, hendrerit molestie risus congue vitae. Ut eu auctor turpis. In hac habitasse platea dictumst. Etiam condimentum urna sit amet arcu venenatis, at commodo augue fermentum.',
        16,
        'trending'
    ),
    (
        'It Takes Two',
        39.99,
        '2021-03-26',
        'images-jeux/It-Takes-Two.webp',
        '',
        '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit turpis vitae ante maximus mollis id et dui. Phasellus convallis justo id ligula sagittis eleifend. Vestibulum vel finibus lectus. Nullam ac felis nibh. Aenean eu porta lorem. Fusce vestibulum lorem id porta accumsan. Curabitur sit amet ultrices mauris. Nunc tempus nibh facilisis dolor pretium, tempor pretium leo suscipit. Ut consectetur nunc nisi, quis ornare lorem fringilla ac. Sed fringilla risus sodales, eleifend lectus ac, interdum lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris et egestas purus, id egestas nisi.

Cras non mattis purus. Vivamus dignissim pulvinar orci, eu interdum quam hendrerit eget. Nunc elementum imperdiet volutpat. Phasellus enim nibh, lacinia sed orci eu, laoreet lacinia ligula. Morbi ullamcorper finibus magna eu interdum. Aenean nec dolor sed nunc dapibus malesuada vitae in massa. Nam semper mi risus, dictum vehicula nisi hendrerit ut. Ut posuere pulvinar ipsum in semper. Cras magna enim, hendrerit eget nisi ac, rutrum malesuada tortor. Pellentesque rutrum pretium mauris, sed tincidunt nunc dapibus non. Nunc semper neque felis, auctor fringilla justo faucibus ac. Aliquam imperdiet dapibus orci, ut bibendum libero iaculis id. Duis at mauris non felis scelerisque maximus. Ut nec nisl urna. Quisque ullamcorper arcu quis ante laoreet, vitae semper ex accumsan. Ut auctor id nisl vel rhoncus.

Nulla egestas massa in libero blandit, vel auctor mi feugiat. In non nulla vitae turpis sollicitudin consectetur a eget lacus. Mauris arcu ex, vestibulum in hendrerit id, blandit eu erat. Nullam nec commodo ex, vel hendrerit mi. Mauris vitae dolor ac purus dignissim varius. In vel faucibus erat, a commodo ante. Phasellus a nisi non arcu volutpat imperdiet vitae ac neque. Pellentesque convallis nunc et mi fermentum pharetra. Nullam tincidunt libero eu est finibus rhoncus. Proin eu lacus sed erat malesuada rhoncus vitae sed odio. Nullam tempus euismod elit, sit amet scelerisque ante tristique vel. In ac libero at diam pulvinar bibendum. Pellentesque gravida neque in ipsum sagittis bibendum.

Sed libero lectus, facilisis et volutpat in, congue vel ex. Morbi ac facilisis diam, eget pellentesque lectus. Vestibulum in ex in eros vulputate accumsan. Donec maximus velit tortor, at euismod purus commodo et. Curabitur vitae consequat lectus. Suspendisse vitae nunc elit. Quisque nec bibendum urna, maximus lobortis metus. Integer tincidunt pulvinar dui, sed euismod metus pulvinar vitae. Aenean lacus augue, consequat quis commodo sed, imperdiet nec risus. Aliquam imperdiet, nisi id aliquam pellentesque, libero magna consequat est, ac facilisis nunc enim id ipsum. Nunc ullamcorper interdum quam, sed facilisis mi porttitor non. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer maximus tortor dui, pulvinar pretium neque tempus quis. Nullam fringilla, urna eu commodo eleifend, nunc velit egestas felis, vel consequat purus leo vel orci. Sed fringilla pellentesque magna.

Nullam eget faucibus risus. Ut tellus tellus, scelerisque sit amet risus nec, mattis condimentum augue. Donec orci justo, aliquet a quam sed, pulvinar sagittis augue. Mauris venenatis dolor eu lacus mattis, vel accumsan velit laoreet. Nulla dapibus vulputate volutpat. Sed eget dictum elit. Morbi a volutpat justo. Suspendisse non diam lorem. Nulla hendrerit ut nisi sed mattis. Morbi vitae consequat velit, sit amet sollicitudin quam. Vestibulum dignissim eleifend mi, a tincidunt libero congue faucibus. Fusce semper posuere sapien, hendrerit molestie risus congue vitae. Ut eu auctor turpis. In hac habitasse platea dictumst. Etiam condimentum urna sit amet arcu venenatis, at commodo augue fermentum.',
        2,
        NULL
    ),
    (
        'Elden Ring',
        59.99,
        '2022-02-25',
        'images-jeux/Elden-Ring.webp',
        '',
        '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit turpis vitae ante maximus mollis id et dui. Phasellus convallis justo id ligula sagittis eleifend. Vestibulum vel finibus lectus. Nullam ac felis nibh. Aenean eu porta lorem. Fusce vestibulum lorem id porta accumsan. Curabitur sit amet ultrices mauris. Nunc tempus nibh facilisis dolor pretium, tempor pretium leo suscipit. Ut consectetur nunc nisi, quis ornare lorem fringilla ac. Sed fringilla risus sodales, eleifend lectus ac, interdum lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris et egestas purus, id egestas nisi.

Cras non mattis purus. Vivamus dignissim pulvinar orci, eu interdum quam hendrerit eget. Nunc elementum imperdiet volutpat. Phasellus enim nibh, lacinia sed orci eu, laoreet lacinia ligula. Morbi ullamcorper finibus magna eu interdum. Aenean nec dolor sed nunc dapibus malesuada vitae in massa. Nam semper mi risus, dictum vehicula nisi hendrerit ut. Ut posuere pulvinar ipsum in semper. Cras magna enim, hendrerit eget nisi ac, rutrum malesuada tortor. Pellentesque rutrum pretium mauris, sed tincidunt nunc dapibus non. Nunc semper neque felis, auctor fringilla justo faucibus ac. Aliquam imperdiet dapibus orci, ut bibendum libero iaculis id. Duis at mauris non felis scelerisque maximus. Ut nec nisl urna. Quisque ullamcorper arcu quis ante laoreet, vitae semper ex accumsan. Ut auctor id nisl vel rhoncus.

Nulla egestas massa in libero blandit, vel auctor mi feugiat. In non nulla vitae turpis sollicitudin consectetur a eget lacus. Mauris arcu ex, vestibulum in hendrerit id, blandit eu erat. Nullam nec commodo ex, vel hendrerit mi. Mauris vitae dolor ac purus dignissim varius. In vel faucibus erat, a commodo ante. Phasellus a nisi non arcu volutpat imperdiet vitae ac neque. Pellentesque convallis nunc et mi fermentum pharetra. Nullam tincidunt libero eu est finibus rhoncus. Proin eu lacus sed erat malesuada rhoncus vitae sed odio. Nullam tempus euismod elit, sit amet scelerisque ante tristique vel. In ac libero at diam pulvinar bibendum. Pellentesque gravida neque in ipsum sagittis bibendum.

Sed libero lectus, facilisis et volutpat in, congue vel ex. Morbi ac facilisis diam, eget pellentesque lectus. Vestibulum in ex in eros vulputate accumsan. Donec maximus velit tortor, at euismod purus commodo et. Curabitur vitae consequat lectus. Suspendisse vitae nunc elit. Quisque nec bibendum urna, maximus lobortis metus. Integer tincidunt pulvinar dui, sed euismod metus pulvinar vitae. Aenean lacus augue, consequat quis commodo sed, imperdiet nec risus. Aliquam imperdiet, nisi id aliquam pellentesque, libero magna consequat est, ac facilisis nunc enim id ipsum. Nunc ullamcorper interdum quam, sed facilisis mi porttitor non. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer maximus tortor dui, pulvinar pretium neque tempus quis. Nullam fringilla, urna eu commodo eleifend, nunc velit egestas felis, vel consequat purus leo vel orci. Sed fringilla pellentesque magna.

Nullam eget faucibus risus. Ut tellus tellus, scelerisque sit amet risus nec, mattis condimentum augue. Donec orci justo, aliquet a quam sed, pulvinar sagittis augue. Mauris venenatis dolor eu lacus mattis, vel accumsan velit laoreet. Nulla dapibus vulputate volutpat. Sed eget dictum elit. Morbi a volutpat justo. Suspendisse non diam lorem. Nulla hendrerit ut nisi sed mattis. Morbi vitae consequat velit, sit amet sollicitudin quam. Vestibulum dignissim eleifend mi, a tincidunt libero congue faucibus. Fusce semper posuere sapien, hendrerit molestie risus congue vitae. Ut eu auctor turpis. In hac habitasse platea dictumst. Etiam condimentum urna sit amet arcu venenatis, at commodo augue fermentum.',
        1,
        'trending'
    ),
    (
        'Vampire Survivors',
        4.99,
        '2022-10-20',
        'images-jeux/Vampire-Survivors.webp',
        '',
        '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit turpis vitae ante maximus mollis id et dui. Phasellus convallis justo id ligula sagittis eleifend. Vestibulum vel finibus lectus. Nullam ac felis nibh. Aenean eu porta lorem. Fusce vestibulum lorem id porta accumsan. Curabitur sit amet ultrices mauris. Nunc tempus nibh facilisis dolor pretium, tempor pretium leo suscipit. Ut consectetur nunc nisi, quis ornare lorem fringilla ac. Sed fringilla risus sodales, eleifend lectus ac, interdum lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris et egestas purus, id egestas nisi.

Cras non mattis purus. Vivamus dignissim pulvinar orci, eu interdum quam hendrerit eget. Nunc elementum imperdiet volutpat. Phasellus enim nibh, lacinia sed orci eu, laoreet lacinia ligula. Morbi ullamcorper finibus magna eu interdum. Aenean nec dolor sed nunc dapibus malesuada vitae in massa. Nam semper mi risus, dictum vehicula nisi hendrerit ut. Ut posuere pulvinar ipsum in semper. Cras magna enim, hendrerit eget nisi ac, rutrum malesuada tortor. Pellentesque rutrum pretium mauris, sed tincidunt nunc dapibus non. Nunc semper neque felis, auctor fringilla justo faucibus ac. Aliquam imperdiet dapibus orci, ut bibendum libero iaculis id. Duis at mauris non felis scelerisque maximus. Ut nec nisl urna. Quisque ullamcorper arcu quis ante laoreet, vitae semper ex accumsan. Ut auctor id nisl vel rhoncus.

Nulla egestas massa in libero blandit, vel auctor mi feugiat. In non nulla vitae turpis sollicitudin consectetur a eget lacus. Mauris arcu ex, vestibulum in hendrerit id, blandit eu erat. Nullam nec commodo ex, vel hendrerit mi. Mauris vitae dolor ac purus dignissim varius. In vel faucibus erat, a commodo ante. Phasellus a nisi non arcu volutpat imperdiet vitae ac neque. Pellentesque convallis nunc et mi fermentum pharetra. Nullam tincidunt libero eu est finibus rhoncus. Proin eu lacus sed erat malesuada rhoncus vitae sed odio. Nullam tempus euismod elit, sit amet scelerisque ante tristique vel. In ac libero at diam pulvinar bibendum. Pellentesque gravida neque in ipsum sagittis bibendum.

Sed libero lectus, facilisis et volutpat in, congue vel ex. Morbi ac facilisis diam, eget pellentesque lectus. Vestibulum in ex in eros vulputate accumsan. Donec maximus velit tortor, at euismod purus commodo et. Curabitur vitae consequat lectus. Suspendisse vitae nunc elit. Quisque nec bibendum urna, maximus lobortis metus. Integer tincidunt pulvinar dui, sed euismod metus pulvinar vitae. Aenean lacus augue, consequat quis commodo sed, imperdiet nec risus. Aliquam imperdiet, nisi id aliquam pellentesque, libero magna consequat est, ac facilisis nunc enim id ipsum. Nunc ullamcorper interdum quam, sed facilisis mi porttitor non. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer maximus tortor dui, pulvinar pretium neque tempus quis. Nullam fringilla, urna eu commodo eleifend, nunc velit egestas felis, vel consequat purus leo vel orci. Sed fringilla pellentesque magna.

Nullam eget faucibus risus. Ut tellus tellus, scelerisque sit amet risus nec, mattis condimentum augue. Donec orci justo, aliquet a quam sed, pulvinar sagittis augue. Mauris venenatis dolor eu lacus mattis, vel accumsan velit laoreet. Nulla dapibus vulputate volutpat. Sed eget dictum elit. Morbi a volutpat justo. Suspendisse non diam lorem. Nulla hendrerit ut nisi sed mattis. Morbi vitae consequat velit, sit amet sollicitudin quam. Vestibulum dignissim eleifend mi, a tincidunt libero congue faucibus. Fusce semper posuere sapien, hendrerit molestie risus congue vitae. Ut eu auctor turpis. In hac habitasse platea dictumst. Etiam condimentum urna sit amet arcu venenatis, at commodo augue fermentum.',
        17,
        NULL
    ),
    (
        'Mount & Blade II: Bannerlord',
        49.99,
        '2020-03-30',
        'images-jeux/Mount-and-Blade-II-Bannerlord.webp',
        '',
        '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit turpis vitae ante maximus mollis id et dui. Phasellus convallis justo id ligula sagittis eleifend. Vestibulum vel finibus lectus. Nullam ac felis nibh. Aenean eu porta lorem. Fusce vestibulum lorem id porta accumsan. Curabitur sit amet ultrices mauris. Nunc tempus nibh facilisis dolor pretium, tempor pretium leo suscipit. Ut consectetur nunc nisi, quis ornare lorem fringilla ac. Sed fringilla risus sodales, eleifend lectus ac, interdum lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris et egestas purus, id egestas nisi.

Cras non mattis purus. Vivamus dignissim pulvinar orci, eu interdum quam hendrerit eget. Nunc elementum imperdiet volutpat. Phasellus enim nibh, lacinia sed orci eu, laoreet lacinia ligula. Morbi ullamcorper finibus magna eu interdum. Aenean nec dolor sed nunc dapibus malesuada vitae in massa. Nam semper mi risus, dictum vehicula nisi hendrerit ut. Ut posuere pulvinar ipsum in semper. Cras magna enim, hendrerit eget nisi ac, rutrum malesuada tortor. Pellentesque rutrum pretium mauris, sed tincidunt nunc dapibus non. Nunc semper neque felis, auctor fringilla justo faucibus ac. Aliquam imperdiet dapibus orci, ut bibendum libero iaculis id. Duis at mauris non felis scelerisque maximus. Ut nec nisl urna. Quisque ullamcorper arcu quis ante laoreet, vitae semper ex accumsan. Ut auctor id nisl vel rhoncus.

Nulla egestas massa in libero blandit, vel auctor mi feugiat. In non nulla vitae turpis sollicitudin consectetur a eget lacus. Mauris arcu ex, vestibulum in hendrerit id, blandit eu erat. Nullam nec commodo ex, vel hendrerit mi. Mauris vitae dolor ac purus dignissim varius. In vel faucibus erat, a commodo ante. Phasellus a nisi non arcu volutpat imperdiet vitae ac neque. Pellentesque convallis nunc et mi fermentum pharetra. Nullam tincidunt libero eu est finibus rhoncus. Proin eu lacus sed erat malesuada rhoncus vitae sed odio. Nullam tempus euismod elit, sit amet scelerisque ante tristique vel. In ac libero at diam pulvinar bibendum. Pellentesque gravida neque in ipsum sagittis bibendum.

Sed libero lectus, facilisis et volutpat in, congue vel ex. Morbi ac facilisis diam, eget pellentesque lectus. Vestibulum in ex in eros vulputate accumsan. Donec maximus velit tortor, at euismod purus commodo et. Curabitur vitae consequat lectus. Suspendisse vitae nunc elit. Quisque nec bibendum urna, maximus lobortis metus. Integer tincidunt pulvinar dui, sed euismod metus pulvinar vitae. Aenean lacus augue, consequat quis commodo sed, imperdiet nec risus. Aliquam imperdiet, nisi id aliquam pellentesque, libero magna consequat est, ac facilisis nunc enim id ipsum. Nunc ullamcorper interdum quam, sed facilisis mi porttitor non. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer maximus tortor dui, pulvinar pretium neque tempus quis. Nullam fringilla, urna eu commodo eleifend, nunc velit egestas felis, vel consequat purus leo vel orci. Sed fringilla pellentesque magna.

Nullam eget faucibus risus. Ut tellus tellus, scelerisque sit amet risus nec, mattis condimentum augue. Donec orci justo, aliquet a quam sed, pulvinar sagittis augue. Mauris venenatis dolor eu lacus mattis, vel accumsan velit laoreet. Nulla dapibus vulputate volutpat. Sed eget dictum elit. Morbi a volutpat justo. Suspendisse non diam lorem. Nulla hendrerit ut nisi sed mattis. Morbi vitae consequat velit, sit amet sollicitudin quam. Vestibulum dignissim eleifend mi, a tincidunt libero congue faucibus. Fusce semper posuere sapien, hendrerit molestie risus congue vitae. Ut eu auctor turpis. In hac habitasse platea dictumst. Etiam condimentum urna sit amet arcu venenatis, at commodo augue fermentum.',
        4,
        NULL
    ),
    (
    'The Witness',
    19.99,
    '2016-01-26',
    'images-jeux/The-Witness.webp',
    '',
    'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit turpis vitae ante maximus mollis id et dui. Phasellus convallis justo id ligula sagittis eleifend. Vestibulum vel finibus lectus. Nullam ac felis nibh. Aenean eu porta lorem. Fusce vestibulum lorem id porta accumsan. Curabitur sit amet ultrices mauris. Nunc tempus nibh facilisis dolor pretium, tempor pretium leo suscipit. Ut consectetur nunc nisi, quis ornare lorem fringilla ac. Sed fringilla risus sodales, eleifend lectus ac, interdum lacus.',
    9,
    NULL
),
    (
        'God of War Ragnarök',
        69.99,
        '2022-11-09',
        'images-jeux/God-of-War-Ragnarok.webp',
        '',
        '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit turpis vitae ante maximus mollis id et dui. Phasellus convallis justo id ligula sagittis eleifend. Vestibulum vel finibus lectus. Nullam ac felis nibh. Aenean eu porta lorem. Fusce vestibulum lorem id porta accumsan. Curabitur sit amet ultrices mauris. Nunc tempus nibh facilisis dolor pretium, tempor pretium leo suscipit. Ut consectetur nunc nisi, quis ornare lorem fringilla ac. Sed fringilla risus sodales, eleifend lectus ac, interdum lacus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris et egestas purus, id egestas nisi.

Cras non mattis purus. Vivamus dignissim pulvinar orci, eu interdum quam hendrerit eget. Nunc elementum imperdiet volutpat. Phasellus enim nibh, lacinia sed orci eu, laoreet lacinia ligula. Morbi ullamcorper finibus magna eu interdum. Aenean nec dolor sed nunc dapibus malesuada vitae in massa. Nam semper mi risus, dictum vehicula nisi hendrerit ut. Ut posuere pulvinar ipsum in semper. Cras magna enim, hendrerit eget nisi ac, rutrum malesuada tortor. Pellentesque rutrum pretium mauris, sed tincidunt nunc dapibus non. Nunc semper neque felis, auctor fringilla justo faucibus ac. Aliquam imperdiet dapibus orci, ut bibendum libero iaculis id. Duis at mauris non felis scelerisque maximus. Ut nec nisl urna. Quisque ullamcorper arcu quis ante laoreet, vitae semper ex accumsan. Ut auctor id nisl vel rhoncus.

Nulla egestas massa in libero blandit, vel auctor mi feugiat. In non nulla vitae turpis sollicitudin consectetur a eget lacus. Mauris arcu ex, vestibulum in hendrerit id, blandit eu erat. Nullam nec commodo ex, vel hendrerit mi. Mauris vitae dolor ac purus dignissim varius. In vel faucibus erat, a commodo ante. Phasellus a nisi non arcu volutpat imperdiet vitae ac neque. Pellentesque convallis nunc et mi fermentum pharetra. Nullam tincidunt libero eu est finibus rhoncus. Proin eu lacus sed erat malesuada rhoncus vitae sed odio. Nullam tempus euismod elit, sit amet scelerisque ante tristique vel. In ac libero at diam pulvinar bibendum. Pellentesque gravida neque in ipsum sagittis bibendum.

Sed libero lectus, facilisis et volutpat in, congue vel ex. Morbi ac facilisis diam, eget pellentesque lectus. Vestibulum in ex in eros vulputate accumsan. Donec maximus velit tortor, at euismod purus commodo et. Curabitur vitae consequat lectus. Suspendisse vitae nunc elit. Quisque nec bibendum urna, maximus lobortis metus. Integer tincidunt pulvinar dui, sed euismod metus pulvinar vitae. Aenean lacus augue, consequat quis commodo sed, imperdiet nec risus. Aliquam imperdiet, nisi id aliquam pellentesque, libero magna consequat est, ac facilisis nunc enim id ipsum. Nunc ullamcorper interdum quam, sed facilisis mi porttitor non. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer maximus tortor dui, pulvinar pretium neque tempus quis. Nullam fringilla, urna eu commodo eleifend, nunc velit egestas felis, vel consequat purus leo vel orci. Sed fringilla pellentesque magna.

Nullam eget faucibus risus. Ut tellus tellus, scelerisque sit amet risus nec, mattis condimentum augue. Donec orci justo, aliquet a quam sed, pulvinar sagittis augue. Mauris venenatis dolor eu lacus mattis, vel accumsan velit laoreet. Nulla dapibus vulputate volutpat. Sed eget dictum elit. Morbi a volutpat justo. Suspendisse non diam lorem. Nulla hendrerit ut nisi sed mattis. Morbi vitae consequat velit, sit amet sollicitudin quam. Vestibulum dignissim eleifend mi, a tincidunt libero congue faucibus. Fusce semper posuere sapien, hendrerit molestie risus congue vitae. Ut eu auctor turpis. In hac habitasse platea dictumst. Etiam condimentum urna sit amet arcu venenatis, at commodo augue fermentum.',
        1,
        'trending'
    );

    -- DayZ : Fighting (16) → Survival (15)
UPDATE product SET id_category = 15 WHERE name = 'DayZ';

-- Subnautica : Fighting (16) → Survival (15)
UPDATE product SET id_category = 15 WHERE name = 'Subnautica';

-- The Forest : Fighting (16) → Survival (15)
UPDATE product SET id_category = 15 WHERE name = 'The Forest';

-- Valheim : Fighting (16) → Survival (15)
UPDATE product SET id_category = 15 WHERE name = 'Valheim';

-- Rust : Fighting (16) → Survival (15)
UPDATE product SET id_category = 15 WHERE name = 'Rust';

-- Ark: Survival Evolved : Fighting (16) → Survival (15)
UPDATE product SET id_category = 15 WHERE name = 'Ark: Survival Evolved';

-- Cuphead : MMO (11) → Plateforme (10)
UPDATE product SET id_category = 10 WHERE name = 'Cuphead';

-- Among Us : RPG (13) → Indie (12)
UPDATE product SET id_category = 12 WHERE name = 'Among Us';
ALTER TABLE pb_user ADD COLUMN profile_picture VARCHAR(255) DEFAULT 'default-avatar.png';

ALTER TABLE pb_order MODIFY status VARCHAR(50);