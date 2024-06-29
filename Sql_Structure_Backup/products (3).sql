-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 28, 2024 at 04:03 AM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `availability` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `price`, `discount`, `product_image`, `availability`) VALUES
(1, 'Paneer BBQ Roll [Jumbo]', 150.00, NULL, 'https://d3cm4d6rq8ed33.cloudfront.net/media/navpravartakfiles/19/afb464a2-7bb9-4496-9182-5caa31f2ba6f.png', 'available'),
(3, 'Paneer Cheese Roll [Jumbo] ', 170.00, NULL, 'https://www.foodandwine.com/thmb/k75Y-tKCSslUT4l6D33Wk-VtYQc=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/masala-paneer-kathi-rolls-FT-RECIPE0520-cef5c5389a384076bffa6fce7ff6280c.jpg', 'available'),
(4, 'Paneer Cheese Roll [Regular]', 140.00, NULL, 'https://www.foodandwine.com/thmb/k75Y-tKCSslUT4l6D33Wk-VtYQc=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/masala-paneer-kathi-rolls-FT-RECIPE0520-cef5c5389a384076bffa6fce7ff6280c.jpg', 'available'),
(9, 'Paneer Crispy Roll [Regular]', 100.00, NULL, 'https://c.ndtvimg.com/2021-11/jdjrh7a8_paneer-shawarma_625x300_12_November_21.jpg', 'available'),
(2, 'Paneer BBQ Roll [Regular]', 120.00, NULL, 'https://d3cm4d6rq8ed33.cloudfront.net/media/navpravartakfiles/19/afb464a2-7bb9-4496-9182-5caa31f2ba6f.png', 'available'),
(10, 'Paneer Crispy Roll [Jumbo]', 130.00, NULL, 'https://c.ndtvimg.com/2021-11/jdjrh7a8_paneer-shawarma_625x300_12_November_21.jpg', 'available'),
(11, 'Mashroom Crispy Roll [Regular]', 80.00, NULL, 'https://thetastyk.com/wp-content/uploads/2018/03/DSC08721Edit1-1024x683.jpg', 'available'),
(12, 'Mashroom Crispy Roll [Jumbo]', 110.00, NULL, 'https://thetastyk.com/wp-content/uploads/2018/03/DSC08721Edit1-1024x683.jpg', 'available'),
(13, 'Crispy Chicken Roll Korean Style [Jumbo]', 130.00, NULL, 'https://img.freepik.com/premium-photo/food-photography-shawarma-wooden-board-background_987686-19681.jpg\r\n', 'available'),
(14, 'Crispy Chicken Roll Korean Style [Regular]', 100.00, NULL, 'https://img.freepik.com/premium-photo/food-photography-shawarma-wooden-board-background_987686-19681.jpg\r\n\r\n\r\n', 'available'),
(15, 'KFC Fried Chicken Roll [Regular]', 120.00, NULL, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQOSCanzQGZy31oHZG2UUOqeP11frWByh_uNJLAZAl7fHaGrzNFOh95yAnIP1W98Eex4AE&usqp=CAU', 'available'),
(16, 'KFC Fried Chicken Roll [Jumbo]', 150.00, NULL, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQOSCanzQGZy31oHZG2UUOqeP11frWByh_uNJLAZAl7fHaGrzNFOh95yAnIP1W98Eex4AE&usqp=CAU', 'available'),
(17, 'Turkish Chicken Shwarma Roll [Jumbo]\r\n', 160.00, NULL, 'https://www.shutterstock.com/shutterstock/videos/1077119888/thumb/1.jpg?ip=x480\r\n', 'available'),
(18, 'Turkish Chicken Shwarma Roll [Regular]\r\n', 130.00, NULL, 'https://www.shutterstock.com/shutterstock/videos/1077119888/thumb/1.jpg?ip=x480\r\n', 'available'),
(19, 'Arabian Malai Chicken Roll [Regular]\r\n', 140.00, NULL, 'https://img.freepik.com/premium-photo/chicken-shawarma-wooden-table-with-full-meat-chicken_661323-18.jpg', 'available'),
(20, 'Arabian Malai Chicken Roll [Jumbo]\r\n', 170.00, NULL, 'https://img.freepik.com/premium-photo/chicken-shawarma-wooden-table-with-full-meat-chicken_661323-18.jpg', 'available'),
(21, 'BBQ Chicken Roll [Jumbo]\r\n', 170.00, NULL, 'https://img.freepik.com/premium-photo/lebanese-chicken-shawarma-served-dish-side-view-wooden-table-background_689047-1889.jpg', 'available'),
(22, 'BBQ Chicken Roll [Regular]\r\n', 140.00, NULL, 'https://img.freepik.com/premium-photo/lebanese-chicken-shawarma-served-dish-side-view-wooden-table-background_689047-1889.jpg', 'available'),
(23, 'KUN Special Chicken\r\n', 200.00, NULL, 'https://png.pngtree.com/thumb_back/fw800/background/20231106/pngtree-delectable-shawarma-kebab-infused-with-sausage-on-a-textured-black-stone-image_13812946.png', 'available'),
(24, 'Prawn Crispy Roll [Regular]\r\n', 150.00, NULL, 'https://img.freepik.com/premium-photo/side-view-shawarma-chicken-roll-black-background_533566-681.jpg', 'available'),
(25, 'Prawn Crispy Roll [Jumbo]\r\n', 190.00, NULL, 'https://img.freepik.com/premium-photo/side-view-shawarma-chicken-roll-black-background_533566-681.jpg', 'available'),
(26, 'KFC Zinger Burger\r\n', 120.00, NULL, 'https://orderserv-kfc-assets.yum.com/15895bb59f7b4bb588ee933f8cd5344a/images/items/xs/D-K439.jpg', 'available'),
(27, 'Chicken Cheese Burger\r\n', 150.00, NULL, 'https://5.imimg.com/data5/AA/GN/GLADMIN-46611207/big-crunch-chicken-cheese-burger.png', 'available'),
(28, 'Paneer Burger\r\n', 100.00, NULL, 'https://www.sawadindiaka.in/wp-content/uploads/2021/05/7132f972-c0ac-400a-afa3-6e811c93bd48-1.jpg', 'available'),
(29, 'BBQ Glill Chicken [3Pcs+50ml Dip]\r\n', 130.00, NULL, 'https://m.media-amazon.com/images/I/716pGTDhahL.jpg\r\n', 'available'),
(30, 'BBQ Glill Chicken [6Pcs+50ml Dip]\r\n', 200.00, NULL, 'https://m.media-amazon.com/images/I/716pGTDhahL.jpg\r\n', 'available'),
(31, 'BBQ Glill Chicken [9Pcs+100ml Dip]\r\n', 350.00, NULL, 'https://m.media-amazon.com/images/I/716pGTDhahL.jpg\r\n', 'available'),
(35, 'Extra Mayonnaise Dip 50 ML', 20.00, NULL, 'https://assets.unileversolutions.com/recipes-v2/96017.jpg', 'available'),
(34, 'Blue Lime Mojito', 30.00, NULL, 'https://monin.in/cdn/shop/products/Blue_20Curacao_20Mojito.png?v=1681306667', 'available'),
(36, 'Extra Mayonnaise Dip 100 ML', 30.00, NULL, 'https://assets.unileversolutions.com/recipes-v2/96017.jpg', 'available');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
