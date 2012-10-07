<?php
/**
 * Blog category Model
 *
 * @category        Model
 * @package         blog
 * @author          Mohammad Zafar Iqbal <zafar@speedplusnet.com>
 * @copyright       Copyright (c) 2011
 */
class Admin_Model_Novel extends Speed_Model_Abstract
{

    /**
     * @var Admin_Model_Dao_Novel
     */
    protected $dao;

    public function __construct($dao = null)
    {
        if (empty ($dao)) {
            $this->dao = new Admin_Model_Dao_Novel();

        } else {
            $this->dao = $dao;
        }
    }


    public function getAll()
    {
        return $this->dao->getAll();

    }


    public function getNovelDetail($novelId)
    {
        if (empty ($novelId)) {
            return false;
        }

        return $this->dao->getNovelDetail($novelId);

    }

    public function getSingleNovelEntry($permalink)
    {
        if (empty($permalink)) {
            return false;
        }

        return $this->dao->getSingleNovelEntry($permalink);
    }


    public function save($data)
    {
        if (empty($data)) {
            return false;
        }

        $data['create_date'] = date('Y-m-d H:i:s');
        $permalink = new Speed_Utility_Url();
        $authNamespace = new Zend_Session_Namespace('userInformation');

        $data['create_date'] = date('Y-m-d H:i:s');
        $data['permalink'] = $permalink->getUrl($data['title']);
        $data['create_by'] = $authNamespace->userData['user_id'];
        $episodeId = $this->dao->create($data);
        return $episodeId;
    }

    public function getDetail($postId)
    {
        if (empty ($postId)) {
            return false;
        }

        return $this->dao->getDetail($postId);

    }

    public function modify($data = array(), $postId = null)
    {
        if (empty($data) || empty($postId)) {
            return false;
        }

        $data['update_date'] = date('Y-m-d H:i:s');
        $permalink = new Speed_Utility_Url();
        $data['permalink'] = $permalink->getUrl($data['title']);
        $authNamespace = new Zend_Session_Namespace('userInformation');
        $data['update_by'] = $authNamespace->userData['user_id'];
        $data['is_published'] = 0;
        $this->dao->modify($data, $postId);
        return true;
    }

    public function changeNovelPublishStatus($data, $novelId)
    {
        if (empty($data) AND (empty($novelId))) {
            return false;
        }

        $data['last_modarate_date'] = date('Y-m-d H:i:s');
        $data['novel_permalink'] = $novelId;

        if ($data['novel_is_published'] == 1) {

            $data['novel_is_published'] = 0;
        } else {
            $data['novel_is_published'] = 1;
        }

        $this->dao->modify($data, $novelId);

        return true;
    }

}

