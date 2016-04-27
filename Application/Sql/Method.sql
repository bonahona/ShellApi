create table Method(
  Id int not null primary key auto_increment,
  ShortDescription varchar(1024) default null,
  Description varchar(16384) default null,
  IsStatic int(1) not null,
  AccessModifierId int not null,
  ProjectClassId int not null,
  ReturnTypeId int not null,
  foreign key(ProjectClassId) references ProjectClass(Id),
  foreign key(ReturnTypeId) references ProjectClass(Id)
)