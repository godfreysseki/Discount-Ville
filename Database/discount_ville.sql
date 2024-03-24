-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 30, 2023 at 09:02 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS = @@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION = @@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `discount_ville`
--

-- --------------------------------------------------------

--
-- Table structure for table `audittrail`
--

CREATE TABLE `audittrail`
(
    `log_id`        int(11)      NOT NULL,
    `user_id`       int(11)                    DEFAULT NULL,
    `timestamp`     timestamp    NOT NULL      DEFAULT current_timestamp(),
    `activity_type` int(11)                    DEFAULT NULL COMMENT '1 = Add Record, 2 = Update, 3 = Delete',
    `entity_id`     int(11)                    DEFAULT NULL,
    `activity`      varchar(255) NOT NULL,
    `details`       text                       DEFAULT NULL,
    `old_value`     text                       DEFAULT NULL,
    `new_value`     text                       DEFAULT NULL,
    `module`        varchar(100)               DEFAULT NULL,
    `user_agent`    varchar(255)               DEFAULT NULL,
    `status`        enum ('success','failure') DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners`
(
    `banner_id`    int(11) NOT NULL,
    `product_id`   int(11) NOT NULL,
    `banner_image` varchar(255) DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart`
(
    `cart_id`    int(16)     NOT NULL,
    `user`       varchar(30) NOT NULL,
    `product_id` int(16)     NOT NULL,
    `quantity`   float       NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories`
(
    `category_id`        int(11)      NOT NULL,
    `banner`             varchar(255) DEFAULT NULL,
    `category_name`      varchar(255) NOT NULL,
    `parent_category_id` int(16)      DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages`
(
    `message_id`      int(16)           NOT NULL,
    `sender_id`       int(11)           NOT NULL,
    `receiver_id`     int(11)           NOT NULL,
    `message_content` text              NOT NULL,
    `seen`            enum ('No','Yes') NOT NULL,
    `timestamp`       timestamp         NOT NULL DEFAULT current_timestamp()
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities`
(
    `country` char(2)     NOT NULL,
    `code`    char(8)     NOT NULL DEFAULT '',
    `name`    varchar(50) NOT NULL DEFAULT ''
) ENGINE = MyISAM
  DEFAULT CHARSET = utf8;

-- --------------------------------------------------------

--
-- Table structure for table `companylogos`
--

CREATE TABLE `companylogos`
(
    `logos_id`      int(16)                    NOT NULL,
    `company`       varchar(255)               NOT NULL,
    `logo_link`     varchar(255)               NOT NULL,
    `external_link` varchar(255)                        DEFAULT NULL,
    `end_date`      timestamp                  NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    `status`        enum ('Active','Inactive') NOT NULL,
    `created_at`    timestamp                  NOT NULL DEFAULT current_timestamp()
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `compare`
--

CREATE TABLE `compare`
(
    `compare_id` int(16)     NOT NULL,
    `user`       varchar(80) NOT NULL,
    `product_id` int(16)     NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries`
(
    `id`      int(11)     NOT NULL,
    `alpha_2` char(2)     NOT NULL DEFAULT '',
    `alpha_3` char(3)     NOT NULL DEFAULT '',
    `name`    varchar(75) NOT NULL DEFAULT ''
) ENGINE = MyISAM
  DEFAULT CHARSET = utf8;

-- --------------------------------------------------------

--
-- Table structure for table `deals`
--

CREATE TABLE `deals`
(
    `deal_id`    int(16)   NOT NULL,
    `product_id` int(16)   NOT NULL,
    `discount`   float     NOT NULL,
    `start_date` timestamp NOT NULL DEFAULT current_timestamp(),
    `end_date`   timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

CREATE TABLE `discounts`
(
    `discount_id` int(16)   NOT NULL,
    `coupon`      text      NOT NULL,
    `discount`    float     NOT NULL,
    `start_date`  timestamp NOT NULL DEFAULT current_timestamp(),
    `end_date`    timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `newsletters`
--

CREATE TABLE `newsletters`
(
    `newsletter_id` int(16)   NOT NULL,
    `newsletter`    longtext  NOT NULL,
    `recipients`    float     NOT NULL,
    `created_at`    timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `newsletter_subscribers`
--

CREATE TABLE `newsletter_subscribers`
(
    `newsletter_subscriber_id` int(16)                    NOT NULL,
    `email`                    varchar(255)               NOT NULL,
    `status`                   enum ('Active','Inactive') NOT NULL,
    `created_at`               timestamp                  NOT NULL DEFAULT current_timestamp()
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications`
(
    `notification_id` int(11)    NOT NULL,
    `user_id`         int(11)             DEFAULT NULL,
    `message`         text       NOT NULL,
    `is_read`         tinyint(1) NOT NULL DEFAULT 0,
    `created_at`      timestamp  NOT NULL DEFAULT current_timestamp()
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products`
(
    `product_id`             int(11)        NOT NULL,
    `vendor_id`              int(11)        NOT NULL,
    `category_id`            int(16)        NOT NULL,
    `brand`                  varchar(80)             DEFAULT NULL,
    `model`                  varchar(255)            DEFAULT NULL,
    `manufacturer`           varchar(255)            DEFAULT NULL,
    `product_name`           varchar(255)   NOT NULL,
    `short_description`      text           NOT NULL,
    `product_description`    text                    DEFAULT NULL,
    `additional_information` text                    DEFAULT NULL,
    `quantity_in_stock`      float          NOT NULL,
    `reorder_level`          float          NOT NULL,
    `original_price`         decimal(10, 2) NOT NULL,
    `current_price`          decimal(10, 2) NOT NULL,
    `color`                  varchar(50)             DEFAULT NULL,
    `weight`                 decimal(10, 2)          DEFAULT NULL,
    `measurements`           varchar(100)            DEFAULT NULL,
    `product_image`          varchar(255)            DEFAULT NULL,
    `average_stars`          float          NOT NULL,
    `total_reviews`          float          NOT NULL,
    `total_views`            float          NOT NULL,
    `created_at`             timestamp      NOT NULL DEFAULT current_timestamp()
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `product_views`
--

CREATE TABLE `product_views`
(
    `view_id`    int(16)     NOT NULL,
    `product_id` int(16)     NOT NULL,
    `ip_address` varchar(80) NOT NULL,
    `created_at` timestamp   NOT NULL DEFAULT current_timestamp()
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews`
(
    `review_id`  int(16)   NOT NULL,
    `product_id` int(16)   NOT NULL,
    `stars`      float     NOT NULL,
    `review`     text      NOT NULL,
    `user_id`    int(16)   NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `salesdiscounts`
--

CREATE TABLE `salesdiscounts`
(
    `discount_id`     int(11)        NOT NULL,
    `product_id`      int(11) DEFAULT NULL,
    `discount_amount` decimal(10, 2) NOT NULL,
    `start_date`      date    DEFAULT NULL,
    `end_date`        date    DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `salesorderitems`
--

CREATE TABLE `salesorderitems`
(
    `item_id`      int(11)        NOT NULL,
    `order_id`     int(11) DEFAULT NULL,
    `product_id`   int(11) DEFAULT NULL,
    `quantity`     int(11)        NOT NULL,
    `unit_price`   decimal(10, 2) NOT NULL,
    `total_amount` decimal(10, 2) NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `salesorders`
--

CREATE TABLE `salesorders`
(
    `order_id`       int(11)                                               NOT NULL,
    `user_id`        int(16)                                               NOT NULL,
    `order_date`     timestamp                                             NOT NULL DEFAULT current_timestamp(),
    `customer_name`  varchar(255)                                                   DEFAULT NULL,
    `customer_email` varchar(255)                                                   DEFAULT NULL,
    `customer_phone` varchar(30)                                           NOT NULL,
    `total_amount`   decimal(10, 2)                                        NOT NULL,
    `status`         enum ('processing','invoiced','completed','canceled') NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `salesorderstatus`
--

CREATE TABLE `salesorderstatus`
(
    `status_id`   int(11)      NOT NULL,
    `status_name` varchar(100) NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `salespayments`
--

CREATE TABLE `salespayments`
(
    `payment_id`     int(11)        NOT NULL,
    `order_id`       int(11)                 DEFAULT NULL,
    `payment_date`   timestamp      NOT NULL DEFAULT current_timestamp(),
    `amount`         decimal(10, 2) NOT NULL,
    `payment_method` varchar(100)            DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `stockalerts`
--

CREATE TABLE `stockalerts`
(
    `alert_id`       int(11)           NOT NULL,
    `product_id`     int(11)                    DEFAULT NULL,
    `alert_quantity` int(11)           NOT NULL,
    `alert_date`     datetime          NOT NULL,
    `seen`           enum ('Yes','No') NOT NULL DEFAULT 'No'
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers`
(
    `subscriber_id`           int(16)                              NOT NULL,
    `vendor_id`               int(11)                              NOT NULL,
    `subscription_id`         int(16)                              NOT NULL,
    `subscription_start_date` datetime                             NOT NULL,
    `subscription_end_date`   datetime                             NOT NULL,
    `status`                  enum ('Active','Inactive','Expired') NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `subscription_plans`
--

CREATE TABLE `subscription_plans`
(
    `subscription_id`  int(11)        NOT NULL,
    `image_url`        varchar(255)            DEFAULT NULL,
    `name`             varchar(255)   NOT NULL,
    `description`      text                    DEFAULT NULL,
    `price`            decimal(10, 2) NOT NULL,
    `duration`         int(11)        NOT NULL,
    `max_products`     int(11)        NOT NULL,
    `deal_of_day`      int(16)        NOT NULL,
    `social_media`     int(16)        NOT NULL,
    `customer_support` varchar(3)     NOT NULL,
    `created_at`       timestamp      NOT NULL DEFAULT current_timestamp(),
    `updated_at`       timestamp      NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `useraddresses`
--

CREATE TABLE `useraddresses`
(
    `address_id`    int(11)      NOT NULL,
    `user_id`       int(11)      DEFAULT NULL,
    `address_line1` varchar(255) NOT NULL,
    `address_line2` varchar(255) DEFAULT NULL,
    `city`          varchar(100) NOT NULL,
    `postal_code`   varchar(20)  NOT NULL,
    `country`       varchar(100) NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users`
(
    `user_id`           int(11)                                    NOT NULL,
    `username`          varchar(255)                               NOT NULL,
    `full_name`         varchar(255)                               NOT NULL,
    `phone`             varchar(30) DEFAULT NULL,
    `email`             varchar(255)                               NOT NULL,
    `password`          varchar(255)                               NOT NULL,
    `role`              enum ('Vendor','Admin','Customer','Guest') NOT NULL,
    `registration_date` datetime                                   NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `usertheme`
--

CREATE TABLE `usertheme`
(
    `utid`                       int(16)     NOT NULL,
    `username`                   varchar(80) NOT NULL,
    `colorMode`                  varchar(25) DEFAULT NULL,
    `headerFixed`                varchar(45) DEFAULT NULL,
    `headerLegacy`               varchar(45) DEFAULT NULL,
    `headerBorder`               varchar(45) DEFAULT NULL,
    `sidebarCollapsed`           varchar(45) DEFAULT NULL,
    `sidebarFixed`               varchar(45) DEFAULT NULL,
    `sidebarMini`                varchar(45) DEFAULT NULL,
    `sidebarMiniMD`              varchar(45) DEFAULT NULL,
    `sidebarMiniXS`              varchar(45) DEFAULT NULL,
    `sidebarFlat`                varchar(45) DEFAULT NULL,
    `sidebarLegacy`              varchar(45) DEFAULT NULL,
    `sidebarCompact`             varchar(45) DEFAULT NULL,
    `sidebarIndentChild`         varchar(45) DEFAULT NULL,
    `sidebarHideChildOnCollapse` varchar(45) DEFAULT NULL,
    `sidebarDisableHover`        varchar(45) DEFAULT NULL,
    `footerFixed`                varchar(45) DEFAULT NULL,
    `smallBodyText`              varchar(45) DEFAULT NULL,
    `smallNavbarText`            varchar(45) DEFAULT NULL,
    `smallBrand`                 varchar(45) DEFAULT NULL,
    `smallSidebarText`           varchar(45) DEFAULT NULL,
    `smallFooterText`            varchar(45) DEFAULT NULL,
    `logoTheme`                  varchar(45) DEFAULT NULL,
    `navbarTheme`                varchar(45) DEFAULT NULL,
    `sidebarSkin`                varchar(45) DEFAULT NULL,
    `accentTheme`                varchar(45) DEFAULT NULL,
    `chatBox`                    varchar(80) DEFAULT NULL,
    `noticeBoard`                varchar(80) DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors`
(
    `vendor_id`      int(11)      NOT NULL,
    `user_id`        int(11)      NOT NULL,
    `shop_name`      varchar(255) NOT NULL,
    `description`    text                  DEFAULT NULL,
    `business_phone` varchar(80)           DEFAULT NULL,
    `whatsapp`       varchar(80)           DEFAULT NULL,
    `business_email` varchar(80)           DEFAULT NULL,
    `country`        varchar(16)           DEFAULT NULL,
    `city`           varchar(16)           DEFAULT NULL,
    `address`        varchar(120)          DEFAULT NULL,
    `iframe_code`    text                  DEFAULT NULL,
    `shop_logo`      varchar(255)          DEFAULT NULL,
    `created_at`     timestamp    NOT NULL DEFAULT current_timestamp()
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist`
(
    `wishlist_id` int(16)     NOT NULL,
    `user`        varchar(80) NOT NULL,
    `product_id`  int(16)     NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audittrail`
--
ALTER TABLE `audittrail`
    ADD PRIMARY KEY (`log_id`),
    ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
    ADD PRIMARY KEY (`banner_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
    ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
    ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
    ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
    ADD PRIMARY KEY (`code`),
    ADD UNIQUE KEY `country_code` (`country`, `code`);

--
-- Indexes for table `companylogos`
--
ALTER TABLE `companylogos`
    ADD PRIMARY KEY (`logos_id`);

--
-- Indexes for table `compare`
--
ALTER TABLE `compare`
    ADD PRIMARY KEY (`compare_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deals`
--
ALTER TABLE `deals`
    ADD PRIMARY KEY (`deal_id`);

--
-- Indexes for table `discounts`
--
ALTER TABLE `discounts`
    ADD PRIMARY KEY (`discount_id`);

--
-- Indexes for table `newsletters`
--
ALTER TABLE `newsletters`
    ADD PRIMARY KEY (`newsletter_id`);

--
-- Indexes for table `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
    ADD PRIMARY KEY (`newsletter_subscriber_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
    ADD PRIMARY KEY (`notification_id`),
    ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
    ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `product_views`
--
ALTER TABLE `product_views`
    ADD PRIMARY KEY (`view_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
    ADD PRIMARY KEY (`review_id`);

--
-- Indexes for table `salesdiscounts`
--
ALTER TABLE `salesdiscounts`
    ADD PRIMARY KEY (`discount_id`),
    ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `salesorderitems`
--
ALTER TABLE `salesorderitems`
    ADD PRIMARY KEY (`item_id`),
    ADD KEY `order_id` (`order_id`),
    ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `salesorders`
--
ALTER TABLE `salesorders`
    ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `salesorderstatus`
--
ALTER TABLE `salesorderstatus`
    ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `salespayments`
--
ALTER TABLE `salespayments`
    ADD PRIMARY KEY (`payment_id`),
    ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `stockalerts`
--
ALTER TABLE `stockalerts`
    ADD PRIMARY KEY (`alert_id`),
    ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
    ADD PRIMARY KEY (`subscriber_id`);

--
-- Indexes for table `subscription_plans`
--
ALTER TABLE `subscription_plans`
    ADD PRIMARY KEY (`subscription_id`);

--
-- Indexes for table `useraddresses`
--
ALTER TABLE `useraddresses`
    ADD PRIMARY KEY (`address_id`),
    ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
    ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `usertheme`
--
ALTER TABLE `usertheme`
    ADD PRIMARY KEY (`utid`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
    ADD PRIMARY KEY (`vendor_id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
    ADD PRIMARY KEY (`wishlist_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audittrail`
--
ALTER TABLE `audittrail`
    MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
    MODIFY `banner_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
    MODIFY `cart_id` int(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
    MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
    MODIFY `message_id` int(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `companylogos`
--
ALTER TABLE `companylogos`
    MODIFY `logos_id` int(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `compare`
--
ALTER TABLE `compare`
    MODIFY `compare_id` int(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deals`
--
ALTER TABLE `deals`
    MODIFY `deal_id` int(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
    MODIFY `discount_id` int(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `newsletters`
--
ALTER TABLE `newsletters`
    MODIFY `newsletter_id` int(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
    MODIFY `newsletter_subscriber_id` int(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
    MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
    MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_views`
--
ALTER TABLE `product_views`
    MODIFY `view_id` int(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
    MODIFY `review_id` int(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `salesdiscounts`
--
ALTER TABLE `salesdiscounts`
    MODIFY `discount_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `salesorderitems`
--
ALTER TABLE `salesorderitems`
    MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `salesorders`
--
ALTER TABLE `salesorders`
    MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `salesorderstatus`
--
ALTER TABLE `salesorderstatus`
    MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `salespayments`
--
ALTER TABLE `salespayments`
    MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stockalerts`
--
ALTER TABLE `stockalerts`
    MODIFY `alert_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
    MODIFY `subscriber_id` int(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscription_plans`
--
ALTER TABLE `subscription_plans`
    MODIFY `subscription_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `useraddresses`
--
ALTER TABLE `useraddresses`
    MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
    MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usertheme`
--
ALTER TABLE `usertheme`
    MODIFY `utid` int(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
    MODIFY `vendor_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
    MODIFY `wishlist_id` int(16) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS = @OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION = @OLD_COLLATION_CONNECTION */;
