USE sql_sqa_project;

INSERT INTO customers (customer_id, first_name, last_name, age, country) VALUES
(1,'John','Doe',31,'USA'),
(2,'Robert','Luna',22,'USA'),
(3,'David','Robinson',22,'UK'),
(4,'John','Reinhardt',25,'UK'),
(5,'Betty','Doe',28,'UAE'),
(6,'Sarah','Khan',29,'USA'),
(7,'Michael',NULL,34,'UK'),
(8,'Nadia','Rahman',24,'UAE'),
(9,'Alex','Smith',27,'USA'),
(10,'Emma','Jones',21,'Canada');

INSERT INTO orders (order_id,item,amount,customer_id) VALUES
(1,'Keyboard',400,4),
(2,'Mouse',300,4),
(3,'Monitor',12000,3),
(4,'Keyboard',400,1),
(5,'Mousepad',250,2),
(6,'Webcam',800,6),
(7,'Headset',600,9),
(8,'USB Hub',350,8),
(9,'Laptop Stand',450,1),
(10,'Mouse',300,2),
(11,'Monitor',900,6),
(12,'Keyboard',500,9),
(13,'Chair',1500,3),
(14,'Desk Lamp',200,8),
(15,'SSD',1100,10);

-- A few intentionally inconsistent records are included for SQA exercises.
INSERT INTO shippings (shipping_id,status,customer,order_id) VALUES
(1,'Pending',2,5),
(2,'Pending',4,1),
(3,'Delivered',3,3),
(4,'Pending',5,NULL),
(5,'Delivered',1,4),
(6,'Delivered',6,6),
(7,'Pending',9,7),
(8,'Delivered',8,8),
(9,'Delivered',2,10),
(10,'Delivered',1,9),
(11,'Delivered',5,NULL),
(12,'Pending',3,13),
(13,'Delivered',7,NULL),
(14,'Pending',10,15),
(15,'Pending',2,4);
