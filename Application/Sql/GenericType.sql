create table generictype(
	Id int not null primary key auto_increment,
    TypeName varchar(256),
    `Constraint` varchar(256),
    SortIndex int not null default 0,
    MethodId int not null,
    foreign key(MethodId) references Method(Id)
);