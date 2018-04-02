<?php
class TestController extends Controller
{
    public function Index($projectClassId, $returnType, $isStatic)
    {
        $result = $this->Models->Method->Where(
            array('ProjectClassId' => $projectClassId, 'ReturnTypeId' => $returnType, 'IsStatic' => $isStatic)
        )->OrderBy('MethodName')->Take(5);

        return;
        return $this->Json(['test'=> 'this is the body']);
    }

    public function Test($lol)
    {
        /*
        $testCollection = $this->Models->GenericType->Where(array('Test' => $lol))->OrderBy(GenericType.TypeName);


        $i = $this->Models->Example->First();

        $i->ProjectId
        */
    }
}