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
solved number(1)
)
/
INSERT into tw_login values(0,'admin',null,null,'admin',2,'nemtocciprian10@gmail.com',null,null);
INSERT into tw_login values(1,'kid',null,null,'kid',0,null,null,null);
/
commit;