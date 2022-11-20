CREATE DATABASE smartphone_store DEFAULT CHARACTER SET UTF8MB4 COLLATE UTF8MB4_UNICODE_CI;

use smartphone_store;

create table `admin_account` (
	`id` varchar(12) not null,
    `email` varchar(100) not null unique,
    `password` varchar(100) not null,
    `fullname` varchar(150) not null default false,
    `phone` varchar(15) not null default false,
    `active` boolean not null default true,
    created_at timestamp not null default current_timestamp,
    updated_at timestamp not null default current_timestamp on update current_timestamp,
    constraint pk_account primary key (`id`)
);


select * from `admin_account`