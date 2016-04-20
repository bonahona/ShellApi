create table ProjectLanguage(
	Id int not null primary key auto_increment,
    DisplayName varchar(128),
    ClassName varchar(128),
    IsActive int(1) default 1
);
