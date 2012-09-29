<?php
/**
 * user Dao Model
 *
 * @userprofile        Model
 * @package         profile
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2011
 */
class Blog_Model_Dao_UserProfile extends Speed_Model_Dao_Abstract
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


}
