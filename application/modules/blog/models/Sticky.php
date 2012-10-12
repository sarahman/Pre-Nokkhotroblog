<?php
/**
 * Sticky Controller
 * @Group Type   Controller
 * @package     Blog
 * Date Sep 24 2012
 * @author      Mohammad Zafar iqbal <zafar@speedplusnet.com>
 */
class Blog_Model_Sticky extends Speed_Model_Abstract
{
    /**
     * @var Blog_Model_Dao_Sticky
     */
    protected $dao;

    public function __construct($dao = null)
    {
        if (empty ($dao)) {
            $this->dao = new Blog_Model_Dao_Sticky();
        } else {
            $this->dao = $dao;
        }
    }

    public function getAll()
    {
        return $this->dao->getAll();
    }

    public function getDetailForAdmin($stickyId)
    {
        if (empty ($stickyId)) {
            return false;
        }
        $record = $this->dao->getDetailForAdmin($stickyId);
        return $record;
    }

    public function save($data)
    {
        if (empty($data)) {
            return false;
        }
        $categoryId = $this->dao->create($data);
        return $categoryId;
    }
}
