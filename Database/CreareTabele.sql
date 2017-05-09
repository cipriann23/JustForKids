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
Phone Number(10),
City Varchar2(20),
Country Varchar2(20)
)

Create Table TW_Test
(
Id Integer Primary Key,
Category Number(4),
Id_question Number(4),
Text_intrebare Varchar2(100),
var1 Varchar2(40),
var2 Varchar2(40),
var3 Varchar2(40),
var4 Varchar2(40),
var_corecta Varchar2(40),
Descriere Varchar2(200)
)
/
Create Table TW_Answers(
id_kid Integer,
id_test integet,
id_intrebare integer,
answer varchar(40),
solved number(1)
)
/









)