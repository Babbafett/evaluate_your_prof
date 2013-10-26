use db_evaluate_your_prof;

Insert into t_university(u_name,u_city,u_country) values('u_test_name','u_test_city','u_test_country');
Insert into t_course(c_name,c_credits,c_university,c_token) values('c_test_name',2,1,'te');
Insert into t_prof(p_lastname,p_forname,p_token) values('p_test_lastname','p_test_forname','te');
Insert into t_evaluation(e_course,e_prof,e_overall,e_contentual,e_eloquence,e_motivation_prof,e_motivation_before,e_motivation_after,e_test_requirement,e_media_usage,e_soft_skills,e_hot,e_comment_positive,e_comment_negative,e_comment) values(1,1,10,10,10,10,10,10,10,10,10,1,'test_positive','test_negative','test');
Insert into t_evaluation(e_course,e_prof,e_overall,e_contentual,e_eloquence,e_motivation_prof,e_motivation_before,e_motivation_after,e_test_requirement,e_media_usage,e_soft_skills,e_hot,e_comment_positive,e_comment_negative,e_comment) values(1,1,1,1,1,1,1,1,1,1,1,2,'test_positive','test_negative','test');
Insert into t_prof_course(c_id,p_id) values(1,1);
Insert into t_TAN(t_course,t_prof,t_tan) values(1,1,'te123456te');