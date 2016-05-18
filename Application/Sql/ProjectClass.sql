
create table ProjectClass(
	Id int not null primary key auto_increment,
    ClassName varchar(256) default null,
    ShortDescription varchar(1024) default null,
    Description varchar(16384) default null,
    Namespace varchar(256) default null,
    CustomModifiersId int not null default 0,
    ExternalSource varchar(512) default null,
    IsPrimitive int(1) not null,
    BaseClassId int,
    ProjectId int not null,
    foreign key(BaseClassId) references ProjectClass(Id),
    foreign key(ProjectId) references Project(Id)
);