<?php
interface ICollection
{
    public function Keys();
    public function Add($item);

    /* @return ICollection */
    public function Copy($items);

    /* @return ICollection */
    public function OrderBy($field);

    /* @return ICollection */
    public function OrderByDescending($field);

    /* @return ICollection */
    public function Where($conditions);

    /* @return ICollection */
    public function Take($count);

    /* @return Model */
    public function First();

    /* @return bool */
    public function Any($conditions);
}