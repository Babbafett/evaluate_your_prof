drop database db_evaluate_your_prof;
create database if not exists db_evaluate_your_prof;

use db_evaluate_your_prof;

create table if not exists t_prof
(
	p_id int not null auto_increment,
	p_title varchar(30),
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
	t_id int not null auto_increment,
	t_course int not null,
	t_prof int not null,
	t_tan varchar(10) not null,
	primary key(t_id, t_tan),
	foreign key(t_course) references t_course(c_id) on update cascade on delete cascade,
	foreign key(t_prof) references t_prof(p_id) on update cascade on delete cascade
);

create table if not exists t_evaluation
(
	e_id int not null auto_increment,
	e_course int,
	e_prof int,
	e_overall enum('1','2','3','4','5','6','7'),
	e_contentual enum('1','2','3','4','5','6','7'),
	e_competence enum('1','2','3','4','5','6','7'),
	e_eloquence enum('1','2','3','4','5','6','7'),
	e_motivation_prof enum('1','2','3','4','5','6','7'),
	e_motivation_before enum('1','2','3','4','5','6','7'),
	e_motivation_after enum('1','2','3','4','5','6','7'),
	e_test_requirement enum('1','2','3','4','5','6','7'),
	e_media_usage enum('1','2','3','4','5','6','7'),
	e_soft_skills enum('1','2','3','4','5','6','7'),
	e_hot enum('1','2'),
	e_comment_positive varchar(300),
	e_comment_negative varchar(300),
	e_comment varchar(300),
	primary key(e_id),
	foreign key(e_course) references t_course(c_id) on update cascade on delete cascade,
	foreign key(e_prof) references t_prof(p_id) on update cascade on delete cascade
);
