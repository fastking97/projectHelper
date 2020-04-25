-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 02, 2018 at 11:28 AM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `E-Commerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `Admins`
--

CREATE TABLE `Admins` (
  `id` int(11) NOT NULL,
  `username` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Admins`
--

INSERT INTO `Admins` (`id`, `username`, `password`) VALUES
(1, 'admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918');

-- --------------------------------------------------------

--
-- Table structure for table `Cart`
--

CREATE TABLE `Cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Checkout`
--

CREATE TABLE `Checkout` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `checkoutDate` date NOT NULL,
  `transfer_receipt` varchar(250) NOT NULL,
  `status` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Checkout`
--

INSERT INTO `Checkout` (`id`, `user_id`, `product_id`, `quantity`, `checkoutDate`, `transfer_receipt`, `status`) VALUES
(1, 4, 104, 1, '2018-11-02', ' 0', 'hold');

-- --------------------------------------------------------

--
-- Table structure for table `Comments`
--

CREATE TABLE `Comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` varchar(350) NOT NULL,
  `display_name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Comments`
--

INSERT INTO `Comments` (`id`, `user_id`, `product_id`, `rating`, `comment`, `display_name`) VALUES
(1, 1, 101, 4, 'high quality product! very reccommended!', 'Test System'),
(13, 4, 101, 3, 'So So', 'Demo Account'),
(14, 5, 104, 5, 'Best Product!!! Legit and fast delivery!', 'Tom Haiden');

-- --------------------------------------------------------

--
-- Table structure for table `ContactUs`
--

CREATE TABLE `ContactUs` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(150) NOT NULL,
  `message` varchar(500) NOT NULL,
  `status` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ContactUs`
--

INSERT INTO `ContactUs` (`id`, `name`, `email`, `subject`, `message`, `status`) VALUES
(1, 'Test', 'test@test.com', 'test', 'this is a long message.', 'unread'),
(2, 'Test2', 'test2@test.com', 'test2', 'this is another long message.', 'unread'),
(3, 'Test3', 'test3@test.com', 'test3', 'another test and another long message.', 'unread'),
(4, 'Test4', 'test4@test.com', 'test4', 'this is another test and another long message again.', 'unread'),
(5, 'This Is Test', 'thisistest@test.com', 'this is test', 'this test should work perfectly.', 'unread'),
(6, 'Test', 'test@again.com', 'testing the page', 'this is a long story,', 'unread');

-- --------------------------------------------------------

--
-- Table structure for table `Inbox`
--

CREATE TABLE `Inbox` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `subject` varchar(150) NOT NULL,
  `message` varchar(500) NOT NULL,
  `seller_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Inbox`
--

INSERT INTO `Inbox` (`id`, `name`, `subject`, `message`, `seller_id`) VALUES
(1, 'Admin', 'Temporary Ban', 'Dear user, \r\nWith great regret that we have to temporary ban your account due to reason(s) below:\r\n\r\nNo Stock\r\n\r\nYour account will be banned within unspecified time. Please be patient until your account is being recovered by our team.\r\n\r\nBest regards,\r\nAdmin.\r\n\r\n*This email has been generated automatically, please do not reply.', 2);

-- --------------------------------------------------------

--
-- Table structure for table `PasswordReset1`
--

CREATE TABLE `PasswordReset1` (
  `ID` int(11) UNSIGNED NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `token` char(64) DEFAULT NULL,
  `expires` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `PasswordReset1`
--

INSERT INTO `PasswordReset1` (`ID`, `email`, `token`, `expires`) VALUES
(1, 'test@again.com', 'f6a2045133838f7ec8b8f5fe3086b76e6748b4a58d62156ec777b5f4f9d97d20', 1539064474),
(2, 'haduh@bosan.com', '', 0),
(3, 'aldofelim@gmail.com', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `PasswordReset2`
--

CREATE TABLE `PasswordReset2` (
  `ID` int(11) UNSIGNED NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `token` char(64) DEFAULT NULL,
  `expires` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `PasswordReset2`
--

INSERT INTO `PasswordReset2` (`ID`, `email`, `token`, `expires`) VALUES
(1, 'dummz17@gmail.com', '', 0),
(2, 'aldofelim@gmail.com', '841c1c47d09f423baf4471e8d10c5d56b263ff19d8c5b09d49091181f09aee97', 1539039716),
(3, 'aldo_felim@hotmail.com', NULL, NULL),
(4, 'lala@lili.com', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ProductImages`
--

CREATE TABLE `ProductImages` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `source` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ProductImages`
--

INSERT INTO `ProductImages` (`id`, `product_id`, `source`) VALUES
(2, 101, '../productImage/MOUAPPLMLA02ZA_T1-1000x1000.jpg'),
(3, 101, '../productImage/mouse.jpg'),
(4, 102, '../productImage/grains.jpg'),
(7, 103, '../productImage/dell-laptop-500x500.jpg'),
(8, 104, '../productImage/download (1).jpeg'),
(9, 105, '../productImage/leatherJacket.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `Products`
--

CREATE TABLE `Products` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `description` varchar(500) NOT NULL,
  `category` varchar(200) NOT NULL,
  `subCategory` varchar(300) NOT NULL,
  `price` decimal(6,2) NOT NULL,
  `sale_price` decimal(6,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `sent_in` int(5) NOT NULL,
  `product_condition` varchar(200) NOT NULL,
  `post_date` date NOT NULL,
  `seller_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Products`
--

INSERT INTO `Products` (`id`, `name`, `description`, `category`, `subCategory`, `price`, `sale_price`, `stock`, `sent_in`, `product_condition`, `post_date`, `seller_id`) VALUES
(101, 'Apple Wireless Magic Mouse 2 MLA02LL/A - Silver, 2 Pack (Certified Refurbished)', '- This Certified Refurbished product is tested and certified by the manufacturer or by a third-party refurbisher to look & work like new, with limited to no signs of wear. The refurbishing process includes functionality testing, inspection, reconditioning and repackaging. The product ships with all relevant accessories, a minimum 90-day warranty & may arrive in a generic white or brown box.Only select sellers who maintain a high performance bar may offer Certified Refurbished products on Amazon.', 'Electronic Accessories', 'Computer Accessories', '320.00', '280.00', 3, 5, 'refurbished', '2018-10-10', 2),
(102, 'Happy Grains (48 X 25g) Free BPA Container (While Stock Last)', '-Provide a feeling of fullness with fewer calories.\r\n- Supplement with minerals (calcium, magnesium, potassium, zinc and chromium).\r\n- Strengthen spleen and respiratory function. Reduce water retention.\r\n- Promote bone health.\r\n- Prevent constipation because of its dietary fiber.\r\n- Inhibiting lipids cell formation, prevent obesity.\r\n- Using Stevia leaf as natural sweetener is suitable to people with diabetes', 'Groceries & Pets', 'Cereal & Confectionery', '110.00', '99.00', 4, 2, 'new', '2018-10-10', 4),
(103, 'Dell Inspiron 3467-20412G-W10 14\" Notebook Black [i5-7200U, 4GB, 1TB, AMD R5 M430, W10][FS0B]', '-Dell 3467-20412G-W10H 14\" Notebook\r\n-Intel® Core™ I5-7200-2.5GHz\r\n-4GB DDR4 RAM, 1TB SATA HDD\r\n-ATI R5 M430\r\n-Windows 10 Home\r\n-1 Year onsite warranty by Dell\r\n-Free Dell Carry Case', 'Electronic Devices', 'Laptops', '2199.00', '1999.00', 7, 5, 'new', '2018-10-10', 2),
(104, 'WIndows 10 Pro Computer Software New (Super Afforable)', '- The new Windows 10 Pro ready to use\r\n- Suitable for your new PC\r\n- Guaranteed updated version', 'Electronic Accessories', 'Computer Components', '330.00', '315.00', 2, 3, 'new', '2018-10-10', 2),
(105, '2018 Men Spring Leather Jacket Fashion Design Men PU Leahter Jackets Streetwear Mens Bomber Jacket High ', '-leather jacket\r\n-gender : men\r\n-m-5xl\r\n-black army green dark blue earth yellow coffee\r\n-spring autumn\r\n-pu leather', 'Men Fashion', 'Jackets & Coats', '310.00', '105.00', 0, 7, 'new', '2018-10-10', 2);

-- --------------------------------------------------------

--
-- Table structure for table `Review`
--

CREATE TABLE `Review` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `star1` int(11) NOT NULL,
  `star2` int(11) NOT NULL,
  `star3` int(11) NOT NULL,
  `star4` int(11) NOT NULL,
  `star5` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Review`
--

INSERT INTO `Review` (`id`, `product_id`, `star1`, `star2`, `star3`, `star4`, `star5`) VALUES
(1, 101, 1, 0, 5, 2, 5),
(4, 104, 0, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `SellerOrder`
--

CREATE TABLE `SellerOrder` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `checkoutDate` date NOT NULL,
  `trackingCarrier` varchar(300) NOT NULL,
  `trackingNumber` varchar(500) NOT NULL,
  `status` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `SellerOrder`
--

INSERT INTO `SellerOrder` (`id`, `user_id`, `product_id`, `seller_id`, `quantity`, `checkoutDate`, `trackingCarrier`, `trackingNumber`, `status`) VALUES
(1, 4, 104, 2, 1, '2018-11-02', '', '', 'hold');

-- --------------------------------------------------------

--
-- Table structure for table `Sellers`
--

CREATE TABLE `Sellers` (
  `id` int(11) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `studentID` varchar(50) NOT NULL,
  `IDNum` int(30) NOT NULL,
  `contact` varchar(300) NOT NULL,
  `bankName` varchar(250) NOT NULL,
  `accountNumber` varchar(200) NOT NULL,
  `recipient` varchar(250) NOT NULL,
  `store` varchar(350) NOT NULL,
  `sellerStatus` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Sellers`
--

INSERT INTO `Sellers` (`id`, `fname`, `lname`, `gender`, `email`, `password`, `dob`, `studentID`, `IDNum`, `contact`, `bankName`, `accountNumber`, `recipient`, `store`, `sellerStatus`) VALUES
(2, 'Dummy', 'Account', 'male', 'dummz17@gmail.com', 'e5abb4eed9c45dc6500b11225413993dfb7073822ba952d589bb78be277af3dd', '2018-10-01', 'uploads/AR_Logo.png', 1234567, '+60172536683', 'Public Bank Berhad', '6360261102', 'Dummy Account', 'dummz', 'approved'),
(3, 'Test', 'Test', 'male', 'test@gmail.com', '937e8d5fbb48bd4949536cd65b8d35c426b80d2f830c5c308e2cdec422ae2244', '2018-10-01', 'uploads/test.jpg', 1233448, '+60182319008', 'Maybank', '123123123', 'Test', 'test', 'approved'),
(4, 'Juan', 'Naldo Felim', 'male', 'aldofelim@gmail.com', '47446fa0e0f5726f5f18fd7b837d3621b57ea696df27732d4adeaa11e229736c', '1997-08-04', 'uploads/banner.png', 0, '+6016223899', 'Maybank', '1231232131', 'Juan Naldo', 'itsCool', 'approved'),
(5, 'Lala', 'Lili', 'female', 'lala@lili.com', 'd899669c6a6a412cb0e473a2eadabaa2d5eec8964d5c66ca553ef3d6c3f46ec6', '1993-02-09', 'uploads/logo-preview.jpg', 0, '+60172345678', 'Public Bank Berhad', '123456779', 'Lala Lili', 'Lala Shopp', 'hold');

-- --------------------------------------------------------

--
-- Table structure for table `UserComplaint`
--

CREATE TABLE `UserComplaint` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(150) NOT NULL,
  `message` varchar(500) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `status` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `UserComplaint`
--

INSERT INTO `UserComplaint` (`id`, `name`, `email`, `subject`, `message`, `seller_id`, `status`) VALUES
(1, 'Test', 'test@email.com', 'no stock', 'seller didn\'t restock the store', 2, 'unread');

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `id` int(11) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(350) NOT NULL,
  `dob` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`id`, `fname`, `lname`, `gender`, `email`, `password`, `address`, `dob`) VALUES
(1, 'Test', 'System', 'male', 'test@system.com', '937e8d5fbb48bd4949536cd65b8d35c426b80d2f830c5c308e2cdec422ae2244', 'address1', '2018-09-18'),
(2, 'First', 'Upper Case', 'male', 'upper@case.com', 'ec9b27c22167a22c1aead626ae3112d98c3cbf872a44f852ef57fd3e3092d53b', 'address2', '2018-09-02'),
(3, 'Seller', 'Test', 'male', 'seller@test.com', '2a76110d06bcc4fd437337b984131cfa82db9f792e3e2340acef9f3066b264e0', 'address3', '2018-09-03'),
(4, 'Demo', 'Account', 'male', 'demo@account.com', '4f8f6d25500302761ef4c7063c5fb017cc9856bdb8391ffd59d9e99b78012c31', '2, Jalan SS 15/8, Ss 15, 47500 Subang Jaya, Selangor, Malaysia ', '2018-09-01'),
(5, 'Tom', 'Haiden', 'male', 'tomhaiden@gmail.com', 'b5fbc67cf551228e6c4dabb9117c1517f438aedabb5c6436532744a720810aa8', 'ss15, subang jaya, 47500', '2018-10-07'),
(6, 'Test', 'Test', 'male', 'test@again.com', 'f4c2178860817a2c25d2cb3185aa25779b0ecaf17c30845926218e17a18a9f89', 'test street', '2018-10-01'),
(7, 'Haduh', 'Bosan', 'male', 'haduh@bosan.com', 'b8e4619bfcf4961777d2d1c0ddc9e568d67b5b3f33b1571c10e08f314bd9edd4', 'haduh', '2018-10-01'),
(8, 'Aldo', 'Felim', 'male', 'aldofelim@gmail.com', '47446fa0e0f5726f5f18fd7b837d3621b57ea696df27732d4adeaa11e229736c', 'aldo street', '2018-10-01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Admins`
--
ALTER TABLE `Admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Cart`
--
ALTER TABLE `Cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Checkout`
--
ALTER TABLE `Checkout`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Comments`
--
ALTER TABLE `Comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ContactUs`
--
ALTER TABLE `ContactUs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Inbox`
--
ALTER TABLE `Inbox`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `PasswordReset1`
--
ALTER TABLE `PasswordReset1`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `PasswordReset2`
--
ALTER TABLE `PasswordReset2`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `ProductImages`
--
ALTER TABLE `ProductImages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Products`
--
ALTER TABLE `Products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Review`
--
ALTER TABLE `Review`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `SellerOrder`
--
ALTER TABLE `SellerOrder`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Sellers`
--
ALTER TABLE `Sellers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `UserComplaint`
--
ALTER TABLE `UserComplaint`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Admins`
--
ALTER TABLE `Admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Cart`
--
ALTER TABLE `Cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Checkout`
--
ALTER TABLE `Checkout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Comments`
--
ALTER TABLE `Comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `ContactUs`
--
ALTER TABLE `ContactUs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `Inbox`
--
ALTER TABLE `Inbox`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `PasswordReset1`
--
ALTER TABLE `PasswordReset1`
  MODIFY `ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `PasswordReset2`
--
ALTER TABLE `PasswordReset2`
  MODIFY `ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ProductImages`
--
ALTER TABLE `ProductImages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `Products`
--
ALTER TABLE `Products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `Review`
--
ALTER TABLE `Review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `SellerOrder`
--
ALTER TABLE `SellerOrder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Sellers`
--
ALTER TABLE `Sellers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `UserComplaint`
--
ALTER TABLE `UserComplaint`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
