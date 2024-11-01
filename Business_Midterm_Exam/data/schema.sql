CREATE TABLE designers_info (
    designerID INT AUTO_INCREMENT PRIMARY KEY,
    firstName VARCHAR (32),
    lastName VARCHAR (32),
    d_address VARCHAR (64),
    age INT CHECK (age >= 18),
    specialization VARCHAR (128),
    e_address VARCHAR (64),
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE designs (
    designID INT AUTO_INCREMENT PRIMARY KEY,
    designName VARCHAR (128),
    fabricType VARCHAR (128),
    price DECIMAl (10,2) CHECk (price >= 0),
    designerID INT,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE designer_account (
        userID INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR (64),
        user_password VARCHAR (64)
);

CREATE TABLE designer_logs (
    logs_id INT AUTO_INCREMENT PRIMARY KEY,
    logsDescription VARCHAR (255),
    designerID INT,
    designID INT,
    doneBy INT,
    dateLogged TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);