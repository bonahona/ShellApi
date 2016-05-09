create table Example(
	Id int not null primary key auto_increment,
    ExampleText varchar(8417),
    ExampleContent varchar(8417),
    SortOrder int default 1,
    IsActive int(1) default 1,
    ProjectLanguageId int not null,
    ProjectId int,
    ClassId int,
    MethodId int,
    PropertyId int,
    foreign key(ProjectLanguageId) references ProjectLanguage(Id)
);