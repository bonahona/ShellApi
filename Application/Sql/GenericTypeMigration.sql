alter table method modify ReturnTypeId int default null;

alter table method(
	add column ReturnGenericTypeId int default null;

alter table method
	add constraint ReturnGenericType foreign key(ReturnGenericTypeId) references GenericType(Id);

alter table parameter modify TypeId int default null;

alter table parameter
	add column ReturnGenericTypeId int default null;

alter table parameter
	add constraint ReturnGenericType foreign key(ReturnGenericTypeId) references GenericType(Id);

alter table parameter
  add column isExtension int(1) default 0;

alter table method
  add column ReturnTypeFreeText varchar(512);


