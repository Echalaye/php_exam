CREATE TABLE
    `user` (
        `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
        `username` TEXT,
        `mdp` TEXT,
        `adresseMail` TEXT,
        `solde` INTEGER,
        `pdp` TEXT,
        `role` TEXT
    );

CREATE TABLE
    `article` (
        `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
        `name` TEXT,
        `description` TEXT,
        `prix` FLOAT,
        `datePublie` TEXT,
        `idAuteur` INTEGER,
        `img` TEXT
    );

CREATE TABLE
    `cart` (
        `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
        `idUser` INTEGER,
        `idArticle` INTEGER
    );

CREATE TABLE
    `invoice` (
        `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
        `idUser` INTEGER,
        `dateTransaction` TEXT,
        `price` FLOAT,
        `addInvoice` TEXT,
        `villeInvoice` TEXT,
        `postaleInvoice` INTEGER
    );

CREATE TABLE
    `stock` (
        `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
        `idArticle` INTEGER,
        `stock` INTEGER
    );

ALTER TABLE `article`
ADD
    FOREIGN KEY (`idAuteur`) REFERENCES `user` (`id`);

ALTER TABLE `cart`
ADD
    FOREIGN KEY (`idUser`) REFERENCES `user` (`id`);

ALTER TABLE `cart`
ADD
    FOREIGN KEY (`idArticle`) REFERENCES `article` (`id`);

ALTER TABLE `invoice`
ADD
    FOREIGN KEY (`idUser`) REFERENCES `user` (`id`);

ALTER TABLE `stock`
ADD
    FOREIGN KEY (`idArticle`) REFERENCES `article` (`id`);