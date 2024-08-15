CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product VARCHAR(50),
    quantity INT,
    total_price DECIMAL(10, 2)
);
