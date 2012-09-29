<?php
/**
 * Draft Controller
 *
 * @category        Controller
 * @package         User
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2011
 */
class User_TrashController extends Speed_Controller_ActionController
{
    public function init()
    {
        parent::init();
        $this->_helper->layout->setLayout('userprofile');
        $categoryModel = new Blog_Model_BlogCategory();
        $this->view->Category   = $categoryModel->getAll();
        $pageModel = new Admin_Model_Page();
        $this->view->pages = $pageModel->getAll();
        
    }
    protected function initialize()
    {
        $this->_helper->layout->setLayout('userprofile');
    }

    public function indexAction()
    {
        $userdetailModel = new Speed_Model_User();

        $authNamespace = new Zend_Session_Namespace('userInformation');
         $userName = $authNamespace->userData['username'];
        $userDetail = $userdetailModel->getDetailByUserName($userName);

        if (!empty ($authNamespace->userData['username'])) {
            $userId = $authNamespace->userData['user_id'];
        }

        $id = $this->_request->getParam('id');

        if (!empty ($id)) {
            $userId = $id;
        }

        $trashModel = new User_Model_Trash();

        $draft = $trashModel->getAll();

        if (empty($draft)) {
            $this->redirectForFailure("/user/draft/index", "No post publish yet");
        } else {
            $this->view->TrashPosts = $draft;
           $this->view->userDetail = $userDetail;

        }

    }

   public function deleteAction()
    {
        $this->validateUser();
        $draftModel = new Blog_Model_Draft();
        
        $draftId = $this->_request->getParam('id');

        $status = $draftModel->delete($draftId);

        if ($status) {
            $this->redirectForSuccess('/user/draft/index', "'Draft has been deleted Sucessfully.");
        } else {
            $this->redirectForFailure('/me', "Something went wrong. Please try again");
        }
    }
    
    // Trash Action
     public function trashAction()
    {
        $data = array();

        $this->disableLayout();

        $blogId = $this->_request->getParam('id');

        $authNamespace = new Zend_Session_Namespace('userInformation');
        $adminId = $authNamespace->userData['user_id'];

        $data['last_modarate_by'] = $adminId;

      //  $blogModel = new Admin_Model_Blog();
        $trashModel = new Blog_Model_Draft();
        $status = $trashModel->setTrashStatus($data, $blogId);

        if ($status) {
            $this->redirectForSuccess("/user/draft/index/id/{$blogId}", "Blog status updated");
        } else {
            $this->redirectForFailure("/user/draft/index/id/{$blogId}", "Something went wrong");
        }

    }
    
    

// Trash Action
     public function trashdiscussionAction()
    {
        $data = array();

        $this->disableLayout();

        $blogId = $this->_request->getParam('id');

        $authNamespace = new Zend_Session_Namespace('userInformation');
        $adminId = $authNamespace->userData['user_id'];

        $data['last_modarate_by'] = $adminId;

      //  $blogModel = new Admin_Model_Blog();
        $discussiontrashModel = new Blog_Model_Discussion();
       // $trashModel = new Blog_Model_Draft();
        $status = $discussiontrashModel->setTrashStatus($data, $blogId);

        if ($status) {
            $this->redirectForSuccess("/blog/discussions/display-draft/id/{$blogId}", "Blog status updated");
        } else {
            $this->redirectForFailure("/blog/discussions/display-draft/id/{$blogId}", "Something went wrong");
        }

    }



}
