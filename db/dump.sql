DROP DATABASE fh_shoppinglist;
CREATE DATABASE fh_shoppinglist;
USE fh_shoppinglist;

CREATE TABLE article (
	id int(11) NOT NULL AUTO_INCREMENT,
	listId int(11) NOT NULL,
	title varchar(50) NOT NULL,
	description varchar(255) NOT NULL,
	state int NOT NULL,
	PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=1 CHARSET=utf8;;

CREATE TABLE list (
	id int(11) NOT NULL AUTO_INCREMENT,
	userId int(11) NOT NULL,
	title varchar(30) NOT NULL,
	description varchar(255) NOT NULL,
	state int NOT NULL,
	numberOfArticles int NOT NULL,
	finishedArticles int NOT NULL,
	PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=1 CHARSET=utf8;;

CREATE TABLE user (
	id int(11) NOT NULL AUTO_INCREMENT,
	username varchar(255) NOT NULL,
	password char(255) NOT NULL,
	PRIMARY KEY (id),
	UNIQUE KEY (username)
) ENGINE=InnoDB AUTO_INCREMENT=1 CHARSET=utf8;;

CREATE TABLE audit (
	id int(11) NOT NULL AUTO_INCREMENT,
	username varchar(255) NOT NULL,
	action varchar(255) NOT NULL,
	ip varchar(255) NOT NULL,
	userAgent varchar(255) NOT NULL,
	created_at int NOT NULL,
	PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=1 CHARSET=utf8;;

ALTER TABLE article
ADD CONSTRAINT article_fk_1 FOREIGN KEY (listId) REFERENCES list (id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE list
ADD CONSTRAINT list_fk_1 FOREIGN KEY (userId) REFERENCES user (id) ON DELETE CASCADE ON UPDATE CASCADE;