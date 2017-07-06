<?php
require_once('BackendController.php');
class GenericTypesController extends BackendController
{
    public function Create()
    {
        if($this->IsPost()){
            $genericType = $this->Data->Parse('GenericType', $this->Models->GenericType);

            $lastSortIndexItem = $this->Models->GenericType->Where(array('MethodId' => $genericType->MethodId))->OrderByDescending('SortIndex')->First();

            if($lastSortIndexItem == null){
                $genericType->SortIndex = 0;
            }else{
                $genericType->SortIndex = $lastSortIndexItem->SortIndex +1;
            }

            $genericType->Save();

            $result = $genericType->Object();
            return $this->Json($result);
        }

        return $this->HttpNotFound();
    }

    public function Delete($id)
    {
        if(empty($id)){
            return $this->HttpNotFound();
        }

        $genericType = $this->Models->GenericType->Find($id);
        if($genericType == null){
            return $this->HttpNotFound();
        }

        $genericType->Delete();

        return $this->Json(array('Status' => 'ok'));
    }
}