create table Property(
  Id int not null primary key auto_increment,
  PropertyName varchar(256) default null,
  ShortDescription varchar(1024) default null,
  Description varchar(16384) default null,
  IsStatic int(1) not null default 0,
  AccessModifierId int not null,
  CustomModifiersId int not null default 0,
  ProjectClassId int not null,
  TypeId int not null,
  foreign key(ProjectClassId) references ProjectClass(Id),
  foreign key(TypeId) references ProjectClass(Id)
)