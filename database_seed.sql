CREATE DATABASE IF NOT EXISTS fast_food;
USE fast_food;

create table item
(
    id          int auto_increment
        primary key,
    name        varchar(255)                           not null,
    description text                                   null,
    cost        decimal(11, 2)                         null,
    type_id     int                                    not null,
    image       varchar(255) default 'coming-soon.jpg' null
);


INSERT INTO fast_food.item (name, description, cost, type_id) VALUES ('Carrots', '1 Baby carrots in a bag', 1.99, 2);
INSERT INTO fast_food.item (name, description, cost, type_id) VALUES ('Apple', 'An Apple', 0.50, 1);
INSERT INTO fast_food.item (name, description, cost, type_id) VALUES ('WaterMelon', 'A juicy watermelon, only the best', 2.59, 1);
INSERT INTO fast_food.item (name, description, cost, type_id) VALUES ('Coke 12 pack', '12 pack of tasty coke', 5.99, 8);
INSERT INTO fast_food.item (name, description, cost, type_id) VALUES ('Mt Dew 12 pack', '12 pack of Mt Dew', 5.99, 8);
INSERT INTO fast_food.item (name, description, cost, type_id) VALUES ('Eggs', 'a dozen eggs', 0.99, 7);
INSERT INTO fast_food.item (name, description, cost, type_id) VALUES ('Chicken Breast', '4 juicy chicken breast', 7.99, 3);
INSERT INTO fast_food.item (name, description, cost, type_id) VALUES ('ground beef', '1 pound of ground beef', 4.99, 4);
INSERT INTO fast_food.item (name, description, cost, type_id) VALUES ('Crab legs', 'Crab legs of the sea', 3.99, 5);
INSERT INTO fast_food.item (name, description, cost, type_id) VALUES ('Coffee', '942 MG of caffeine', 0.70, 9);
INSERT INTO fast_food.item (name, description, cost, type_id) VALUES ('Creamer', 'tasty sauce for the coffee', 2.99, 9);
INSERT INTO fast_food.item (name, description, cost, type_id) VALUES ('dr pepper', '23 flavors in one can', 2.99, 8);
INSERT INTO fast_food.item (name, description, cost, type_id) VALUES ('choc milk', 'the richest', 150.34, 6);
INSERT INTO fast_food.item (name, description, cost, type_id) VALUES ('Baby formula', 'dry powder formula made with real milk', 17.99, 6);

CREATE TABLE type
(
    type_id int AUTO_INCREMENT,
    type    varchar(255) NULL,
    CONSTRAINT type_pk
        PRIMARY KEY (type_id)
);

INSERT INTO fast_food.type (type) VALUES ('Fruits');
INSERT INTO fast_food.type (type) VALUES ('Vegetable');
INSERT INTO fast_food.type (type) VALUES ('Poultry');
INSERT INTO fast_food.type (type) VALUES ('Meat');
INSERT INTO fast_food.type (type) VALUES ('Fish');
INSERT INTO fast_food.type (type) VALUES ('Dairy');
INSERT INTO fast_food.type (type) VALUES ('Eggs');
INSERT INTO fast_food.type (type) VALUES ('Drink');
INSERT INTO fast_food.type (type) VALUES ('Coffee');


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
    user_role     int default 0 not null
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
    grand_total    decimal(11,2) not null
);

create table order_item
(
    order_id  int          not null,
    user_id   int          not null,
    item_id   int          not null,
    item_name varchar(255) not null,
    cost      decimal(11,2) not null,
    qty       int          not null,
    primary key (order_id, user_id, item_id)
);

create table password_resets
(
    id                  int auto_increment
        primary key,
    email               varchar(255)         null,
    token               varchar(255)         null,
    expired_token       tinyint(1) default 0 not null,
    timed_expired_token datetime             null,
    constraint password_resets_token_uindex
        unique (token)
);


