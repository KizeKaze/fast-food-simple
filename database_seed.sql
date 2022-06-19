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

INSERT INTO fast_food.type (type)
VALUES ('Food');

INSERT INTO fast_food.type (type)
VALUES ('Drink');

INSERT INTO fast_food.type (type)
VALUES ('Dessert');

create table fast_food.users
(
    user_id       int(10) auto_increment
        primary key,
    username      varchar(255)  null,
    email         varchar(255)  null,
    password      varchar(255)  null,
    user_role     int default 0 not null,
    user_acc_date date          null
);

create table cart
(
    user_id int not null,
    item_id int not null,
    qty int not null,
    constraint cart_pk
    primary key (user_id, item_id)
);

create table order_complete
(
    order_id       int auto_increment
        primary key,
    user_id        int          not null,
    date_purchased date         not null,
    grand_total    float(11, 2) not null
);

create table order_item
(
    order_id  int          not null,
    user_id   int          not null,
    item_id   int          not null,
    item_name varchar(255) not null,
    cost      int          not null,
    qty       int          not null,
    primary key (order_id, user_id, item_id)
);

