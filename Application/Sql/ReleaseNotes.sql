create table ReleaseNotes (
 Id int not null primary key auto_increment,
 VersionNumber varchar(128),
 ReleaseDate varchar(128),
 Content varchar(32768),
 ProjectId int not null default 0,
 Foreign key(ProjectId) REFERENCES Project(Id)
);