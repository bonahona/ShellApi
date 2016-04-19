<?php
interface ICollection
{
    public function Keys();
    public function Add($item);

    public function Copy($items);
    public function OrderBy($field);
    public function Where($conditions);
    public function Take($count);
    public function First();
    public function Any($conditions);
}