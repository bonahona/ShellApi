create table Parameter(
  Id int not null primary key auto_increment,
  ParameterName varchar(256) default null,
  DefaultValue varchar(1024),
  MethodId int not null,
  TypeId int not null,
  foreign key(MethodId) references Method(Id),
  foreign key(TypeId) references ProjectClass(Id)
)