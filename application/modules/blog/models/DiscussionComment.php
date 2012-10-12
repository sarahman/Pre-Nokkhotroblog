<?php
/**
 * DiscussionComment Model
 * @category        Model
 * @package         blog
 * @author          Mohammad Zafar Iqbal <zafarmba10104014@gmail.com>
 * @copyright       Copyright (c) 2011
 */
class Blog_Model_DiscussionComment extends Speed_Model_Abstract
{
    /**
     * @var Blog_Model_Dao_DiscussionComment
     */
    protected $dao;

    public function __construct($dao = null)
    {
        if (empty ($dao)) {
            $this->dao = new Blog_Model_Dao_DiscussionComment();
        } else {
            $this->dao = $dao;
        }
    }

    public function getAll($discussionId)
    {
        return $this->dao->getAll($discussionId);
    }

    public function save($data, $discussionId)
    {
        if (empty($data) || empty($data)) {
            return false;
        }
        $data['discussion_id'] = $discussionId;
        $data['create_date']   = date('Y-m-d H:i:s');
        $authNamespace         = new Zend_Session_Namespace('userInformation');
        $data['create_by']     = $authNamespace->userData['user_id'];
        $postId                = $this->dao->create($data);
        return $postId;
    }
}

