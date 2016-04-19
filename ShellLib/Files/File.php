<?php
class File
{
    public $Name;
    public $Size;
    public $Path;
    public $Type;

    public function Save($target)
    {
        $target = APPLICATION_ROOT . $target;
        if (getimagesize($this->Path) !== false) {
            if (move_uploaded_file($this->Path, $target)) {
                return true;
            }
        }

        return false;
    }
}