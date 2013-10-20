drop database db_evaluate_your_prof;
create database if not exists db_evaluate_your_prof;

use db_evaluate_your_prof;

create table if not exists t_prof
(
	p_id int not null auto_increment,
	p_lastname varchar(30),
	p_forname varchar(30),
	p_token varchar(2),
	primary key(p_id)
);

create table if not exists t_university
(
	u_id int not null auto_increment,
	u_name varchar(60),
	u_city varchar(60),
	u_country varchar(60),
	primary key(u_id) 
);

create table if not exists t_course
(
	c_id int not null auto_increment,
	c_name varchar(60),
	c_credits tinyint,
	c_university int,
	c_token varchar(2),
	primary key(c_id),
	foreign key(c_university) references t_university(u_id) on update cascade on delete cascade
);

create table if not exists t_prof_course
(
	pc_id int not null auto_increment,
	c_id int not null,
	p_id int not null,
	primary key(pc_id),
	foreign key(c_id) references t_course(c_id) on update cascade on delete cascade,
	foreign key(p_id) references t_prof(p_id) on update cascade on delete cascade
);

create table if not exists t_TAN
(
	t_id varchar(10) not null,
	t_course int not null,
	t_prof int not null,
	primary key(t_id),
	foreign key(t_course) references t_course(c_id) on update cascade on delete cascade,
	foreign key(t_prof) references t_prof(p_id) on update cascade on delete cascade
);

create table if not exists t_evaluation
(
	e_id int not null auto_increment,
	e_course int,
	e_prof int,
	e_overall enum('1','2','3','4','5','6','7','8','9','10'),
	e_conentual enum('1','2','3','4','5','6','7','8','9','10'),
	e_eloquence enum('1','2','3','4','5','6','7','8','9','10'),
	e_motivation enum('1','2','3','4','5','6','7','8','9','10'),
	e_test_requirement enum('1','2','3','4','5','6','7','8','9','10'),
	e_media_usage enum('1','2','3','4','5','6','7','8','9','10'),
	e_soft_skills enum('1','2','3','4','5','6','7','8','9','10'),
	e_hot enum('1','2'),
	primary key(e_id),
	foreign key(e_course) references t_course(c_id) on update cascade on delete cascade,
	foreign key(e_prof) references t_prof(p_id) on update cascade on delete cascade
);
