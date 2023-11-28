CREATE DATABASE  `OOOOO`;
USE `OOOOO`;


CREATE TABLE `category` (
  `IDcategory` int(11) NOT NULL,
  `NAMEcategory` varchar(255) DEFAULT NULL
) ;


INSERT INTO `category` (`IDcategory`, `NAMEcategory`) VALUES
(1, 'LES HERBACÉES'),
(2, 'FLOWERS'),
(3, 'VASCULAR PLANTS');



CREATE TABLE `command` (
  `IDcommand` int(11) NOT NULL,
  `IDuser` int(11) DEFAULT NULL,
  `IDproduct` int(11) DEFAULT NULL,
  `address_user` varchar(255) DEFAULT NULL,
  `phone_user` varchar(20) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) 



CREATE TABLE `panier` (
  `IDpanier` int(11) NOT NULL,
  `IDuser` int(11) DEFAULT NULL,
  `IDproduct` int(11) DEFAULT NULL
);



CREATE TABLE `products` (
  `IDproduct` int(11) NOT NULL,
  `NAMEproduct` varchar(255) DEFAULT NULL,
  `IDCATEGORY` int(11) DEFAULT NULL,
  `price_product` decimal(10,2) NOT NULL,
  `quantity_product` int(11) DEFAULT 1,
  `image_product` varchar(255) DEFAULT NULL
);


INSERT INTO `products` (`IDproduct`, `NAMEproduct`, `IDCATEGORY`, `price_product`, `quantity_product`, `image_product`) VALUES
(8, 'Pissenlit', 1, 7.00, 5, 'Pissenlit.png'),
(9, 'Menthe', 1, 5.00, 10, 'Menthe.jpg'),
(10, 'Ortie', 1, 3.00, 5, 'Ortie.jpeg'),
(11, 'Souci', 1, 12.00, 10, 'Souci.jpg'),
(12, 'Roses', 2, 7.00, 20, 'Roses.jfif'),
(13, 'Tulipes', 2, 12.00, 6, 'Tulipes.jpg'),
(14, 'Marguerites', 2, 10.00, 5, 'Marguerites.jfif'),
(15, 'Lys', 2, 21.00, 4, 'Lys.jfif'),
(16, 'Chêne (Quercus)', 3, 54.00, 3, 'Chêne-_Quercus_.jpeg'),
(17, 'Fougère (Filicophyta)', 3, 66.00, 2, 'Fougère (Filicophyta).jpeg'),
(18, 'Roseau commun (Phragmites australis) ', 3, 45.00, 6, 'Roseau commun (Phragmites australis).jfif'),
(19, 'Pissenlit (Taraxacum officinale) ', 3, 12.00, 7, 'Pissenlit (Taraxacum officinale).png');


CREATE TABLE `roles` (
  `IDrole` int(11) NOT NULL,
  `NAMErole` varchar(10) DEFAULT NULL
);

INSERT INTO `roles` (`IDrole`, `NAMErole`) VALUES
(1, 'ADMIN'),
(2, 'CLIENT');


CREATE TABLE `users` (
  `IDuser` int(11) NOT NULL,
  `NAMEuser` varchar(50) DEFAULT NULL,
  `LASTNAMEuser` varchar(50) DEFAULT NULL,
  `EMAILuser` varchar(80) DEFAULT NULL,
  `PASSWORDuser` varchar(100) DEFAULT NULL,
  `IDROLE` int(11) DEFAULT NULL
);

