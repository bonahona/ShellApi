<?php
interface IDatabaseDriver
{
    public function DescribeTable($tableName);
    public function DescribeRelation($class, $column);
    function GetPreparedStatementType($type);
    function GetColumnNames($columns, $primaryKey);
    public function Close();

    public function Find($modelCollection, $id);
    public function Exists($modelCollection, $id);
    public function Where($modelCollection, $conditions, $parameters);
    public function First($modelCollection);
    public function Any($modelCollection, $conditions, $parameters);
    public function All($modelCollection);
    public function Keys($modelCollection);
    public function Delete($modelCollection, $model);
    public function Clear($modelCollection);
    public function Insert($modelCollection, &$model);
    public function Update($modelCollection, $model);
}