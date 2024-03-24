-- Users Table
create table users
(
    user_id           INT auto_increment primary key,
    username          VARCHAR(255)             not null,
    email             VARCHAR(255)             not null,
    password          VARCHAR(255)             not null,
    role              ENUM ('vendor', 'admin') not null,
    registration_date TIMESTAMP default CURRENT_TIMESTAMP
);

-- Vendors Table
create table vendors
(
    vendor_id       INT auto_increment primary key,
    user_id         INT          not null,
    shop_name       VARCHAR(255) not null,
    description     TEXT,
    shop_logo       VARCHAR(255),
    subscription_id INT          null -- Added to reference vendor's subscription
);

-- Subscriptions Table
create table subscriptions
(
    subscription_id         INT auto_increment primary key,
    vendor_id               INT         not null,
    subscription_type       VARCHAR(50) not null,
    subscription_start_date DATETIME    not null,
    subscription_end_date   DATETIME    not null,
    product_limit           INT         not null -- Added product_limit field
);

-- Products Table
create table products
(
    product_id          INT auto_increment primary key,
    vendor_id           INT            not null,
    product_name        VARCHAR(255)   not null,
    product_description TEXT,
    price               DECIMAL(10, 2) not null,
    color               VARCHAR(50),    -- Added color field
    weight              DECIMAL(10, 2), -- Added weight field
    measurements        VARCHAR(100),   -- Added measurements field
    product_image       VARCHAR(255)    -- Added image field
    -- Add other fields as needed for your specific requirements
);

-- Banners Table
create table banners
(
    banner_id    INT auto_increment primary key,
    product_id   INT not null,
    banner_image VARCHAR(255)
);

-- Chat Messages Table
create table chat_messages
(
    message_id      INT auto_increment primary key,
    sender_id       INT  not null,
    receiver_id     INT  not null,
    message_content TEXT not null,
    timestamp       TIMESTAMP default CURRENT_TIMESTAMP
);

create table categories
(
    category_id   INT auto_increment primary key,
    category_name VARCHAR(255) not null
);

create table subcategories
(
    subcategory_id   INT auto_increment primary key,
    category_id      INT          not null,
    subcategory_name VARCHAR(255) not null
);
