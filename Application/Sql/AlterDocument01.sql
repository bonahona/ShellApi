alter table document add column ParentDocumentId int;
alter table document add foreign key(ParentDOcumentId) references Document(Id);