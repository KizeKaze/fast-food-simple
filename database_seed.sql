create table item
(
    id int auto_increment,
    name varchar(255) not null,
    description text null,
    cost decimal(11,2) null,
    type_id int not null,
    constraint item_pk
        primary key (id)
);

create table type
(
    type_id int auto_increment,
    type varchar(255) null,
    constraint type_pk
        primary key (type_id)
);

