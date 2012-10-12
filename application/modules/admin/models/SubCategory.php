<?php
/**
 * Sub category Model
 * @category        Model
 * @package         admin
 * @author          Mustafa Ahmed Khan <tamal_29@yahool.com>
 * @copyright       Copyright (c) 2012
 */
class Admin_Model_SubCategory extends Speed_Model_Abstract
{
    /**
     * @var Blog_Model_Dao_BlogCategory
     */
    protected $dao;

    public function __construct($dao = null)
    {
        if (empty ($dao)) {
            $this->dao = new Admin_Model_Dao_SubCategory();
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

    public function modify($data = array(), $subcategoryId = null)
    {
        if (empty($data) || empty($subcategoryId)) {
            return false;
        }
        $this->dao->modify($data, $subcategoryId);
        return true;
    }
}
