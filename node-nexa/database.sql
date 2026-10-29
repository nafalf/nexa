CREATE DATABASE IF NOT EXISTS nexa; USE nexa;
CREATE TABLE users(id INT AUTO_INCREMENT PRIMARY KEY,name VARCHAR(100),email VARCHAR(150) UNIQUE,password VARCHAR(255),role ENUM('customer','admin') DEFAULT 'customer');
CREATE TABLE accounts(id INT AUTO_INCREMENT PRIMARY KEY,user_id INT,number VARCHAR(30),balance DECIMAL(15,2) DEFAULT 0,FOREIGN KEY(user_id) REFERENCES users(id));
CREATE TABLE beneficiaries(id INT AUTO_INCREMENT PRIMARY KEY,user_id INT,name VARCHAR(100),bank VARCHAR(80),number VARCHAR(30),FOREIGN KEY(user_id) REFERENCES users(id));
CREATE TABLE transactions(id INT AUTO_INCREMENT PRIMARY KEY,user_id INT,account_id INT,beneficiary_id INT NULL,type VARCHAR(20),amount DECIMAL(15,2),description VARCHAR(255),status VARCHAR(30) DEFAULT 'success',created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,FOREIGN KEY(user_id) REFERENCES users(id));
INSERT INTO users(name,email,password,role) VALUES ('Ardi Pratama','demo@nexa.id','$2a$10$/Lnwz7cIMVPR15wW0JbUS.LDaK6M4D6Tkj1oOdVgpDAJNmn8Bfvmm','customer'),('Admin Nexa','admin@nexa.id','$2a$10$/Lnwz7cIMVPR15wW0JbUS.LDaK6M4D6Tkj1oOdVgpDAJNmn8Bfvmm','admin');
INSERT INTO accounts(user_id,number,balance) VALUES (1,'0223383830',28000000);
INSERT INTO beneficiaries(user_id,name,bank,number) VALUES (1,'Yogie','Nexa Bank','0102030405'),(1,'Putri','Nexa Bank','0504030201');
