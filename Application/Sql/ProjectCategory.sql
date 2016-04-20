create table ProjectCategory(
	Id int not null primary key auto_increment,
    Name varchar(128),
    IsActive int(1) default 1
);
