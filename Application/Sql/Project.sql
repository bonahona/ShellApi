CREATE TABLE Project (
  Id int not null primary key auto_increment,
  ProjectCategoryId int,
  ProjectLanguageId int,
  ProjectName varchar(512) default null,
  IsActive int(1) default 1,
  foreign key(ProjectCategoryId) references ProjectCategory(Id),
  foreign key(ProjectLanguageId) references ProjectLanguage(Id)
);