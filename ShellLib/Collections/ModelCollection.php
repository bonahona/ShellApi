<?php
/**
 * Wrapper around a model to allow for model interaction such as load and save of data to the database
 */

define('INT', "i");
define('STRING', "s");

class ModelCollection implements ICollection
{
    public $ModelCache;
    public $ModelName;

    public function Create($defaultValues = array())
    {
        $result = new $this->ModelName($this);

        foreach($defaultValues as $key => $value){
            $result->$key = $value;
        }

        $result->OnLoad();

        return $result;
    }

    public function Find($id)
    {
        $result = $this->GetInstance()->GetDatabase()->Find($this, $id);

        if($result != null) {
            $result->OnLoad();
        }

        return $result;
    }

    public function Exists($id)
    {
        $result = $this->GetInstance()->GetDatabase()->Exists($this, $id);
        return $result;
    }

    public function Where($conditions)
    {
        $conditions = $this->ConvertConditions($conditions);
        $whereConditions = $conditions->GetWhereClause();
        $result = $this->GetInstance()->GetDatabase()->Where($this, $whereConditions['ConditionString'], $whereConditions['Parameters']);

        foreach($result as $entry){
            $entry->OnLoad();
        }

        return $result;
    }

    public function Any($conditions)
    {
        $conditions = $this->ConvertConditions($conditions);
        $whereConditions = $conditions->GetWhereClause();
        return $this->GetInstance()->GetDatabase()->Any($this, $whereConditions['ConditionString'], $whereConditions['Parameters']);
    }

    // Helper to make sure all conditions are proper DatabaseWhereCondition objects
    private function ConvertConditions($conditions)
    {
        if(is_array($conditions)){
            return AndCondition($conditions);
        }else if(is_a($conditions, 'DatabaseWhereCondition')){
            return $conditions;
        }else{
            die('Invalid where conditions');
        }
    }

    public function All()
    {
        $result = $this->GetInstance()->GetDatabase()->All($this);

        foreach($result as $entry){
            $entry->OnLoad();
        }

        return $result;
    }

    public function Delete($model)
    {
        return $this->GetInstance()->GetDatabase()->Delete($this, $model);
    }

    public function Clear()
    {
        $this->GetInstance()->GetDatabase()->Clear($this);
    }

    public function Save($model){
        if($model->IsSaved()){
            $this->Update($model);
        }else{
            $this->Insert($model);
        }
    }

    protected function Insert(&$model)
    {
        return $this->GetInstance()->GetDatabase()->Insert($this, $model);
    }

    protected function Update($model)
    {
        return $this->GetInstance()->GetDatabase()->Update($this, $model);
    }

    public function Add($item)
    {
        $this->Save($item);
    }

    public function Keys()
    {
        return $this->GetInstance()->GetDatabase()->Keys($this);
    }

    public function OrderBy($field)
    {
        trigger_error('ModelCollection does not support OrderBy. Use a selection first.', E_USER_ERROR);
    }

    public function OrderByDescending($field)
    {
        trigger_error('ModelCollection does not support OrderByDescending. Use a selection first.', E_USER_ERROR);
    }

    public function Take($count)
    {

    }

    public function First()
    {
        $result = $this->GetInstance()->GetDatabase()->First($this);

        if($result != null) {
            $result->OnLoad();
        }

        return $result;
    }

    public function Copy($item)
    {
        throw new Exception("ModelCollection::Copy() not supported");
    }

    protected function GetInstance()
    {
        $coreInstanceProperty = new ReflectionProperty(CORE_CLASS, 'Instance');
        $coreInstance =  $coreInstanceProperty->getValue();

        return $coreInstance;
    }
}
