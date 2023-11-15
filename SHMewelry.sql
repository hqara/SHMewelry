-- Create the SHMEWELRY database
CREATE DATABASE IF NOT EXISTS SHMEWELRY;

-- Use the SHMEWELRY database
USE SHMEWELRY;

-- Create the `GROUP` table
CREATE TABLE `GROUP` (
    GROUP_ID INT AUTO_INCREMENT PRIMARY KEY,
    GROUP_NAME VARCHAR(35)
);

-- Create the RIGHTS table
CREATE TABLE RIGHTS (
    RIGHTS_ID INT AUTO_INCREMENT PRIMARY KEY,
    ACTION_NAME VARCHAR(35),
    CLASS_NAME VARCHAR(35)
);

-- Create the GROUP_RIGHTS associative table
CREATE TABLE GROUP_RIGHTS (
    GROUP_ID INT,
    RIGHTS_ID INT,
    PRIMARY KEY (GROUP_ID, RIGHTS_ID),
    FOREIGN KEY (GROUP_ID) REFERENCES `GROUP`(GROUP_ID) ON DELETE CASCADE,
    FOREIGN KEY (RIGHTS_ID) REFERENCES RIGHTS(RIGHTS_ID) ON DELETE CASCADE
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


-- Create the USER_ADDRESS table to represent the many-to-many relationship
CREATE TABLE USER_ADDRESS (
    USER_ID INT,
    ADDRESS_ID INT,
    PRIMARY KEY (USER_ID, ADDRESS_ID),
    FOREIGN KEY (USER_ID) REFERENCES USER(USER_ID) ON DELETE CASCADE,
    FOREIGN KEY (ADDRESS_ID) REFERENCES ADDRESS(ADDRESS_ID) ON DELETE CASCADE
);


-- Create the ORDERS table
CREATE TABLE ORDERS (
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
    PRODUCT_IMAGE VARCHAR(255)
);

-- Create the ORDER_PRODUCT associative table
CREATE TABLE ORDER_PRODUCTS (
    ORDER_ID INT,
    PRODUCT_ID INT,
    QTY INT,
    USER_ID INT,
    PRIMARY KEY (ORDER_ID, PRODUCT_ID),
    FOREIGN KEY (ORDER_ID) REFERENCES ORDERS (ORDER_ID) ON DELETE CASCADE,
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

-- Add a CHECK constraint to allow only GROUP_ID values 1, 2, and 3
ALTER TABLE USER
ADD CONSTRAINT check_group_id
CHECK (GROUP_ID IN (1, 2, 3));

-- Add a UNIQUE constraint to the EMAIL column in the USER table
ALTER TABLE USER
ADD CONSTRAINT unique_email
UNIQUE (EMAIL);


-- Add a CHECK constraint to allow only addresses for users in group_id=1 (Client) to insert into ADDRESS
-- ALTER TABLE ADDRESS
-- ADD CONSTRAINT check_client_address
-- CHECK (USER_ID IN (SELECT USER_ID FROM USER WHERE GROUP_ID = 1));

-- Add a CHECK constraint to allow only users from group_id=1 (Client) to insert into USER_PRODUCT
-- ALTER TABLE USER_PRODUCT
-- ADD CONSTRAINT check_client_user_product
-- CHECK (USER_ID IN (SELECT USER_ID FROM USER WHERE GROUP_ID = 1));

-- Add constraints to the GROUP_RIGHTS table
ALTER TABLE GROUP_RIGHTS
ADD CONSTRAINT fk_group_id
FOREIGN KEY (GROUP_ID) REFERENCES `GROUP`(GROUP_ID) ON DELETE CASCADE,
ADD CONSTRAINT fk_rights_id
FOREIGN KEY (RIGHTS_ID) REFERENCES RIGHTS(RIGHTS_ID) ON DELETE CASCADE;

-- Add a CHECK constraint to allow only ORDER_STATUS values "Processed", "Shipped", and "Delivered"
ALTER TABLE ORDERS
ADD CONSTRAINT chk_order_status
CHECK (ORDER_STATUS IN ('Processed', 'Shipped', 'Delivered'));


-- Insert values into the GROUP table
INSERT INTO `GROUP` (GROUP_NAME) VALUES
    ('Client'),
    ('Moderator'),
    ('Admin');

-- Insert values into the RIGHTS table with corresponding RIGHTS_ID:
INSERT INTO RIGHTS (ACTION_NAME, CLASS_NAME) VALUES
    ('Create', 'User'),     -- RIGHTS_ID = 1
    ('Read', 'User'),       -- RIGHTS_ID = 2
    ('Update', 'User'),     -- RIGHTS_ID = 3
    ('Delete', 'User'),     -- RIGHTS_ID = 4
    ('Create', 'Address'),  -- RIGHTS_ID = 5
    ('Read', 'Address'),    -- RIGHTS_ID = 6
    ('Update', 'Address'),  -- RIGHTS_ID = 7
    ('Delete', 'Address'),  -- RIGHTS_ID = 8
    ('Create', 'Product'),  -- RIGHTS_ID = 9
    ('Read', 'Product'),    -- RIGHTS_ID = 10
    ('Update', 'Product'),  -- RIGHTS_ID = 11
    ('Delete', 'Product'),  -- RIGHTS_ID = 12
    ('Create', 'Orders'),    -- RIGHTS_ID = 13
    ('Read', 'Orders'),      -- RIGHTS_ID = 14
    ('Update', 'Orders'),    -- RIGHTS_ID = 15
    ('Delete', 'Orders');    -- RIGHTS_ID = 16

-- Insert values into the GROUP_RIGHTS table
-- ADMIN (ID=3) can use CRUD for all Orders, Product, User tables 
-- but only READ for Address table
INSERT INTO GROUP_RIGHTS (GROUP_ID, RIGHTS_ID) VALUES
    (3, 1),  -- Create User
    (3, 2),  -- Read User
    (3, 3),  -- Update User
    (3, 4),  -- Delete User
    (3, 6),  -- Read Address
    (3, 9),  -- Create Product
    (3, 10), -- Read Product
    (3, 11), -- Update Product
    (3, 12), -- Delete Product
    (3, 13), -- Create Orders
    (3, 14), -- Read Orders
    (3, 15), -- Update Orders
    (3, 16); -- Delete Orders

-- MODERATOR (ID=2) can use CRUD for all Orders and Product tables, 
-- READ and DELETE for User table, and can only VIEW Address table
INSERT INTO GROUP_RIGHTS (GROUP_ID, RIGHTS_ID) VALUES
    (2, 2),  -- Read User
    (2, 4),  -- Delete User
    (2, 6),  -- Read Address
    (2, 9),  -- Create Product
    (2, 10), -- Read Product
    (2, 11), -- Update Product
    (2, 12), -- Delete Product
    (2, 13), -- Create Orders
    (2, 14), -- Read Orders
    (2, 15), -- Update Orders
    (2, 16); -- Delete Orders

-- CLIENT (ID=1) can use CREATE, READ, and DELETE for User and Orders tables,
-- CREATE, READ, and UPDATE for Address table, and ONLY READ for Product table
INSERT INTO GROUP_RIGHTS (GROUP_ID, RIGHTS_ID) VALUES
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

    -- Insert values into the USER_ADDRESS table (sample data)
INSERT INTO USER_ADDRESS (USER_ID, ADDRESS_ID) VALUES
    (1, 1), -- John Doe's address
    (4, 2), -- Bob Brown's address
    (5, 3); -- Eva Williams' address

-- Insert values into the PRODUCT table (sample data)
INSERT INTO PRODUCT (NAME, DESCRIPTION, PRICE, MANUFACTURER, COLOR, MATERIAL, TYPE, SIZE, STOCK, PRODUCT_IMAGE) VALUES
    ('Diamond Ring', 'Beautiful diamond ring', 999.99, 'Diamond Co.', 'White', 'Gold', 'Ring', 'one-size', 60, 'ring1.jpg'),
    ('Pearl Necklace', 'Elegant pearl necklace', 599.99, 'Pearl Jewelry', 'White', 'Rosegold', 'Necklace', 'one-size', 45, 'necklace1.jpg'),
    ('Sapphire Bracelet', 'Stunning sapphire bracelet', 799.99, 'Sapphire Co.', 'Blue', 'Silver', 'Bracelet', 'one-size', 58, 'bracelet1.jpg'),
    ('Emerald Earrings', 'Dazzling emerald earrings', 399.99, 'Emerald Jewelry', 'Green', 'Gold', 'Earring', 'one-size', 12, 'earring1.jpg'),
    ('Copper Bracelet', 'Unique copper bracelet', 199.99, 'Copper Creations', 'Red', 'Copper', 'Bracelet', 'one-size', 25, 'bracelet2.jpg');

-- Insert values into the ORDER table (only client's sample data)
INSERT INTO ORDERS (TOTAL_PRICE, ORDER_DATE, ORDER_STATUS, EXPECTED_DELIVERY, USER_ID) VALUES
    (999.99, '2023-10-20', 'Processed', '2023-10-25', 1), -- John Doe's order id#1
    (599.99, '2023-10-19', 'Shipped', '2023-10-24', 4), -- Bob Brown's order id#2
    (799.99, '2023-10-18', 'Delivered', '2023-10-23', 5), -- Eva Williams'order id#3
    (23.25, '2023-11-08', 'Shipped', '2023-11-11', 1),    -- John Doe's order id#4
    (44.34, '2023-11-01', 'Delivered', '2023-11-06', 1),  -- John Doe's order id#5
    (109.95, '2023-11-08', 'Shipped', '2023-11-11', 1),    -- John Doe's order id#6
    (299.95, '2023-11-09', 'Processed', '2023-11-12', 1);  -- John Doe's order id#7

-- Insert values into the ORDER_PRODUCTS table (only client's sample data)
INSERT INTO ORDER_PRODUCTS (ORDER_ID, PRODUCT_ID, QTY, USER_ID) VALUES
    (1, 1, 1, 1), -- John Doe's order details (order#1) about product id=1 (Diamond Ring)
    (1, 2, 1, 1), -- John Doe's order details (order#1) about product id=2 (Pearl Necklace)
    (2, 4, 1, 4), -- Bob Brown's order details (order2) about product id=4 (Emerald Earrings)
    (3, 3, 1, 5), -- Eva Williams' order details (order#3 )about product id=3 (Sapphire Bracelet)
    (3, 5, 2, 5), -- Eva Williams' order details (order#3) about product id=5 (Copper Bracelet)
    (4, 4, 2, 1), -- John Doe's order details (order#4) about product id=4 (Emerald Earrings)
    (5, 4, 2, 4), -- Eva Williams' order details (order#5)about product id=4 (Emerald Earrings)
    (6, 3, 2, 1), -- John Doe's order details (order#6) about product id=3 (Sapphire Bracelet)
    (7, 5, 3, 1); -- John Doe's order details (order#7) about product id=5 (Copper Bracelet)

-- Insert values into the USER_PRODUCT table (add to cart) for users in group_id=1 (Client)
INSERT INTO USER_PRODUCT (USER_ID, PRODUCT_ID, QTY) VALUES
    (1, 1, 2),  -- John Doe adds 2 Diamond Rings to the cart
    (1, 3, 1),  -- John Doe adds 1 Sapphire Bracelet to the cart
    (4, 2, 3);  -- Bob Brown adds 3 Pearl Necklaces to the cart

