<?php
class TestController extends Controller
{
    public function Index($projectClassId, $returnType, $isStatic)
    {
        $result = $this->Models->Method->Where(
            array('ProjectClassId' => $projectClassId, 'ReturnTypeId' => $returnType, 'IsStatic' => $isStatic)
        )->OrderBy('MethodName')->Take(5);
        var_dump($result);
        return;
        return $this->Json(['test'=> 'this is the body']);
    }
}