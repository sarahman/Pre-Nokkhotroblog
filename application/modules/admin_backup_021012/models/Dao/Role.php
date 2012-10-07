<?php
/**
 * User Dao Model
 *
 * @User Model
 * @package admin
 * @author Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright Copyright (c) 2011
 */
class Admin_Model_Dao_Role extends Speed_Model_Dao_Abstract
{
    public function __construct()
    {
        parent::__construct();
        $this->loadTable('roles','role_id');
    }

    public function getAll()
    {

        $select = $this->select()
                       ->from($this->_name);

        return $this->returnResultAsAnArray($this->fetchAll($select));
    }


    public function getDetailForAdmin($role_id)
            {
                $select = $this->select()
                    ->from($this->_name)
                    ->where("{$this->_primaryKey} =?", $role_id);

                return $this->returnResultAsAnArray($this->fetchRow($select));
            }


     public function getDetail($role_id)
        {
            $select = $this->select()
                ->from($this->_name)
                ->where("{$this->_primaryKey} =?", $role_id);

            return $this->returnResultAsAnArray($this->fetchRow($select));
        }


        public function getPublishStatus($role_id)
        {
            $select = $this->select()
                           ->from($this->_name,array('role'))
                           ->where("role_id =?", $role_id);

            return $this->returnResultAsAnArray($this->fetchRow($select));

        }
 

}
