create table Document(
	Id int not null primary key auto_increment,
    PageTitle varchar(256),
    NavigationTitle varchar(256),
    Content varchar(16834),
    ShowInMenu int(1) default 0,
    ProjectId int,
    ClassId int,
    MethodId int,
    PropertyId int
);