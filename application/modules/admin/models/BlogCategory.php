<?php
/**
 * Blog category Model
 * @category        Model
 * @package         blog
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2011
 */
class Admin_Model_BlogCategory extends Speed_Model_Abstract
{
    /**
     * @var Admin_Model_Dao_BlogCategory
     */
    protected $dao;

    public function __construct($dao = null)
    {
        if (empty ($dao)) {
            $this->dao = new Admin_Model_Dao_BlogCategory();
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
        $categoryId = $this->dao->create($data);
        return $categoryId;
    }

    public function modify($data = array(), $categoryId = null)
    {
        if (empty($data) || empty($categoryId)) {
            return false;
        }
        $this->dao->modify($data, $categoryId);
        return true;
    }
}
