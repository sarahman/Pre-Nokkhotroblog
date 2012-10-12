<?php
/**
 * Created by JetBrains PhpStorm.
 * User: salayhin
 * Date: 6/16/12
 * Time: 1:29 AM
 * To change this template use File | Settings | File Templates.
 */
class Admin_AdminTrashsController extends Speed_Controller_ActionController
{
    protected $blogModel;

    protected function initialize()
    {
        $this->view->navBar = 'admins';
        $this->_helper->layout->setLayout('admin');
        $this->validateAdmin();
    }

    public function indexAction()
    {
        $this->validateAdmin();
    }

    public function trashBlogAction()
    {
        $this->validateAdmin();
        $blogTrashModel       = new Admin_Model_Blog();
        $displayp             = $blogTrashModel->getAllTrash();
        $this->view->displayp = $displayp;
    }

    public function trashEpisodeAction()
    {
        $this->validateAdmin();
        $blogTrashModel      = new Admin_Model_Blog();
        $display             = $blogTrashModel->getAllEpisodeTrash();
        $this->view->display = $display;
    }

    public function trashDiscussionAction()
    {
        $this->validateAdmin();
        $discussionModel     = new Admin_Model_Discussion();
        $display             = $discussionModel->getAllDiscussionTrash();
        $this->view->display = $display;
    }

    public function trashAction()
    {
        $data = array();
        $this->disableLayout();
        $userId             = $this->_request->getParam('id');
        $blogModel          = new Admin_Model_Blog();
        $status             = $blogModel->setTrashStatus($data, $userId);
        $this->view->status = $status;
        if ($status) {
            $this->redirectForSuccess("/admin/blogs/index/id/{$userId}", "User select Blog status updated");
        } else {
            $this->redirectForFailure("/admin/blogs/index/id/{$userId}", "Something went wrong");
        }
    }

    public function deleteAction()
    {
        $this->validateAdmin();
        $posttypeDeleteModel = new Admin_Model_Blog();
        $postId              = $this->_request->getParam('id');
        $status              = $posttypeDeleteModel->delete($postId);
        if ($status) {
            $this->redirectForSuccess('/admin/blogs/index', "Admin User deleted Blog Sucessfully.");
        } else {
            $this->redirectForFailure('/admin/blogs/index', "Something went wrong. Please try again");
        }
    }

    // For trash Comment Sep22 MOHAMMAD ZAFAR IQBAL
    public function trashCommentAction()
    {
        $this->validateAdmin();
        $discussionModel     = new Admin_Model_BlogComment();
        $display             = $discussionModel->getAllCommentTrash();
        $this->view->display = $display;
    }

    public function ctrashAction()
    {
        $data = array();
        $this->disableLayout();
        $userId             = $this->_request->getParam('id');
        $blogModel          = new Admin_Model_BlogComment();
        $status             = $blogModel->setTrashStatus($data, $userId);
        $this->view->status = $status;
        if ($status) {
            $this->redirectForSuccess("/admin/blogs/index/id/{$userId}", "User select Blog status updated");
        } else {
            $this->redirectForFailure("/admin/blogs/index/id/{$userId}", "Something went wrong");
        }
    }
}

        

