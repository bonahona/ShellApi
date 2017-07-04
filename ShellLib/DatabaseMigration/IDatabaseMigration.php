<?php
public interface IDatabaseMigration
{
    /* @param DatabaseMigrator $migrator*/
    function Up($migrator);

    /* @param DatabaseMigrator $migrator*/
    function Down($migrator);

    /* @param DatabaseMigrator $migrator*/
    function Seed($migrator);
}