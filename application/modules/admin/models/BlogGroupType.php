<?php
/**
 * Group Type Model
 * @category        Model
 * @package         Group type
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2012
 */
class Admin_Model_BlogGroupType extends Speed_Model_Abstract
{
    /**
     * @var Admin_Model_Dao_BlogGroupType
     */
    protected $dao;

    public function __construct($dao = null)
    {
        if (empty ($dao)) {
            $this->dao = new Admin_Model_Dao_BlogGroupType();
        } else {
            $this->dao = $dao;
        }
    }

    public function getAll()
    {
        return $this->dao->getAll();
    }

    public function save($data)
    {
        if (empty($data)) {
            return false;
        }
        $postId = $this->dao->create($data);
        return $postId;
    }

    public function modify($data = array(), $groupId = null)
    {
        if (empty($data) || empty($groupId)) {
            return false;
        }
        $this->dao->modify($data, $groupId);
        return true;
    }
}
