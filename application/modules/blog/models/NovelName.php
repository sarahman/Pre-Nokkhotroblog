<?php
/**
 * Blog category Model
 * @category        Model
 * @package         blog
 * @author          Mohammad Zafar Iqbal
 * @copyright       Copyright (c) 2012
 */
class Blog_Model_NovelName extends Speed_Model_Abstract
{
    /**
     * @var Blog_Model_Dao_NovelName
     */
    protected $dao;

    public function __construct($dao = null)
    {
        if (empty ($dao)) {
            $this->dao = new Blog_Model_Dao_NovelName();
        } else {
            $this->dao = $dao;
        }
    }

    public function getAll()
    {
        return $this->dao->getAll();
    }

    public function myNovel($userId)
    {
        if (empty ($userId)) {
            return false;
        }
        return $this->dao->myNovel($userId);
    }

    public function getDetailByNovelPermalink($novelName)
    {
        if (empty($novelName)) {
            return false;
        }
        return $this->dao->getDetailByNovelPermalink($novelName);
    }

    public function getNovelDetail($nId)
    {
        if (empty ($nId)) {
            return false;
        }
        $record = $this->dao->getNovelDetail($nId);
        return $record;
    }

    public function save($data)
    {
        if (empty($data)) {
            return false;
        }
        $permalink                    = new Speed_Utility_Url();
        $authNamespace                = new Zend_Session_Namespace('userInformation');
        $data['novel_name_permalink'] = $permalink->getUrl($data['name']);
        $data['create_by']            = $authNamespace->userData['user_id'];
        $data['create_date']          = date('Y-m-d H:i:s');
        $categoryId                   = $this->dao->create($data);
        return $categoryId;
    }

    public function getDetailForNovel($userId)
    {
        if (empty ($userId)) {
            return false;
        }
        $record = $this->dao->getDetailForNovel($userId);
        return $record;
    }

    public function modify($data = array(), $novelNameId = null)
    {
        if (empty($data) || empty($novelNameId)) {
            return false;
        }
        $data['novel_name_permalink'] = $novelNameId;
        $this->dao->modify($data, $novelNameId);
        return true;
    }
}
