CREATE DATABASE IF NOT EXISTS rspro CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE rspro;
DROP TABLE IF EXISTS datasheet_prodotti_simili;
DROP TABLE IF EXISTS datasheet_specifiche;
DROP TABLE IF EXISTS datasheet_prodotti;
CREATE TABLE datasheet_prodotti (
    id INT AUTO_INCREMENT PRIMARY KEY,
    family_name VARCHAR(255) NOT NULL,
    rs_stock_no VARCHAR(50) NOT NULL,
    product_name VARCHAR(255) NOT NULL,
    product_description TEXT,
    product_image VARCHAR(255),
    diagram_image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uk_rs_stock_no (rs_stock_no)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE datasheet_specifiche (
    id INT AUTO_INCREMENT PRIMARY KEY,
    prodotto_id INT NOT NULL,
    sezione VARCHAR(100) NOT NULL,
    sezione_ordinamento INT NOT NULL DEFAULT 0,
    attributo VARCHAR(255) NOT NULL,
    valore TEXT,
    ordinamento INT NOT NULL DEFAULT 0,
    CONSTRAINT fk_specifiche_prodotto FOREIGN KEY (prodotto_id) REFERENCES datasheet_prodotti(id) ON DELETE CASCADE ON UPDATE CASCADE,
    INDEX idx_specifiche_prodotto (prodotto_id),
    INDEX idx_specifiche_sezione (sezione, sezione_ordinamento, ordinamento)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE datasheet_prodotti_simili (
    id INT AUTO_INCREMENT PRIMARY KEY,
    prodotto_id INT NOT NULL,
    stock_no VARCHAR(50),
    brand VARCHAR(100),
    product_name VARCHAR(255),
    attribute_1 VARCHAR(255),
    attribute_2 VARCHAR(255),
    attribute_3 VARCHAR(255),
    ordinamento INT NOT NULL DEFAULT 0,
    CONSTRAINT fk_simili_prodotto FOREIGN KEY (prodotto_id) REFERENCES datasheet_prodotti(id) ON DELETE CASCADE ON UPDATE CASCADE,
    INDEX idx_simili_prodotto (prodotto_id, ordinamento)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
INSERT INTO datasheet_prodotti (family_name, rs_stock_no, product_name, product_description, product_image, diagram_image) VALUES ('RS PRO Family Name', '123-4567', 'Test Product', 'Please introduce the product with relevant details stating:\n• What are the products used for?\n• Applications they are most suited for or not suited for\n• What are they used with etc', '', '');
INSERT INTO datasheet_specifiche (prodotto_id, sezione, sezione_ordinamento, attributo, valore, ordinamento) VALUES
(1, 'Features', 10, 'Feature 1', 'High quality professional component', 10),
(1, 'Features', 10, 'Feature 2', 'Suitable for industrial applications', 20),
(1, 'Features', 10, 'Feature 3', 'Comparable quality to leading brands', 30),
(1, 'Features', 10, 'Feature 4', 'Professionally approved range', 40),
(1, 'Features', 10, 'Feature 5', 'Tested by engineers', 50),
(1, 'General Specifications', 30, 'Material', '', 10),
(1, 'Mechanical Specifications', 40, 'Mounting Type', '', 10),
(1, 'Electrical Specifications', 50, 'Voltage Rating', '', 10),
(1, 'Protection Category', 60, 'IP Rating', '', 10),
(1, 'Classification', 70, 'eCl@ss (Version)', '', 10),
(1, 'Classification', 70, 'UNSPSC (Version)', '', 20),
(1, 'Approvals', 80, 'Declarations', 'MFR Declaration of Conformity', 10),
(1, 'Approvals', 80, 'Hazardous Area Certification', 'ATEX / IECEx', 20),
(1, 'Approvals', 80, 'Standards Met', 'VDE', 30);
INSERT INTO datasheet_prodotti_simili (prodotto_id, stock_no, brand, product_name, attribute_1, attribute_2, attribute_3, ordinamento) VALUES
(1, 'XXX-XXXX', 'RS PRO', '', '', '', '', 10),
(1, 'XXX-XXXX', 'RS PRO', '', '', '', '', 20);
