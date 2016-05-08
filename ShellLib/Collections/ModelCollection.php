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
        $result = $this->GetInstance()->GetDatabase()->Where($this, $conditions);
        foreach($result as $entry){
            $entry->OnLoad();
        }

        return $result;
    }

    public function Any($conditions)
    {
        return $this->GetInstance()->GetDatabase()->Any($this, $conditions);
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
