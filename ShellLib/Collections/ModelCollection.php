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

    public function Create()
    {
        return new $this->ModelName($this);
    }

    public function Find($id)
    {
        $result = Core::$Instance->GetDatabase()->Find($this, $id);

        if($result != null) {
            $result->OnLoad();
        }

        return $result;
    }

    public function Exists($id)
    {
        $result = Core::$Instance->GetDatabase()->Exists($this, $id);
        return $result;
    }

    public function Where($conditions)
    {
        $result = Core::$Instance->GetDatabase()->Where($this, $conditions);
        foreach($result as $entry){
            $entry->OnLoad();
        }

        return $result;
    }

    public function Any($conditions)
    {
        return Core::$Instance->GetDatabase()->Any($this, $conditions);
    }

    public function All()
    {
        $result = Core::$Instance->GetDatabase()->All($this);

        foreach($result as $entry){
            $entry->OnLoad();
        }

        return $result;
    }

    public function Delete($model)
    {
        return Core::$Instance->GetDatabase()->Delete($this, $model);
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
        return Core::$Instance->GetDatabase()->Insert($this, $model);
    }

    protected function Update($model)
    {
        return Core::$Instance->GetDatabase()->Update($this, $model);
    }

    public function Add($item)
    {
        $this->Save($item);
    }

    public function Keys()
    {
        throw new Exception("ModelCollection::Keys() not supported");
    }

    public function OrderBy($field)
    {

    }

    public function Take($count)
    {

    }

    public function First()
    {
        $result = Core::$Instance->GetDatabase()->First($this);

        if($result != null) {
            $result->OnLoad();
        }

        return $result;
    }

    public function Copy($item)
    {
        throw new Exception("ModelCollection::Copy() not supported");
    }
}
