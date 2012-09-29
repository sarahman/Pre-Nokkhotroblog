<?php

class Speed_Utility_PaginatorAdapter extends Zend_Paginator_Adapter_Array
{
    public function __construct(array $resultSet, $count)
    {
        parent::__construct($resultSet);
        $this->_count = $count;
    }
}