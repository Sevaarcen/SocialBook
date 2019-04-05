DROP DATABASE IF EXISTS SocialBook_DB;
CREATE DATABASE SocialBook_DB;

USE SocialBook_DB;

CREATE TABLE Users (
	id int NOT NULL AUTO_INCREMENT,
    admin boolean NOT NULL,
    username varchar(32) NOT NULL,
    password char(32) NOT NULL,
    first_name varchar(48) NOT NULL,
    last_name varchar(64) NOT NULL,
    email varchar(132) NOT NULL,
    phone char(12) NOT NULL,
    birthdate date NOT NULL,
    profile_picture varchar(256) NULL,
    PRIMARY KEY (id),
    UNIQUE KEY (username)
);

CREATE TABLE Posts (
	id int NOT NULL AUTO_INCREMENT,
    posted_on datetime NOT NULL,
    posted_by varchar(32) NOT NULL,
    content varchar(256) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (posted_by) REFERENCES Users(username)
		ON DELETE CASCADE
);

INSERT INTO Users (admin, username, password, first_name, last_name, email, phone, birthdate, profile_picture) VALUES (true, "admin", md5("c0nn3ction$"), "admin", "istrator", "admin@socialbook.hoard", "555-987-1234", "1970-01-01", "pictures/admin_meme.png");
INSERT INTO Users (admin, username, password, first_name, last_name, email, phone, birthdate, profile_picture) VALUES (true, "the_zuck", md5("l1zz4ardm4n"), "Marko", "Zuckerbergo", "marko@socialbook.hoard", "555-543-4800", "1984-05-14", "pictures/the_zuck_profilepic.jpg");

INSERT INTO Posts (posted_on, posted_by, content) VALUES ("2017-06-30 09:13:01", "admin", "Welcome to SocialBook! For the record we don't sell your data. Privacy is our main concern! Please share your intimate life stories with everyone!");
INSERT INTO Posts (posted_on, posted_by, content) VALUES ("2018-03-19 17:08:29", "the_zuck", "Lol! People actually trust us!?");
