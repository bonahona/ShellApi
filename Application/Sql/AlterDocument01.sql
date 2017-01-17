alter table document add column ParentDocumentId int;
alter table document add foreign key(ParentD'OcumentId) references Document(Id);