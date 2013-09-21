<?php
/**
 * Blog category Model
 * @category        Model
 * @package         blog
 * @author             Mohammad Zafar Iqbal <zafar@speedplusnet.com >
 * @copyright       Copyright (c) 2012
 */
class Blog_Model_Feedback extends Speed_Model_Abstract
{
    /**
     * @var Blog_Model_Dao_Feedback
     */
    protected $dao;

    public function __construct($dao = null)
    {
        if (empty ($dao)) {
            $this->dao = new Blog_Model_Dao_Feedback();
        } else {
            $this->dao = $dao;
        }
    }

    public function save($data)
    {
        if (empty($data)) {
            return false;
        }
        $data['create_date'] = date('Y-m-d H:i:s');
        $feedbackid          = $this->dao->create($data);
        return $feedbackid;
    }
}
