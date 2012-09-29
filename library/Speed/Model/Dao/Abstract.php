<?php

/**
 * Abstract Model Dao
 *
 * @category    Dao
 * @author      Syed Abidur Rahman <aabid048@gmail.com>
 * @copyright   Right Brain Solution Ltd. <http://www.rightbrainsolution.com>
 */
abstract class Speed_Model_Dao_Abstract extends Zend_Db_Table_Abstract
{
    protected $_name = '';
    protected $_primaryKey = '';

    protected function loadTable($table, $primaryKey = 'id')
    {
        $this->_name = $table;
        $this->_primaryKey = $primaryKey;
    }

    protected function removeNonAttributes($data = array())
    {
        $columns = $this->_getCols();
        foreach ($data as $key => $val) {
            if (!in_array($key, $columns)) {
                unset($data[$key]);
            }
        }

        return $data;
    }

    protected function returnResultAsAnArray($result)
    {
        if (empty ($result)) {
            return array();
        } else if (is_object($result)){
            return $result->toArray();
        }

        return $result;
    }

    public function create(array $data)
    {
        $data = $this->removeNonAttributes($data);
        return parent::insert($data);
    }

    public function modify(array $data, $id)
    {
        $data = $this->removeNonAttributes($data);
        return parent::update($data, "{$this->_primaryKey} = '{$id}'");
    }

    public function remove($id = null)
    {
        if (empty ($id)) {
            return false;
        }

        return parent::delete("{$this->_primaryKey} = '{$id}'");
    }

    public function getTotalRows($options = array())
    {
        $select = $this->select()
                        ->from($this->_name,
                            array('total' => new Zend_Db_Expr('count(*)')));

        $select = $this->setQuerySegments($select, $options);

        $row = $this->fetchRow($select);
        return empty ($row) ? 0 : $row['total'];
    }

    public function getDetail($id)
    {
        $select = $this->select()
                       ->from($this->_name)
                       ->where("$this->_primaryKey =?" , $id);

        return $this->returnResultAsAnArray($this->fetchRow($select));

    }

    protected function setQuerySegments(Zend_Db_Table_Select $select, $options = array()) { return $select; }
}