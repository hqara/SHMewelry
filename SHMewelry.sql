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
    IS_DEFAULT BOOLEAN, 
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
    ('create', 'user'),     -- RIGHTS_ID = 1
    ('read', 'user'),       -- RIGHTS_ID = 2
    ('update', 'user'),     -- RIGHTS_ID = 3
    ('delete', 'user'),     -- RIGHTS_ID = 4
    ('add', 'user'),        -- RIGHTS_ID = 5
    ('edit', 'user'),       -- RIGHTS_ID = 6
    ('view', 'user'),       -- RIGHTS_ID = 7
    ('list', 'user'),       -- RIGHTS_ID = 8
    ('save', 'user'),       -- RIGHTS_ID = 9
    ('remove', 'user'),     -- RIGHTS_ID = 10
    ('create', 'address'),  -- RIGHTS_ID = 11
    ('read', 'address'),    -- RIGHTS_ID = 12
    ('update', 'address'),  -- RIGHTS_ID = 13
    ('delete', 'address'),  -- RIGHTS_ID = 14
    ('add', 'address'),     -- RIGHTS_ID = 15
    ('edit', 'address'),    -- RIGHTS_ID = 16
    ('view', 'address'),    -- RIGHTS_ID = 17
    ('list', 'address'),    -- RIGHTS_ID = 18
    ('save', 'address'),    -- RIGHTS_ID = 19
    ('remove', 'address'),  -- RIGHTS_ID = 20
    ('create', 'product'),  -- RIGHTS_ID = 21
    ('read', 'product'),    -- RIGHTS_ID = 22
    ('update', 'product'),  -- RIGHTS_ID = 23
    ('delete', 'product'),  -- RIGHTS_ID = 24
    ('add', 'product'),     -- RIGHTS_ID = 25
    ('edit', 'product'),    -- RIGHTS_ID = 26
    ('view', 'product'),    -- RIGHTS_ID = 27
    ('list', 'product'),    -- RIGHTS_ID = 28
    ('save', 'product'),    -- RIGHTS_ID = 29
    ('remove', 'product'),  -- RIGHTS_ID = 30
    ('create', 'orders'),   -- RIGHTS_ID = 31
    ('read', 'orders'),     -- RIGHTS_ID = 32
    ('update', 'orders'),   -- RIGHTS_ID = 33
    ('delete', 'orders'),   -- RIGHTS_ID = 34
    ('add', 'orders'),      -- RIGHTS_ID = 35
    ('edit', 'orders'),     -- RIGHTS_ID = 36
    ('view', 'orders'),     -- RIGHTS_ID = 37
    ('list', 'orders'),     -- RIGHTS_ID = 38
    ('save', 'orders'),     -- RIGHTS_ID = 39
    ('remove', 'orders'),   -- RIGHTS_ID = 40
    ('search', 'product'),  -- RIGHTS_ID = 41
    ('shop', 'user'),       -- RIGHTS_ID = 42
    ('cart', 'user'),       -- RIGHTS_ID = 43
    ('checkout', 'user'),   -- RIGHTS_ID = 44
    ('clear', 'user');      -- RIGHTS_ID = 45

-- Insert values into the GROUP_RIGHTS table

-- ADMIN (ID=3) rights
INSERT INTO GROUP_RIGHTS (GROUP_ID, RIGHTS_ID) VALUES
    (3, 1),  -- Create User
    (3, 2),  -- Read User
    (3, 3),  -- Update User
    (3, 4),  -- Delete User
    (3, 5),  -- Add User
    (3, 6),  -- Edit User
    (3, 7),  -- View User
    (3, 8),  -- List User
    (3, 9),  -- Save User
    (3, 10), -- Remove User
    (3, 12), -- Read Address
    (3, 17), -- View Address
    (3, 21), -- Create Product
    (3, 22), -- Read Product
    (3, 23), -- Update Product
    (3, 24), -- Delete Product
    (3, 25), -- Add Product
    (3, 26), -- Edit Product
    (3, 27), -- View Product
    (3, 28), -- List Product
    (3, 29), -- Save Product
    (3, 30), -- Remove Product
    (3, 41), -- Search Product
    (3, 32), -- Read Orders
    (3, 33), -- Update Orders
    (3, 34), -- Delete Orders
    (3, 36), -- Edit Orders
    (3, 37), -- View Orders
    (3, 38), -- List Orders
    (3, 40), -- Remove Orders
    (3, 41); -- Search Products 

-- MODERATOR (ID=2) rights
INSERT INTO GROUP_RIGHTS (GROUP_ID, RIGHTS_ID) VALUES
    (2, 2),  -- Read User
    (2, 4),  -- Delete User
    (2, 7),  -- View User
    (2, 9),  -- Save User
    (2, 10),  -- Remove User
    (2, 12), -- Read Address
    (2, 17), -- View Address
    (2, 21), -- Create Product
    (2, 22), -- Read Product
    (2, 23), -- Update Product
    (2, 24), -- Delete Product
    (2, 25), -- Add Product
    (2, 26), -- Edit Product
    (2, 27), -- View Product
    (2, 28), -- List Product
    (2, 29), -- Save Product
    (2, 30), -- Remove Product
    (2, 41), -- Search Product
    (2, 32), -- Read Orders
    (2, 33), -- Update Orders
    (2, 34), -- Delete Orders
    (2, 36), -- Edit Orders
    (2, 37), -- View Orders
    (2, 38), -- List Orders
    (2, 40), -- Remove Orders
    (2, 41); -- Search Products 

-- CLIENT (ID=1) rights
INSERT INTO GROUP_RIGHTS (GROUP_ID, RIGHTS_ID) VALUES
    (1, 1),  -- Create User
    (1, 2),  -- Read User
    (1, 3),  -- Update User
    (1, 4),  -- Delete User
    (1, 7),  -- View User
    (1, 9),  -- Save User
    (1, 10), -- Remove User
    (1, 11),  -- Create Address
    (1, 12),  -- Read Address
    (1, 13),  -- Update Address
    (1, 14),  -- Delete Address
    (1, 15),  -- Add Address
    (1, 16),  -- Edit Address
    (1, 17),  -- View Address
    (1, 19),  -- Save Address
    (1, 20),  -- Remove Address
    (1, 22),  -- Read Product
    (1, 27),  -- View Product
    (1, 41),  -- Search Product
    (1, 31),  -- Create Orders
    (1, 32),  -- Read Orders
    (1, 34),  -- Delete Orders
    (1, 35),  -- Add Orders
    (1, 37),  -- View Orders
    (1, 38),  -- List Orders
    (1, 40),  -- Remove Orders
    (1, 41),  -- Search Products 
    (1, 42),  -- Shop User
    (1, 43),  -- Cart User
    (1, 44),  -- CheckOut User
    (1, 45);  -- Clear User

-- Insert values into the USER table (sample data using MD5 hash function for password)
INSERT INTO USER (FNAME, LNAME, EMAIL, PASSWORD, GROUP_ID) VALUES
    ('John', 'Doe', 'johndoe@example.com', MD5('client'), 1), -- Client, password: client
    ('Jane', 'Smith', 'janesmith@example.com', MD5('moderator'), 2), -- Moderator, password: moderator
    ('Alice', 'Johnson', 'alicejohnson@example.com', MD5('admin'), 3), -- Admin, password: admin
    ('Bob', 'Brown', 'bobbrown@example.com', MD5('client'), 1), -- Client, password: client
    ('Eva', 'Williams', 'evawilliams@example.com', MD5('client'), 1); -- Client, password: client

-- Insert values into the ADDRESS table (only client's sample data)
INSERT INTO ADDRESS (STREET_ADDRESS, CITY, PROVINCE, POSTAL_CODE, COUNTRY, USER_ID, IS_DEFAULT)
VALUES
    ('123 Main St', 'New York', 'NY', '10001', 'USA', 1, true), -- John Doe's default address
    ('456 Elm St', 'Los Angeles', 'CA', '90001', 'USA', 1, false), -- John Doe's non-default address
    ('789 Oak St', 'Chicago', 'IL', '60601', 'USA', 1, false), -- John Doe's non-default address
    ('101 Pine St', 'San Francisco', 'CA', '94101', 'USA', 4, true), -- Bob Brown's default address
    ('202 Maple St', 'Seattle', 'WA', '98101', 'USA', 4, false), -- Bob Brown's non-default address
    ('303 Cedar St', 'Dallas', 'TX', '75201', 'USA', 5, true), -- Eva Williams' default address
    ('404 Birch St', 'Miami', 'FL', '33101', 'USA', 5, false); -- Eva Williams' non-default address


    -- Insert values into the USER_ADDRESS table (sample data)
INSERT INTO USER_ADDRESS (USER_ID, ADDRESS_ID) VALUES
    (1, 1), -- John Doe's address
    (4, 2), -- Bob Brown's address
    (5, 3); -- Eva Williams' address

-- Insert values into the PRODUCT table (sample data)
INSERT INTO PRODUCT (NAME, DESCRIPTION, PRICE, MANUFACTURER, COLOR, MATERIAL, TYPE, SIZE, STOCK, PRODUCT_IMAGE) VALUES
    ('Diamond Ring', 'Beautiful diamond ring', 999.99, 'Diamond Co.', 'Clear', 'Silver', 'Ring', 'one-size', 60, 'ring1.jpg'),                                                  -- 1
    ('Pearl Necklace', 'Elegant pearl necklace', 599.99, 'Pearl Charm Jewelry', 'Pink', 'RoseGold', 'Necklace', 'one-size', 45, 'necklace1.jpg'),                               -- 2
    ('Sapphire Bracelet', 'Stunning sapphire bracelet', 799.99, 'Pandora Co.', 'Green', 'Gold', 'Bracelet', 'one-size', 58, 'bracelet1.jpg'),                                   -- 3
    ('Emerald Earrings', 'Dazzling emerald earrings', 399.99, 'Heart Silver Jewelry', 'Pink', 'Silver', 'Earring', 'one-size', 12, 'earring1.jpg'),                             -- 4
    ('Copper Bracelet', 'Unique copper bracelet', 199.99, 'Jewelry Creations', 'Clear', 'RoseGold', 'Bracelet', 'one-size', 25, 'bracelet2.jpg'),                               -- 5 
    ('Archer Ring', 'Beautiful archer-themed ring', 499.99, 'JewelCrafters', 'Silver', 'Silver', 'Ring', 'one-size', 100, 'ring100.jpg'),                                       -- 6
    ('Archer Bracelet', 'Stylish archer-themed bracelet', 299.99, 'FashionGems', 'Clear', 'Silver', 'Bracelet', 'one-size', 75, 'bracelet5.jpg'),                               -- 7
    ('Archer Necklace', 'Elegant circle necklace', 969.99, 'LuxuryJewels', 'Clear', 'Silver', 'Necklace', 'one-size', 50, 'necklace3.jpg'),                                     -- 8
    ('Archer Earring', 'Chic star-themed earring', 199.99, 'GlamourGems', 'Clear', 'Silver', 'Earring', 'one-size', 120, 'earring4.jpg'),                                       -- 9
    ('Celestial Collection Ring', 'Exquisite sun-themed ring', 599.99, 'DiamondCrafters', 'White', 'Gold', 'Ring', 'one-size', 90, 'ring5.jpg'),                                -- 10
    ('Archer Bracelet', 'Trendy archer-themed bracelet', 399.99, 'ModernStyles', 'Silver', 'Silver', 'Bracelet', 'one-size', 60, 'bracelet6.jpg'),                              -- 11
    ('Archer Butterfly Necklace', 'Luxurious butterfly-themed necklace', 799.99, 'EliteCrafts', 'Blue', 'Silver', 'Necklace', 'one-size', 30, 'necklace7.jpg'),                 -- 12
    ('Archer Floral Earring', 'Elegant floral-themed earring', 294.99, 'ChicDesigns', 'Clear', 'Silver', 'Earring', 'one-size', 150, 'earring8.jpg'),                           -- 13
    ('Archer Blue Ring', 'Classy blue-themed ring', 594.99, 'TimelessJewels', 'Blue', 'Silver', 'Ring', 'one-size', 80, 'ring9.jpg'),                                           -- 14
    ('Archer Bracelet', 'Unique archer-themed bracelet', 394.99, 'ArtisanCrafts', 'Clear', 'RoseGold', 'Bracelet', 'one-size', 45, 'bracelet10.jpg'),                           -- 15        
    ('Monarchy Collection Ring', 'Exquisite heart royal-themed ring', 799.99, 'RoyalJewelers', 'Pink', 'RoseGold', 'Ring', 'one-size', 80, 'ring11.jpg'),                       -- 16 
    ('Monarchy Collection Bracelet', 'Tennis royal-themed bracelet', 499.99, 'LuxuryGems', 'Clear', 'Silver', 'Bracelet', 'one-size', 60, 'bracelet12.jpg'),                    -- 17
    ('Monarchy Collection Necklace', 'Opulent heart royal-themed necklace', 999.99, 'EliteCrafts', 'Red', 'Silver', 'Necklace', 'one-size', 30, 'necklace13.jpg'),              -- 18
    ('Monarchy Collection Earring', 'Elegant royal-themed earring', 399.99, 'ChicDesigns', 'Clear', 'Gold', 'Earring', 'one-size', 120, 'earring14.jpg'),                       -- 19
    ('Monarchy Collection Ring', 'Majestic royal-themed ring', 899.99, 'TimelessJewels', 'Yellow', 'Gold', 'Ring', 'one-size', 70, 'ring15.jpg'),                               -- 20
    ('Monarchy Collection Bracelet', 'Sumptuous royal-themed bracelet', 599.99, 'ModernStyles', 'Clear', 'Silver', 'Bracelet', 'one-size', 45, 'bracelet16.jpg'),               -- 21
    ('Monarchy Collection Necklace', 'Floral sapphire necklace', 1299.99, 'LuxuryJewels', 'Sapphire', 'Silver', 'Necklace', 'one-size', 20, 'necklace17.jpg'),                  -- 22
    ('Monarchy Collection Earring', 'Charming royal-themed earring', 499.99, 'GlamourGems', 'Clear', 'Rosegold', 'Earring', 'one-size', 100, 'earring18.jpg'),                  -- 23
    ('Celestial Collection Ring', 'Elegant Moon ring with diamonds', 999.99, 'DiamondCrafters', 'Blue', 'Silver', 'Ring', 'one-size', 60, 'ring19.jpg'),                        -- 24
    ('Monarchy Collection Bracelet', 'Royal-themed bracelet with gems', 699.99, 'GemArtisans', 'Clear', 'Gold', 'Bracelet', 'one-size', 35, 'bracelet20.jpg'),                  -- 25
    ('Industrial Collection Ring', 'Robust industrial-themed ring', 599.99, 'SilverCrafters', 'Clear', 'Silver', 'Ring', 'one-size', 70, 'ring3.jpg'),                          -- 26
    ('Industrial Collection Bracelet', 'Modern industrial-themed bracelet', 344.99, 'MetalWorks', 'Rose', 'RoseGold', 'Bracelet', 'one-size', 50, 'bracelet42.jpg'),            -- 27
    ('Nature Collection Necklace', 'Nature tree-themed necklace', 744.99, 'NatureMotif', 'Clear', 'Silver', 'Necklace', 'one-size', 30, 'necklace43.jpg'),                      -- 28
    ('Nature Collection Earring', 'Nature floral-themed earring', 299.99, 'NatureMotif', 'Pink', 'RoseGold', 'Earring', 'one-size', 100, 'earring44.jpg'),                      -- 29
    ('Nature Collection Ring', 'Nature heart-shaped ring', 699.99, 'NatureMotif', 'Clear', 'RoseGold', 'Ring', 'one-size', 60, 'ring45.jpg'),                                   -- 30
    ('Spear Collection Ring', 'Bold spear-themed ring', 69.99, 'WarriorCrafts', 'Clear', 'Silver', 'Ring', 'one-size', 70, 'ring21.jpg'),                                       -- 31
    ('Heart Collection Bracelet', 'Daring heart-shaped bracelet', 39.99, 'AdventurousDesigns', 'Pink', 'RoseGold', 'Bracelet', 'one-size', 50, 'bracelet22.jpg'),               -- 32
    ('Floral Collection Necklace', 'Striking floral-themed necklace', 79.99, 'FloralJewels', 'Clear', 'Gold', 'Necklace', 'one-size', 30, 'necklace23.jpg'),                    -- 33
    ('Heart Collection Earring', 'Fierce heart-themed earring', 29.99, 'HeartGems', 'Clear', 'RoseGold', 'Earring', 'one-size', 100, 'earring24.jpg'),                          -- 34
    ('Spear Collection Ring', 'Powerful heart-themed ring', 79.99, 'WarriorCrafts', 'White', 'RoseGold', 'Ring', 'one-size', 60, 'ring25.jpg'),                                 -- 35
    ('Spear Collection Bracelet', 'Mighty spear-themed bracelet', 49.99, 'AdventurousDesigns', 'Clear', 'Silver', 'Bracelet', 'one-size', 40, 'bracelet26.jpg'),                -- 36
    ('Spear Collection Necklace', 'Sapphire oval-shaped necklace', 99.99, 'HeartJewels', 'Sapphire', 'Silver', 'Necklace', 'one-size', 25, 'necklace27.jpg'),                   -- 37
    ('Monarchy Collection Earring', 'Intense square-shaped earring', 34.99, 'GlamourGems', 'Clear', 'Silver', 'Earring', 'one-size', 80, 'earring28.jpg'),                      -- 38
    ('Heart Collection Ring', 'Ruby heart-themed ring', 59.99, 'HeartGems', 'Ruby', 'Silver', 'Ring', 'one-size', 50, 'ring29.jpg'),                                            -- 39
    ('Spear Collection Bracelet', 'Vibrant spear-themed bracelet', 44.99, 'AdventurousDesigns', 'Yellow', 'Gold', 'Bracelet', 'one-size', 35, 'bracelet30.jpg'),                -- 40
    ('Nature Collection Necklace', 'Elegant butterfly-themed necklace', 89.99, 'NatureMotif', 'Clear', 'Silver', 'Necklace', 'one-size', 20, 'necklace31.jpg'),                 -- 41
    ('Spear Collection Earring', 'Dynamic feather-themed earring', 37.99, 'NatureMotif', 'Clear', 'RoseGold', 'Earring', 'one-size', 90, 'earring32.jpg'),                      -- 42
    ('Spear Collection Ring', 'Glamorous spear-themed ring', 74.99, 'WarriorCrafts', 'Clear', 'Gold', 'Ring', 'one-size', 45, 'ring33.jpg'),                                    -- 43
    ('Spear Collection Bracelet', 'Sculpted spear-themed bracelet', 54.99, 'AdventurousDesigns', 'Yellow', 'Gold', 'Bracelet', 'one-size', 30, 'bracelet34.jpg'),               -- 44
    ('Celestial Collection Necklace', 'Half-Moon necklace', 94.99, 'DiamondCrafters', 'Clear', 'Silver', 'Necklace', 'one-size', 15, 'necklace35.jpg'),                         -- 45
    ('Spear Collection Earring', 'Graceful double-circle earring', 31.99, 'BattleGems', 'Clear', 'Silver', 'Earring', 'one-size', 110, 'earring36.jpg'),                        -- 46
    ('Spear Collection Ring', 'Elegant ruby ring', 64.99, 'WarriorCrafts', 'Ruby', 'Silver', 'Ring', 'one-size', 40, 'ring37.jpg'),                                             -- 47      
    ('Monarchy Collection Bracelet', 'Tennis royal-themed bracelet', 42.99, 'LuxuryGems', 'Yellow', 'Gold', 'Bracelet', 'one-size', 25, 'bracelet38.jpg'),                      -- 48
    ('Spear Collection Necklace', 'Elegant double-circle necklace', 84.99, 'CombatJewels', 'Golden', 'Silver', 'Necklace', 'one-size', 10, 'necklace39.jpg'),                   -- 49
    ('Spear Collection Earring', 'Sleek diamond-shaped earring', 27.99, 'LuxuryGems', 'Clear', 'Silver', 'Earring', 'one-size', 120, 'earring40.jpg'),                          -- 50
    ('Heart Collection Ring', 'Double heart-themed ring', 599.99, 'HeartJewels', 'Clear', 'Silver', 'Ring', 'one-size', 70, 'ring41.jpg'),                                      -- 51 
    ('Heart Collection Bracelet', 'Double heart-themed bracelet', 394.99, 'MetalWorks', 'Rose', 'RoseGold', 'Bracelet', 'one-size', 50, 'bracelet3.jpg'),                       -- 52
    ('Industrial Collection Necklace', 'Star industrial-themed necklace', 794.99, 'TechStyle', 'Clear', 'Silver', 'Necklace', 'one-size', 30, 'necklace45.jpg'),                -- 53
    ('Industrial Collection Earring', 'Innovative industrial-themed earring', 299.99, 'InnovateDesigns', 'Sapphire', 'Silver', 'Earring', 'one-size', 100, 'earring41.jpg'),    -- 54
    ('Industrial Collection Ring', 'Durable industrial-themed ring', 699.99, 'MetalMasters', 'Green', 'Silver', 'Ring', 'one-size', 60, 'ring42.jpg'),                          -- 55
    ('Venus Ring', 'Ruby Venus-themed ring', 899.99, 'CelestialJewels', 'Ruby', 'Silver', 'Ring', 'one-size', 80, 'venus_ring1.jpg'),                                           -- 56
    ('Venus Bracelet', 'Chic Venus-themed bracelet', 599.99, 'StarGazers', 'Clear', 'Silver', 'Bracelet', 'one-size', 60, 'venus_bracelet2.jpg'),                               -- 57
    ('Venus Necklace', 'Graceful Venus-themed necklace', 1299.99, 'CosmicCrafts', 'Clear', 'Silver', 'Necklace', 'one-size', 30, 'venus_necklace3.jpg'),                        -- 58
    ('Venus Earring', 'Stylish Venus-themed earring', 4999.99, 'GalacticGems', 'Clear', 'Gold', 'Earring', 'one-size', 120, 'venus_earring4.jpg'),                              -- 59   
    ('Venus Ring', 'Clover Venus-themed ring', 999.99, 'HeavenlyDesigns', 'Clear', 'Silver', 'Ring', 'one-size', 70, 'venus_ring5.jpg'),                                        -- 60
    ('Venus Bracelet', 'Trendy Venus-themed bracelet', 799.99, 'OrbitJewelry', 'Clear', 'Gold', 'Bracelet', 'one-size', 45, 'venus_bracelet6.jpg'),                             -- 61
    ('Venus Necklace', 'Enchanting Venus-themed necklace', 1499.99, 'GalaxyGems', 'Clear', 'Gold', 'Necklace', 'one-size', 20, 'venus_necklace7.jpg'),                          -- 62
    ('Venus Earring', 'Elegant Venus-themed earring', 599.99, 'StellarStyles', 'Clear', 'Gold', 'Earring', 'one-size', 100, 'venus_earring8.jpg'),                              -- 63
    ('Venus Ring', 'Heart Venus-themed ring', 1199.99, 'HeartJewels', 'Clear', 'Silver', 'Ring', 'one-size', 60, 'venus_ring9.jpg'),                                            -- 64
    ('Venus Bracelet', 'Charming Venus-themed bracelet', 899.99, 'StarGazers', 'Silver', 'Silver', 'Bracelet', 'one-size', 35, 'venus_bracelet10.jpg'),                         -- 65
    ('Venus Necklace', 'Luxurious Venus-themed necklace', 1799.99, 'CosmicCrafts', 'Yellow', 'Gold', 'Necklace', 'one-size', 15, 'venus_necklace11.jpg'),                       -- 66        
    ('Venus Earring', 'Sophisticated Venus-themed earring', 699.99, 'GalacticGems', 'Yellow', 'Gold', 'Earring', 'one-size', 90, 'venus_earring12.jpg'),                        -- 67
    ('Venus Ring', 'Classy Venus-themed ring', 1099.99, 'HeavenlyDesigns', 'Clear', 'Gold', 'Ring', 'one-size', 50, 'venus_ring13.jpg'),                                        -- 68
    ('Venus Bracelet', 'Modern Venus-themed bracelet', 9999.99, 'OrbitJewelry', 'Clear', 'Gold', 'Bracelet', 'one-size', 25, 'venus_bracelet14.jpg'),                           -- 69
    ('Venus Necklace', 'Radiant Venus-themed necklace', 1599.99, 'GalaxyGems', 'Clear', 'Gold', 'Necklace', 'one-size', 10, 'venus_necklace15.jpg');                            -- 70

-- Insert values into the ORDER table (only client's sample data)
INSERT INTO ORDERS (TOTAL_PRICE, ORDER_DATE, ORDER_STATUS, EXPECTED_DELIVERY, USER_ID) VALUES
    (1599.98, '2023-10-20', 'Processed', '2023-10-25', 1), -- John Doe's order id#1
    (399.99, '2023-10-19', 'Shipped', '2023-10-24', 4), -- Bob Brown's order id#2
    (1199.97, '2023-10-18', 'Delivered', '2023-10-23', 5), -- Eva Williams'order id#3
    (799.98, '2023-11-08', 'Shipped', '2023-11-11', 1),    -- John Doe's order id#4
    (799.98, '2023-11-01', 'Delivered', '2023-11-06', 1),  -- John Doe's order id#5
    (1599.98, '2023-11-08', 'Shipped', '2023-11-11', 1),    -- John Doe's order id#6
    (599.97, '2023-11-09', 'Processed', '2023-11-12', 1);  -- John Doe's order id#7

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
