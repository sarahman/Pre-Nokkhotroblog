<?php
/**
 * Discussion  Controller
 * Discussion   Controller
 * @package     Discussion
 * @author      Mustafa Ahmed Khan <tamal_29@yahoo.com>
 */
class Blog_DiscussionCommentsController extends Speed_Controller_ActionController
{
    protected function initialize()
    {
        $categoryModel        = new Blog_Model_BlogCategory();
        $this->view->Category = $categoryModel->getAll();
        $pageModel            = new Admin_Model_Page();
        $this->view->pages    = $pageModel->getAll();
    }

    public function indexAction()
    {
        $this->disableLayout();
        $this->_helper->layout->setLayout('userprofile');
        $discussionId           = $this->_request->getParam('id');
        $discussioncommentModel = new Blog_Model_DiscussionComment();
        $comment                = $discussioncommentModel->getAll($discussionId);
        $this->view->comment    = $comment;
    }

    public function addAction()
    {
        $this->validateUser();
        $this->_helper->layout->setLayout('userprofile');
        $discussionId = $this->_request->getParam('id');
        $options      = array(
            'isEdit' => false,
            'discussion_id' => $discussionId
        );
        $commentForm  = new Blog_Form_DiscussionComment($options);
        if ($this->_request->isPost()) {
            $data = $this->_request->getParams();
            if ($commentForm->isValid($data)) {
                $discussioncommentModel = new Blog_Model_DiscussionComment();
                $result                 = $discussioncommentModel->save($data, $discussionId);
                if (empty($result)) {
                    $this->redirectForFailure('/blog/discussion-comments/index', "There was a problem , Please try again.");
                } else {
                    $this->redirectForSuccess('/blog/discussions/index', "Your Comment is submitted.");
                }
            } else {
                $commentForm->populate($data);
            }
        }
        $this->view->commentForm = $commentForm;
    }
}
