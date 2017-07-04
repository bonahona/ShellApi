<?php
class DatabaseMigrator
{
    /* @var Models $Models*/
    public $Models;

    /* @var IDatabaseDriver $Database*/
    public $Database;

    public function __construct($models, $database)
    {
        $this->Models = $models;
        $this->Database = $database;
    }
}