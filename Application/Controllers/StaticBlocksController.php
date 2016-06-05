<?php
require_once('BackendController.php');
class StaticBlocksController extends BackendController
{
    public function Edit($id = null)
    {
        $this->Title = 'Edit static block';
        if($id == null || $id == ''){
            return $this->HttpNotFound();
        }

        $staticBlock = $this->Models->StaticBlock->Find($id);
        if($staticBlock == null){
            return $this->HttpNotFound();
        }


        if($this->IsPost() && !$this->Data->IsEmpty()){
            $staticBlock = $this->Data->DbParse('StaticBlock', $this->Models->StaticBlock);
            $staticBlock->Save();

            $ref = $this->Get['ref'];

            return $this->Redirect($ref);
        }else{
            $this->Set('StaticBlock', $staticBlock);
            return $this->View();
        }
    }
}