<?php
/**
 * User Dao Model
 *
 * @User        Model
 * @package         admin
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2011
 */
class Admin_Model_Dao_User extends Speed_Model_Dao_Abstract
{
    public function __construct()
    {
        parent::__construct();
        $this->loadTable('users','user_id');
    }

    public function getAll()
    {

        $select = $this->select()
                       ->from($this->_name);

        return $this->returnResultAsAnArray($this->fetchAll($select));
    }


    public function getDetailForAdmin($userId)
            {
                $select = $this->select()
                    ->from($this->_name)
                    ->where("{$this->_primaryKey} =?", $userId);

                return $this->returnResultAsAnArray($this->fetchRow($select));
            }


     public function getDetail($userId)
        {
            $select = $this->select()
                ->from($this->_name)
                ->where("{$this->_primaryKey} =?", $userId);

            return $this->returnResultAsAnArray($this->fetchRow($select));
        }


        public function getPublishStatus($userId)
        {
            $select = $this->select()
                           ->from($this->_name,array('user_status'))
                           ->where("user_id =?", $userId);

            return $this->returnResultAsAnArray($this->fetchRow($select));

        }
	
        public function getBannedStatus($userId)
        {
            $select = $this->select()
                           ->from($this->_name,array('user_status'))
                           ->where("user_id =?", $userId);

            return $this->returnResultAsAnArray($this->fetchRow($select));

        }
	

 	

}
