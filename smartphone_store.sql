CREATE DATABASE smartphone_store DEFAULT CHARACTER SET UTF8MB4 COLLATE UTF8MB4_UNICODE_CI;

use smartphone_store;

create table `account` (
	`id` varchar(12) not null,
    `email` varchar(100) not null unique,
    `password` varchar(100) not null,
    `active` boolean not null default true,
    created_at timestamp not null default current_timestamp,
    updated_at timestamp not null default current_timestamp on update current_timestamp,
    constraint pk_account primary key (`id`)
);

create table `admin` (
	`id` varchar(12) not null,
    `full_name` varchar(200) not null,
    `phone` varchar(15) not null,
    `account_id` varchar(12) not null,
    created_at timestamp not null default current_timestamp,
    updated_at timestamp not null default current_timestamp on update current_timestamp,
    constraint pk_admin primary key (`id`),
    constraint fk_admin
		foreign key (`account_id`) references `account`(`id`)
);

select * from `account`;
select * from `admin`;
delete from `account` where id = '1916119505'