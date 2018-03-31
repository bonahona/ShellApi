<?php
class DbCreation implements IDatabaseMigration
{
    public function GetUniqueName()
    {
        return 'SF7R8FlxEqi9JJ0tSJzEyh5Ir0ZdE8Uk';
    }

    public function GetSortOrder()
    {
        return 0;
    }

    public function Up($migrator)
    {
        $migrator->CreateTable('localuser')
            ->AddPrimaryKey('Id', 'int')
            ->AddColumn('ShellUserId', 'int');

        $migrator->CreateTable('staticblock')
            ->AddPrimaryKey('Id', 'int')
            ->AddColumn('Identifier', 'varchar(128)', array('not null', 'default ""'))
            ->AddColumn('Content', 'varchar(32768)');

        $migrator->CreateTable('projectcategory')
            ->AddPrimaryKey('Id', 'int')
            ->AddColumn('Name', 'varchar(128)')
            ->AddColumn('IsActive', 'int(1)', array('not null', 'default 1'));

        $migrator->CreateTable('projectlanguage')
            ->AddPrimaryKey('Id', 'int')
            ->AddColumn('DisplayName', 'varchar(128)')
            ->AddColumn('ClassName', 'varchar(128)')
            ->AddColumn('IsActive', 'int(1)', array('not null', 'default 1'));

        $migrator->CreateTable('project')
            ->AddPrimaryKey('Id', 'int')
            ->AddColumn('ProjectName', 'varchar(256)')
            ->AddColumn('TitleName', 'varchar(256)')
            ->AddColumn('ShortDescription', 'varchar(1024)')
            ->AddColumn('Description', 'varchar(16384)')
            ->AddColumn('IsActive', 'int(1)', array('not null', 'default 1'))
            ->AddReference('projectcategory', 'id', array('not null'), 'ProjectCategoryId')
            ->AddReference('projectlanguage', 'id', array('not null'), 'ProjectLanguageId');

        $migrator->CreateTable('document')
            ->AddPrimaryKey('Id', 'int')
            ->AddColumn('PageTitle', 'varchar(256)')
            ->AddColumn('NavigationTitle', 'varchar(256)')
            ->AddColumn('Content', 'varchar(16834)')
            ->AddColumn('ShowInMenu', 'int(1)', array('not null', 'default 0'))
            ->AddColumn('ProjectId', 'int')
            ->AddColumn('ClassId', 'int')
            ->AddColumn('MethodId', 'int')
            ->AddColumn('PropertyId', 'int')
            ->AddReference('document', 'id', array(), 'ParentDocumentId');

        $migrator->CreateTable('example')
            ->AddPrimaryKey('Id', 'int')
            ->AddColumn('ExampleText', 'varchar(8417)')
            ->AddColumn('ExampleContent', 'varchar(8417)')
            ->AddColumn('SortOrder', 'int', array('not null', 'default 0'))
            ->AddColumn('IsActive', 'int(1)', array('not null', 'default 0'))
            ->AddReference('projectlanguage', 'Id', array('not null'), 'ProjectLanguageId')
            ->AddColumn('ProjectId', 'int')
            ->AddColumn('ClassId', 'int')
            ->AddColumn('MethodId', 'int')
            ->AddColumn('PropertyId', 'int');

        $migrator->CreateTable('releasenotes')
            ->AddPrimaryKey('Id', 'int')
            ->AddColumn('VersionNumber', 'varchar(128)')
            ->AddColumn('ReelaseDate', 'varchar(128)')
            ->AddColumn('Content', 'varchar(32768)')
            ->AddReference('project', 'Id', array('not null', 'default 0'), 'ProjectId');

        $migrator->CreateTable('seealsolink')
            ->AddPrimaryKey('Id', 'int')
            ->AddColumn('DisplayName', 'varchar(256)')
            ->AddColumn('Link', 'varchar(256)')
            ->AddColumn('ProjectId', 'int')
            ->AddColumn('ClassId', 'int')
            ->AddColumn('MethodId', 'int')
            ->AddColumn('PropertyId', 'int');

        $migrator->CreateTable('projectclass')
            ->AddPrimaryKey('Id', 'int')
            ->AddColumn('ClassName', 'varchar(256)')
            ->AddColumn('ShortDescription', 'varchar(1024)')
            ->AddColumn('Description', 'varchar(16384)')
            ->AddColumn('Namespace', 'varchar(256)')
            ->AddColumn('CustomModifiersId', 'int', array('not null', 'default 0'))
            ->AddColumn('ExternalSources', 'varchar(512)', array('default 0'))
            ->AddColumn('IsPrimitive', 'int(1)', array('not null', 'default 0'))
            ->AddReference('projectclass', 'Id', array(), 'BaseClassId')
            ->AddReference('project', 'Id', array('not null'), 'ProjectId');

        $migrator->CreateTable('inheritinterface')
            ->AddPrimaryKey('Id', 'int')
            ->AddReference('projectclass', 'Id', array('not null'), 'ProjectClassId')
            ->AddReference('projectclass', 'Id', array('not null'), 'InheritInterfaceId');

        $migrator->CreateTable('method')
            ->AddPrimaryKey('Id', 'int')
            ->AddColumn('MethodName', 'varchar(256)')
            ->AddColumn('ShortDescription', 'varchar(1024)')
            ->AddColumn('Description', 'varchar(16384)')
            ->AddColumn('IsStatic', 'int(1)', array('not null', 'default 0'))
            ->AddColumn('AccessModifierId', 'int', array('not null'))
            ->AddColumn('CustomModifiersId', 'int', array('not null', 'default 0'))
            ->AddColumn('ReturnTypeFreeText', 'varchar(512)')
            ->AddReference('projectclass', 'Id', array('not null'), 'ProjectClassId')
            ->AddReference('projectclass', 'Id', array('default null'), 'ReturnTypeId');

        $migrator->CreateTable('generictype')
            ->AddPrimaryKey('Id', 'int')
            ->AddColumn('TypeName', 'varchar(256)')
            ->AddColumn('`Constraint`', 'varchar(256)')
            ->AddColumn('SortIndex', 'int', array('not null', 'default 0'))
            ->AddReference('method', 'id', array('not null'), 'MethodId');

        $migrator->CreateTable('parameter')
            ->AddPrimaryKey('Id', 'int')
            ->AddColumn('ParameterName', 'varchar(256)')
            ->AddColumn('DefaultValue', 'varchar(1024)')
            ->AddReference('method', 'Id', array('not null'), 'MethodId')
            ->AddReference('projectclass', 'Id', array('not null'), 'TypeId');

        $migrator->CreateTable('property')
            ->AddPrimaryKey('Id', 'int')
            ->AddColumn('PropertyName', 'varchar(256)')
            ->AddColumn('ShortDescription', 'varchar(1024)')
            ->AddColumn('Description', 'varchar(16384)')
            ->AddColumn('IsStatic', 'int(1)', array('not null', 'default 0'))
            ->AddColumn('AccessModifierId', 'int', array('not null'))
            ->AddColumn('CustomModifiersId', 'int', array('not null', 'default 0'))
            ->AddReference('projectclass', 'Id', array('not null'), 'ProjectClassId')
            ->AddReference('projectclass', 'Id', array('default null'), 'TypeId');

        $migrator->AlterTable('method')
                ->AddReference('generictype', 'Id', array('default null'), 'ReturnGenericTypeId');

        $migrator->AlterTable('parameter')
            ->AddReference('generictype', 'Id', array('default null'), 'ReturnGenericTypeId');
    }

    public function Down($migrator)
    {

    }

    public function Seed($migrator)
    {

    }
}