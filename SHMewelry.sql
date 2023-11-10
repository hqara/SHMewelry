-- Create the SHMEWELRY database
CREATE DATABASE IF NOT EXISTS SHMEWELRY;

-- Use the SHMEWELRY database
USE SHMEWELRY;

-- Create the GROUP table
CREATE TABLE `GROUP` (
    GROUP_ID INT AUTO_INCREMENT PRIMARY KEY,
    GROUP_NAME VARCHAR(35)
);

-- Create the RIGHTS table
CREATE TABLE RIGHTS (
    ACTION_ID INT AUTO_INCREMENT PRIMARY KEY,
    ACTION_NAME VARCHAR(35),
    CLASS_NAME VARCHAR(35)
);

-- Create the GROUP_RIGHTS associative table
CREATE TABLE GROUP_RIGHTS (
    GROUP_ID INT,
    ACTION_ID INT,
    PRIMARY KEY (GROUP_ID, ACTION_ID),
    FOREIGN KEY (GROUP_ID) REFERENCES `GROUP`(GROUP_ID) ON DELETE CASCADE,
    FOREIGN KEY (ACTION_ID) REFERENCES RIGHTS(ACTION_ID) ON DELETE CASCADE
);

-- Create the USER table
CREATE TABLE USER (
    USER_ID INT AUTO_INCREMENT PRIMARY KEY,
    FNAME VARCHAR(35),
    LNAME VARCHAR(35),
    EMAIL VARCHAR(55),
    PASSWORD VARCHAR(255),
    GROUP_ID INT,
    FOREIGN KEY (GROUP_ID) REFERENCES `GROUP`(GROUP_ID) ON DELETE CASCADE
);

-- Create the ADDRESS table
CREATE TABLE ADDRESS (
    ADDRESS_ID INT AUTO_INCREMENT PRIMARY KEY,
    STREET_ADDRESS VARCHAR(55),
    CITY VARCHAR(35),
    PROVINCE VARCHAR(35),
    POSTAL_CODE VARCHAR(10),
    COUNTRY VARCHAR(35),
    USER_ID INT,
    FOREIGN KEY (USER_ID) REFERENCES USER(USER_ID) ON DELETE CASCADE
);

-- Create the ORDER table
CREATE TABLE `ORDER` (
    ORDER_ID INT AUTO_INCREMENT PRIMARY KEY,
    TOTAL_PRICE DECIMAL(10, 2),
    ORDER_DATE DATE,
    ORDER_STATUS VARCHAR(35),
    EXPECTED_DELIVERY DATE,
    USER_ID INT,
    FOREIGN KEY (USER_ID) REFERENCES USER(USER_ID) ON DELETE CASCADE
);

-- Create the PRODUCT table
CREATE TABLE PRODUCT (
    PRODUCT_ID INT AUTO_INCREMENT PRIMARY KEY,
    NAME VARCHAR(35),
    DESCRIPTION TEXT,
    PRICE DECIMAL(10, 2),
    MANUFACTURER VARCHAR(35),
    COLOR VARCHAR(35),
    MATERIAL VARCHAR(35),
    TYPE VARCHAR(35),
    SIZE VARCHAR(50),
    STOCK INT,
    PRODUCT_IMAGE VARCHAR(75)
);

-- Create the ORDER_DETAILS associative table
CREATE TABLE ORDER_DETAILS (
    ORDER_ID INT,
    PRODUCT_ID INT,
    QTY INT,
    USER_ID INT,
    PRIMARY KEY (ORDER_ID, PRODUCT_ID),
    FOREIGN KEY (ORDER_ID) REFERENCES `ORDER`(ORDER_ID) ON DELETE CASCADE,
    FOREIGN KEY (PRODUCT_ID) REFERENCES PRODUCT(PRODUCT_ID) ON DELETE CASCADE,
    FOREIGN KEY (USER_ID) REFERENCES USER(USER_ID) ON DELETE CASCADE
);

-- Create the USER_PRODUCT associative table
CREATE TABLE USER_PRODUCT (
    USER_ID INT,
    PRODUCT_ID INT,
    QTY INT,
    PRIMARY KEY (USER_ID, PRODUCT_ID),
    FOREIGN KEY (USER_ID) REFERENCES USER(USER_ID) ON DELETE CASCADE,
    FOREIGN KEY (PRODUCT_ID) REFERENCES PRODUCT(PRODUCT_ID) ON DELETE CASCADE
);

-- Insert values into the GROUP table
INSERT INTO `GROUP` (GROUP_NAME) VALUES
    ('Client'),
    ('Moderator'),
    ('Admin');

-- Insert values into the RIGHTS table with corresponding ACTION_ID:
INSERT INTO RIGHTS (ACTION_NAME, CLASS_NAME) VALUES
    ('Create', 'User'),     -- ACTION_ID = 1
    ('Read', 'User'),       -- ACTION_ID = 2
    ('Update', 'User'),     -- ACTION_ID = 3
    ('Delete', 'User'),     -- ACTION_ID = 4
    ('Create', 'Address'),  -- ACTION_ID = 5
    ('Read', 'Address'),    -- ACTION_ID = 6
    ('Update', 'Address'),  -- ACTION_ID = 7
    ('Delete', 'Address'),  -- ACTION_ID = 8
    ('Create', 'Product'),  -- ACTION_ID = 9
    ('Read', 'Product'),    -- ACTION_ID = 10
    ('Update', 'Product'),  -- ACTION_ID = 11
    ('Delete', 'Product'),  -- ACTION_ID = 12
    ('Create', 'Order'),    -- ACTION_ID = 13
    ('Read', 'Order'),      -- ACTION_ID = 14
    ('Update', 'Order'),    -- ACTION_ID = 15
    ('Delete', 'Order');    -- ACTION_ID = 16

-- Insert values into the GROUP_RIGHTS table
-- ADMIN (ID=3) can use CRUD for all Order, Product, User tables 
-- but only READ for Address table
INSERT INTO GROUP_RIGHTS (GROUP_ID, ACTION_ID) VALUES
    (3, 1),  -- Create User
    (3, 2),  -- Read User
    (3, 3),  -- Update User
    (3, 4),  -- Delete User
    (3, 6),  -- Read Address
    (3, 9),  -- Create Product
    (3, 10), -- Read Product
    (3, 11), -- Update Product
    (3, 12), -- Delete Product
    (3, 13), -- Create Order
    (3, 14), -- Read Order
    (3, 15), -- Update Order
    (3, 16); -- Delete Order

-- MODERATOR (ID=2) can use CRUD for all Order and Product tables, 
-- READ and DELETE for User table, and can only VIEW Address table
INSERT INTO GROUP_RIGHTS (GROUP_ID, ACTION_ID) VALUES
    (2, 2),  -- Read User
    (2, 4),  -- Delete User
    (2, 6),  -- Read Address
    (2, 9),  -- Create Product
    (2, 10), -- Read Product
    (2, 11), -- Update Product
    (2, 12), -- Delete Product
    (2, 13), -- Create Order
    (2, 14), -- Read Order
    (2, 15), -- Update Order
    (2, 16); -- Delete Order

-- CLIENT (ID=1) can use CREATE, READ, and DELETE for User and Order tables,
-- CREATE, READ, and UPDATE for Address table, and ONLY READ for Product table
INSERT INTO GROUP_RIGHTS (GROUP_ID, ACTION_ID) VALUES
    (1, 1),  -- Create User
    (1, 2),  -- Read User
    (1, 4),  -- Delete User
    (1, 5),  -- Create Address
    (1, 6),  -- Read Address
    (1, 7),  -- Update Address
    (1, 10), -- Read Product
    (1, 13), -- Create Order
    (1, 14), -- Read Order
    (1, 16); -- Delete Order

-- Insert values into the USER table (sample data using MD5 hash function for password)
INSERT INTO USER (FNAME, LNAME, EMAIL, PASSWORD, GROUP_ID) VALUES
    ('John', 'Doe', 'johndoe@example.com', MD5('client'), 1), -- Client, password: client
    ('Jane', 'Smith', 'janesmith@example.com', MD5('moderator'), 2), -- Moderator, password: moderator
    ('Alice', 'Johnson', 'alicejohnson@example.com', MD5('admin'), 3), -- Admin, password: admin
    ('Bob', 'Brown', 'bobbrown@example.com', MD5('client'), 1), -- Client, password: client
    ('Eva', 'Williams', 'evawilliams@example.com', MD5('client'), 1); -- Client, password: client

-- Insert values into the ADDRESS table (only client's sample data)
INSERT INTO ADDRESS (STREET_ADDRESS, CITY, PROVINCE, POSTAL_CODE, COUNTRY, USER_ID)
VALUES
    ('123 Main St', 'New York', 'NY', '10001', 'USA', 1), -- John Doe's address
    ('456 Elm St', 'Los Angeles', 'CA', '90001', 'USA', 4), -- Bob Brown's address
    ('789 Oak St', 'Chicago', 'IL', '60601', 'USA', 5); -- Eva Williams' address

-- Insert values into the PRODUCT table (sample data)
INSERT INTO PRODUCT (NAME, DESCRIPTION, PRICE, MANUFACTURER, COLOR, MATERIAL, TYPE, SIZE, STOCK, PRODUCT_IMAGE) VALUES
    ('Diamond Ring', 'Beautiful diamond ring', 999.99, 'Diamond Co.', 'White', 'Gold', 'Ring', 'one-size', 60, 'ring1.jpg'),
    ('Pearl Necklace', 'Elegant pearl necklace', 599.99, 'Pearl Jewelry', 'White', 'Rosegold', 'Necklace', 'one-size', 45, 'necklace1.jpg'),
    ('Sapphire Bracelet', 'Stunning sapphire bracelet', 799.99, 'Sapphire Co.', 'Blue', 'Silver', 'Bracelet', 'one-size', 58, 'bracelet1.jpg'),
    ('Emerald Earrings', 'Dazzling emerald earrings', 399.99, 'Emerald Jewelry', 'Green', 'Gold', 'Earring', 'one-size', 12, 'earring1.jpg'),
    ('Copper Bracelet', 'Unique copper bracelet', 199.99, 'Copper Creations', 'Red', 'Copper', 'Bracelet', 'one-size', 25, 'bracelet2.jpg');

-- Insert values into the ORDER table (only client's sample data)
INSERT INTO `ORDER` (TOTAL_PRICE, ORDER_DATE, ORDER_STATUS, EXPECTED_DELIVERY, USER_ID) VALUES
    (999.99, '2023-10-20', 'Processed', '2023-10-25', 1), -- John Doe's order
    (599.99, '2023-10-19', 'Shipped', '2023-10-24', 4), -- Bob Brown's order
    (799.99, '2023-10-18', 'Delivered', '2023-10-23', 5); -- Eva Williams'order
-- Added
INSERT INTO `order` (`ORDER_ID`, `TOTAL_PRICE`, `ORDER_DATE`, `ORDER_STATUS`, `EXPECTED_DELIVERY`, `USER_ID`) VALUES (NULL, '23.25', '2023-11-08', 'Shipped', '2023-11-11', '1'), (NULL, '44.34', '2023-11-01', 'Delivered', '2023-11-06', '1');

-- Insert values into the ORDER_DETAILS table (only client's sample data)
INSERT INTO ORDER_DETAILS (ORDER_ID, PRODUCT_ID, QTY, USER_ID) VALUES
    (1, 1, 1, 1), -- John Doe's order details about product id=1 (Diamond Ring)
    (1, 2, 1, 1), -- John Doe's order details about product id=2 (Pearl Necklace)
    (2, 4, 1, 4), -- Bob Brown's order details about product id=4 (Emerald Earrings)
    (3, 3, 1, 5), -- Eva Williams' order details about product id=3 (Sapphire Bracelet)
    (3, 5, 2, 5); -- Eva Williams' order details about product id=5 (Copper Bracelet)

ALTER TABLE `ORDER`
ADD CONSTRAINT chk_order_status
CHECK (ORDER_STATUS IN ('Processed', 'Shipped', 'Delivered'));

