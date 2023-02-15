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
        `img` TEXT,
        FOREIGN KEY (`idAuteur`) REFERENCES `user` (`id`)
    );

CREATE TABLE
    `cart` (
        `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
        `idUser` INTEGER,
        `idArticle` INTEGER,
        FOREIGN KEY (`idUser`) REFERENCES `user` (`id`),
        FOREIGN KEY (`idArticle`) REFERENCES `article` (`id`)
    );

CREATE TABLE
    `invoice` (
        `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
        `idUser` INTEGER,
        `dateTransaction` TEXT,
        `price` FLOAT,
        `addInvoice` TEXT,
        `villeInvoice` TEXT,
        `postaleInvoice` INTEGER,
        FOREIGN KEY (`idUser`) REFERENCES `user` (`id`)
    );

CREATE TABLE
    `stock` (
        `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
        `idArticle` INTEGER,
        `stock` INTEGER,
        FOREIGN KEY (`idArticle`) REFERENCES `article` (`id`)
    );