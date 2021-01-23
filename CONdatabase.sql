-- Authors: Judy MEZABER, Omar SALAHDDINE, Rezza-Zairan Zaharin
-- Database creator
-- create database CON;

-- use CON;

-- Members' table constructor
create table Members(
	ID int NOT NULL AUTO_INCREMENT,
	Passsword varchar(20) NOT NULL,
    username varchar(50) NOT NULL,
	FirstName varchar(20),
	LastName varchar(20),
	Email varchar(50),
	Address varchar(50),
	AdminRights enum('0','1'),
	Status enum('0','1'),
	PRIMARY KEY(ID)
);


-- Groups' table constructor
create table Groups_(
	GroupID int NOT NULL AUTO_INCREMENT,
	GroupName varchar(50),
	OwnerID int,
	Description tinytext, -- Holds a string of max length 255 char
	MemberID int,
	PRIMARY KEY(GroupID),
	FOREIGN KEY(MemberID) REFERENCES Members(ID),
	FOREIGN KEY(OwnerID) REFERENCES Members(ID)
);

-- Connection's table constructor
create table Connections(
	ID int,
	RoleCode varchar(20),
	PRIMARY KEY(ID)
);

-- Role's table constructor
create table Role(
	RoleCode varchar(20),
	RoleDescription varchar(20)
);

create table pm(
	mID int NOT NULL AUTO_INCREMENT,
	to_ID int NOT NULL,
	from_ID int NOT NULL,
	time_sent datetime NOT NULL,
	subject varchar(60) NOT NULL,
	message text NOT NULL,
	opened enum('0','1') NOT NULL,
	to_delete enum('0','1') NOT NULL,
	from_delete enum('0','1') NOT NULL,
	PRIMARY KEY(mID),
	FOREIGN KEY(to_ID) REFERENCES Members(ID),
	FOREIGN KEY(from_ID) REFERENCES Members(ID)
);

-- Posts Database
create table posts(
	id int(11),
	username varchar(255),
    body text,
    date_added timestamp,
    hashtags text
);

-- Table for Images
CREATE TABLE images (
  id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  name varchar(200) NOT NULL,
  image longtext NOT NULL
); 

-- Table for comments
CREATE TABLE comments (
	id int(11) NOT NULL AUTO_INCREMENT,
	page_id int(11) NOT NULL,
	parent_id int(11) NOT NULL DEFAULT '-1',
	name varchar(255) NOT NULL,
	content text NOT NULL,
	submit_date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (id)
);

INSERT INTO `members` 
(`ID`, `Passsword`, `username`, `FirstName`, `LastName`, `Email`, `Address`, `AdminRights`, `Status`) 
VALUES 
('1', '123', 'admin', 'admin', 'admin', 'NOTSET', 'NOTSET', '1', '1');
