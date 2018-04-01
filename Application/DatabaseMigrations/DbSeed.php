<?php
class DbSeed implements IDatabaseMigration
{
    public function GetUniqueName()
    {
        return 'Bxa092Fa2PUvXkk8MjaxUVU6oiFWVKnY';
    }

    public function GetSortOrder()
    {
        return 1;
    }

    function Up($database)
    {
    }

    function Down($migrator)
    {
    }

    function Seed($migrator)
    {
        $migrator->Models->ProjectLanguage->Create(['DisplayName' => 'Php', 'ClassName' => 'sh_php', 'IsActive' => 1])->Save();
        $migrator->Models->ProjectLanguage->Create(['DisplayName' => 'C#', 'ClassName' => 'sh_csharp', 'IsActive' => 1])->Save();
        $migrator->Models->ProjectLanguage->Create(['DisplayName' => 'C++', 'ClassName' => 'sh_cpp', 'IsActive' => 1])->Save();

        $migrator->Models->ProjectCategory->Create(['Name' => 'Unity', 'IsActive'])->Save();
        $migrator->Models->ProjectCategory->Create(['Name' => 'Shell MVC Suite', 'IsActive'])->Save();

        $migrator->Models->StaticBlock->Create(['Identifier' => 'contact', 'Content' => ''])->Save();
        $migrator->Models->StaticBlock->Create(['Identifier' => 'presentation', 'Content' => ''])->Save();
    }
}