create table SeeAlsoLink(
	Id int not null primary key auto_increment,
    ProjectId int,
    ClassId int,
    MethodId int,
    PropertyId int,
    DisplayName varchar(256) default null,
    Link varchar(256) default null
);