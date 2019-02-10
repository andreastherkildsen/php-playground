//Persons table - first creation 08/02/19
CREATE TABLE Persons  (
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    firstname varchar(250),
    lastname varchar(250),
    city varchar(250),
    zip int
);

//Order table - first creation 08/02/19
CREATE TABLE Orders (
   order_id int NOT NULL PRIMARY KEY AUTO_INCREMENT, 
   order_no int NOT NULL, 
   person_id int, 
   FOREIGN KEY (person_id) REFERENCES Persons(id)
   ON DELETE CASCADE
 );

//Product table - first creation 10/02/19
CREATE TABLE Products (
   product_id int NOT NULL PRIMARY KEY AUTO_INCREMENT, 
   productname varchar(50) NOT NULL
 );

ALTER TABLE Orders (
  ADD order_info varchar(255);
);

//Create indexes for faster iteration
CREATE INDEX idx_pid
ON Persons (id);
//Create indexes for faster iteration
CREATE INDEX idx_oid
ON Orders (order_id);

//DB NOTES
Persons -> Orders (1:N);