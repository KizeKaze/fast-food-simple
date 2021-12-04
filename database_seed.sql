CREATE DATABASE IF NOT EXISTS fast_food;
USE fast_food;

CREATE TABLE item
(
    id          int AUTO_INCREMENT,
    name        varchar(255)   NOT NULL,
    description text           NULL,
    cost        decimal(11, 2) NULL,
    type_id     int            NOT NULL,
    CONSTRAINT item_pk
        PRIMARY KEY (id)
);

CREATE TABLE type
(
    type_id int AUTO_INCREMENT,
    type    varchar(255) NULL,
    CONSTRAINT type_pk
        PRIMARY KEY (type_id)
);

