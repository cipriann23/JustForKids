drop table TW_Kid
/
drop table TW_Login
/
drop table TW_Answers
/
drop table TW_Test
/
Create Table TW_Kid(
Id Integer Primary Key,
Parent_id Integer,
Age Integer
)
/

Create Table TW_Login
(
Id Integer Primary Key,
Username Varchar2(20),
First_Name Varchar2(20),
Last_Name Varchar2(20),
Password  Varchar2(20),
User_Type Integer,
Email Varchar2(30),
City Varchar2(20),
Country Varchar2(20)
)
/
Create Table TW_Test
(
Id Integer,
Category Number(4),
Dificulty number(1),
Id_question Number(4),
Text_intrebare Varchar2(300),
var1 Varchar2(40),
var2 Varchar2(40),
var3 Varchar2(40),
var4 Varchar2(40),
var_corecta number(1)
)
/
Create Table TW_Answers(
id_kid Integer,
id_test integer,
id_intrebare integer,
answer varchar(40),
solved number(1),
data TIMESTAMP
)
/
Create Table TW_checkpoint(
id_kid integer,
id_test integer,
id_intrebare integer,
category integer
)
/
INSERT into tw_login values(0,'admin',null,null,'admin',2,'nemtocciprian10@gmail.com',null,null);
INSERT into tw_login values(3,'Andrei','Popescu','Andrei','popescu',0,null,null,null);
INSERT into tw_login values(4,'Costel','Popescu','Costel','popescu',0,null,null,null);
INSERT into tw_login values(2,'parent','Popescu','Marghioala','parent',1,'nem.ciprian@yahoo.com','Iasi','Romania');
/
INSERT into TW_CHECKPOINT values(3,1,1,0);
INSERT into TW_CHECKPOINT values(3,1,1,1);
INSERT into TW_CHECKPOINT values(3,1,1,2);

INSERT into TW_CHECKPOINT values(4,1,1,0);
INSERT into TW_CHECKPOINT values(4,1,1,1);
INSERT into TW_CHECKPOINT values(4,1,1,2);


INSERT into TW_kid values(3,2,7);
INSERT into TW_kid values(4,2,14);

UPDATE TW_checkpoint SET id_test=1, id_intrebare=1 where id_kid=1;
/
delete from tw_answers;
/
commit;
/
drop table Tw_checkpoint;