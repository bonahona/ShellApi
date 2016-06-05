create table StaticBlock(
  Id int not null primary key auto_increment,
  Identifier varchar(128) not null default "",
  Content varchar(32768)
)