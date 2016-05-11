<?php
require_once('/../../ShellLib/Core/ScriptCore.php');
class MigrateDatabaseCore extends ScriptCore
{
    public function ExportDatabase($targetFile = null)
    {
        echo "Exporting database to " . $targetFile;

        $tables = array();

        foreach($this->Models->GetAll() as $modelCollection) {
            $tableEntries = array();

            $keys = $modelCollection->Keys();

            foreach($keys as $id) {
                $entry = $modelCollection->Find($id);
                $tableEntries[] = $entry->Object();
            }

            $tables[$modelCollection->ModelCache['MetaData']['TableName']] = $tableEntries;
        }

        $fileContent = json_encode($tables, JSON_PRETTY_PRINT);
        file_put_contents($targetFile, $fileContent);
    }

    public function ImportDatabase($sourceFile)
    {
        // Make sure the source file exists
        echo "Clearing current database:\n";
        echo "========================================\n";
        foreach($this->Models->GetAll() as $modelCollection){
            echo "Clearing table " . $modelCollection->ModelCache['MetaData']['TableName'] . "\n";
            $modelCollection->Clear();
        }

        echo "Importing source file:\n";
        //echo
    }
}