<?php
/**
 * Notice Model
 * @Notice        Model
 * @package         blog
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2011
 */
class User_Model_Userdetail extends Speed_Model_Abstract
{
    /**
     * @var Admin_Model_Dao_Notic
     */
    protected $dao;

    public function __construct($dao = null)
    {
        if (empty ($dao)) {
            $this->dao = new User_Model_Dao_Userdetail();
        } else {
            $this->dao = $dao;
        }
    }

    public function getAll()
    {
        return $this->dao->getAll();
    }

    public function getDetailForAdmin($userdetailId)
    {
        if (empty ($userdetailId)) {
            return false;
        }
        $record = $this->dao->getDetailForAdmin($userdetailId);
        return $record;
    }

    public function save($data)
    {
        if (empty($data)) {
            return false;
        }
        $authNamespace   = new Zend_Session_Namespace('userInformation');
        $data['user_id'] = $authNamespace->userData['user_id'];
        $commentId       = $this->dao->create($data);
        return $commentId;
    }
}
