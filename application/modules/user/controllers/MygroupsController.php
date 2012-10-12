<?php
/**
 * Blog Controller
 * @category        Controller
 * @package         User
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2011
 */
class User_MygroupsController extends Speed_Controller_ActionController
{
    public function init()
    {
        parent::init();
        $userModel                 = new Speed_Model_User();
        $blogModel                 = new Blog_Model_Blog();
        $authNamespace             = new Zend_Session_Namespace('userInformation');
        $userId                    = $authNamespace->userData['user_id'];
        $this->view->selectedPosts = $blogModel->getSelectedPosts();
        $this->view->newBlogger    = $userModel->getAllUsers();
        if (!empty($authNamespace->userData)) {
            $this->view->userProfile = $userModel->getDetail($userId);
        }
        $this->view->recentPosts = $blogModel->getRecentPosts();
        $this->view->userPosts   = $blogModel->getUserPosts($userId);
    }

    public function indexAction()
    {
    }

    public function showAction()
    {
        $this->validateUser();
        $mygroupModel = new User_Model_Mygroup();
        $mygroupId    = $this->_request->getParam('id');
        $mygroup      = $mygroupModel->getAll();
        // $mygroup = $mygroupModel->getDetailForAdmin($mygroupId);
        if (empty($mygroup)) {
            $this->redirectForFailure("/user/mygroups", "Post has been deleted.");
        }
        $this->view->mygroup = $mygroup;
    }

    public function showdetailAction()
    {
        $this->validateUser();
        $detailModel = new User_Model_Mygroup();
        $detailId    = $this->_request->getParam('id');
        $detail      = $detailModel->getDetailForGroup($detailId);
        if (empty($detail)) {
            $this->redirectForFailure("/user/mygroups", "Notice has been deleted.");
        }
        $this->view->detail = $detail;
    }

    public function deleteAction()
    {
        $groupDeleteModel = new User_Model_Mygroup();
        $detailId         = $this->_request->getParam('id');
        $status           = $groupDeleteModel->delete($detailId);
        if ($status) {
            $this->redirectForSuccess("/user/mygroups/show", "Group user deleted Sucessfully.");
        } else {
            $this->redirectForFailure("/user/mygroups/delete/id/{$detailId}", "Something went wrong. Please try again");
        }
    }

    public function validAction()
    {
        $data = array();
        $this->disableLayout();
        $detailId    = $this->_request->getParam('id');
        $detailModel = new User_Model_Mygroup();
        $status      = $detailModel->setPublishStatus($data, $detailId);
        if ($status) {
            $this->redirectForSuccess("/user/mygroups/show", "Mygroup status updated");
        } else {
            $this->redirectForFailure("/user/mygroups", "Something went wrong");
        }
    }
}
