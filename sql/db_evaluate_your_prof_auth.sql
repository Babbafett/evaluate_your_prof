drop database db_evaluate_your_prof_auth;
create database db_evaluate_your_prof_auth;

use db_evaluate_your_prof_auth;

create table if not exists t_auth
(
	a_id int not null auto_increment,
	a_username varchar(10),
	a_password varchar(20),
	primary key(a_id)
);
