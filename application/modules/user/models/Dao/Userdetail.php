<?php
/**
 * notice Dao Model
 *
 * @notice        Model
 * @package         notice
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2011
 */
class User_Model_Dao_Userdetail extends Speed_Model_Dao_Abstract
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


    public function getDetailForAdmin($userdetailId)
            {
                $select = $this->select()
                    ->from($this->_name)

                    ->where("{$this->_primaryKey} =?", $userdetailId);

                return $this->returnResultAsAnArray($this->fetchRow($select));
            }

/*public function getDetailForAdmin($userdetailId)
            {
                         $select = $this->select()
                           ->from($this->_name)
                           ->setIntegrityCheck(false)
                           ->join('user_detail', "user_detail.user_id = {$this->_name}.user_id")
                           
                           ->where("{$this->_primaryKey} =?", $userdetailId);

            return $this->returnResultAsAnArray($this->fetchAll($select));
}*/



	 public function getcommentPosts()
        {
            $select = $this->select()
                           ->from($this->_name)
                           ->setIntegrityCheck(false)
                           ->join('user_detail', "user_detail.user_id = {$this->_name}.user_id")
                           ->where("comments.is_published =?", 1)
                           ->order(array("{$this->_primaryKey} DESC"))
                           ->limit(5);

            return $this->returnResultAsAnArray($this->fetchAll($select));
        }	


     

}
