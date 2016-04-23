create table InheritInterface(
	Id int not null primary key auto_increment,
    ProjectClassId int not null,
    InheritInterfaceId int not null,
    foreign key(ProjectClassId) references ProjectClass(Id),
    foreign key(InheritInterfaceId) references ProjectClass(Id)
);

