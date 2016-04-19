<?php
class SqlCollection implements IDataCollection
{
    public function __construct()
    {
        $this->m_position = 0;
        $this->m_items = array();
    }

    public function Copy($items)
    {
        foreach($items as $item){
            $this->Add($item);
        }
    }

    function rewind()
    {
        $this->m_position = 0;
    }

    function current()
    {
        return $this->m_items[$this->m_position];
    }

    function key()
    {
        return $this->m_position;
    }

    function next()
    {
        $this->m_position++;
    }

    function valid()
    {
        return isset($this->m_items[$this->m_position]);
    }

    function count()
    {
        return count($this->m_items);
    }

    public function Keys()
    {
        return array_keys($this->m_items);
    }

    public function Add($item)
    {
        $this->m_items[] = $item;
    }

    public function OrderBy($field)
    {
        $tmpArray = $this->m_items;
        $this->quickSort($tmpArray, $field);

        $result = new Collection();
        $result->Copy($this->m_items);

        return $result;
    }

    public function Where($conditions)
    {
        $result = new Collection();

        foreach($this->m_items as $item){
            if($this->CheckConditions($conditions, $item)){
                $result->Add($item);
            }
        }

        return $result;
    }

    public function Any($conditions)
    {
        foreach($this->m_items as $item){
            if($this->CheckConditions($conditions, $item)){
                return result;
            }
        }

        return false;
    }

    public function Take($count)
    {
        $result = new Collection();

        $currentCount = 0;
        foreach($this->m_items as $item){
            $result->Add($item);
            $currentCount ++;

            if($currentCount == $count){
                break;
            }
        }

        return $result;
    }

    private function CheckConditions($conditions, $item)
    {
        if(!is_array($conditions)){
            return false;
        }else {

            foreach($conditions as $key => $value){
                if($item->$key != $value){
                    return false;
                }
            }

            // Nothing failed this conditions check
            return true;
        }
    }

    // Taken from http://stackoverflow.com/questions/1462503/sort-array-by-object-property-in-php
    private function quickSort(&$array, $field)
    {
        if(count($array) == 0){
            return;
        }

        $cur = 1;
        $stack[1]['l'] = 0;
        $stack[1]['r'] = count($array)-1;

        do
        {
            $l = $stack[$cur]['l'];
            $r = $stack[$cur]['r'];
            $cur--;

            do
            {
                $i = $l;
                $j = $r;
                $tmp = $array[(int)( ($l+$r)/2 )];

                // partion the array in two parts.
                // left from $tmp are with smaller values,
                // right from $tmp are with bigger ones
                do
                {
                    while( $array[$i]->$field < $tmp->$field )
                        $i++;

                    while( $tmp->$field < $array[$j]->$field )
                        $j--;

                    // swap elements from the two sides
                    if( $i <= $j)
                    {
                        $w = $array[$i];
                        $array[$i] = $array[$j];
                        $array[$j] = $w;

                        $i++;
                        $j--;
                    }

                }while( $i <= $j );

                if( $i < $r )
                {
                    $cur++;
                    $stack[$cur]['l'] = $i;
                    $stack[$cur]['r'] = $r;
                }
                $r = $j;

            }while( $l < $r );

        }while( $cur != 0 );
    }

    public function First()
    {
        if(count($this->m_items) > 0){
            return $this->m_items[0];
        }else{
            return null;
        }
    }

    public function offsetSet($offset, $value)
    {
        if(is_null($offset)){
            $this->m_items[] = $value;
        }else{
            $this->m_items[$offset] = $value;
        }
    }

    public function offsetExists($offset)
    {
        return isset($this->m_items[$offset]);
    }

    public function offsetUnset($offset)
    {
        unset($this->m_items[$offset]);
    }

    public function offsetGet($offset)
    {
        if(isset($this->m_items[$offset])){
            return $this->m_items[$offset];
        }else{
            return null;
        }
    }

    protected function FetchData()
    {
        $result = new Collection();

        return $result;
    }
}