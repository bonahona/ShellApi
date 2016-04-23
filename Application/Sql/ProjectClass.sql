
create table ProjectClass(
	Id int not null primary key auto_increment,
    ClassName varchar(256) default null,
    ShortDescription varchar(1024) default null,
    Description varchar(16384) default null,
    Namespace varchar(256) default null,
    ExternalSource varchar(512) default null,
    BaseClassId int,
    ProjectId int not null,
    foreign key(BaseClassId) references ProjectClass(Id),
    foreign key(ProjectId) references Project(Id)
);