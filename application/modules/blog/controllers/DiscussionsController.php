<?php
/**
 * Discussion Controller
 * Discussion   Controller
 * @package     Discussion
 * @author      Mustafa Ahmed Khan <tamal_29@yahoo.com>
 */
class Blog_DiscussionsController extends Speed_Controller_ActionController
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
        $this->validateUser();
        $this->_helper->layout->setLayout('userprofile');
        $discussionModel         = new Blog_Model_Discussion();
        $userModel               = new Speed_Model_User();
        $userData                = $this->_request->getParams();
        $userDetail              = $userModel->getDetailByUsername($userData['username']);
        $display                 = $discussionModel->getAll();
        $this->view->discussions = $display;
        $this->view->userDetail  = $userDetail;
    }

    public function addAction()
    {
        $this->validateUser();
        $this->_helper->layout->setLayout('userprofile');
        $blogstatus      = new Blog_Model_BlogStatus();
        $discussionEntry = new Blog_Form_DiscussionEntry(array(
            'status' => $blogstatus->getSelected(),
            'isEdit' => true
        ));
        if ($this->_request->isPost()) {
            $data               = $this->_request->getParams();
            $data['group_type'] = stripslashes($this->_request->getParam('group_type'));
            if ($discussionEntry->isValid($data)) {
                $discussionModel = new Blog_Model_Discussion();
                $result          = $discussionModel->save($data);
                if (empty($result)) {
                    $this->redirectForFailure('/blog/discussions/index', 'There was a problem , Please try again.');
                } else {
                    $this->redirectForSuccess('/blog/discussions/index', 'Discussion inserted sucessfully');
                }
            } else {
                $discussionEntry->populate($data);
            }
        }
        $this->view->DiscussionEntry = $discussionEntry;
    }

    public function editAction()
    {
        $this->validateUser();
        $this->_helper->layout->setLayout('userprofile');
        $posttypeModel = new Blog_Model_Discussion();
        $postId        = $this->_request->getParam('id');
        $posttypeModel->getDetail($postId);
        $blogstatus = new Blog_Model_BlogStatus();
        $options    = array(
            'status' => $blogstatus->getSelected(),
            'isEdit' => true,
            'discussion_id' => $postId
        );
        $postEntry  = new Blog_Form_DiscussionEntry($options);
        if ($this->_request->isPost()) {
            $data = $this->_request->getParams();
            if ($postEntry->isValid($data)) {
                $result = $posttypeModel->modify($data, $postId);
                if (empty($result)) {
                    $this->redirectForFailure('/blog/discussions/index', 'Problem , Please try again.');
                } else {
                    $this->redirectForSuccess('/blog/discussions/index', 'Discussions has updated successfully.');
                }
            } else {
                $postEntry->populate($data);
            }
        } else {
            if (empty($postId)) {
                $this->redirectForFailure('/blog/discussions', 'No Post found');
            } else {
                $posttypeModel = new Blog_Model_Discussion();
                $postData      = $posttypeModel->getDetail($postId);
                if (empty($postData)) {
                    $this->redirectForFailure('/blog/discussions', 'No Post found.');
                } else {
                    $postEntry->populate($postData);
                }
            }
        }
        $this->view->PostEntry = $postEntry;
    }

    public function deleteAction()
    {
        $this->validateUser();
        $this->_helper->layout->setLayout('userprofile');
        $discussionModel = new Blog_Model_Discussion();
        $discussionId    = $this->_request->getParam('id');
        $status          = $discussionModel->delete($discussionId);
        if ($status) {
            $this->redirectForSuccess("/blog/discussions/index", "Discussions deleted Sucessfully.");
        } else {
            $this->redirectForFailure("/blog/discussions/index", "Discussions went wrong. Please try again");
        }
    }

    public function showAction()
    {
        $this->validateUser();
        $this->_helper->layout->setLayout('userprofile');
        $discussionModel = new Blog_Model_Discussion();
        $discussionId    = $this->_request->getParam('id');
        $discussion      = $discussionModel->getDetailForAdmin($discussionId);
        if (empty($discussion)) {
            $this->redirectForFailure("/blog/discussions", "Discussions has been deleted.");
        }
        $this->view->discussion = $discussion;
    }

    public function commentAction()
    {
        $this->_helper->layout->setLayout('userprofile');
        $this->validateUser();
        $discussionModel     = new Blog_Model_Discussion();
        $display             = $discussionModel->getDetailForComment();
        $this->view->display = $display;
    }

    public function displayDraftAction()
    {
        $userdetailModel = new Speed_Model_User();
        $authNamespace   = new Zend_Session_Namespace('userInformation');
        $userName        = $authNamespace->userData['username'];
        $userDetail      = $userdetailModel->getDetailByUserName($userName);
        $this->validateUser();
        $this->_helper->layout->setLayout('userprofile');
        $discussionModel        = new Blog_Model_Discussion();
        $display                = $discussionModel->getDraftl();
        $this->view->draft      = $display;
        $this->view->userDetail = $userDetail;
    }

    // Trash Action Display
    public function trashDiscussionAction()
    {
        $userdetailModel = new Speed_Model_User();
        $authNamespace   = new Zend_Session_Namespace('userInformation');
        $userName        = $authNamespace->userData['username'];
        $userDetail      = $userdetailModel->getDetailByUserName($userName);
        $this->validateUser();
        $this->_helper->layout->setLayout('userprofile');
        $trashModel                  = new Blog_Model_Discussion();
        $status                      = $trashModel->getAllTrash();
        $this->view->Discussiontrash = $status;
        $this->view->userDetail      = $userDetail;
    }

    // Trash Action
    public function trashAction()
    {
        $data = array();
        $this->disableLayout();
        $blogId                   = $this->_request->getParam('id');
        $authNamespace            = new Zend_Session_Namespace('userInformation');
        $adminId                  = $authNamespace->userData['user_id'];
        $data['last_modarate_by'] = $adminId;
        $trashModel               = new Blog_Model_Discussion();
        $status                   = $trashModel->setTrashStatus($data, $blogId);
        if ($status) {
            $this->redirectForSuccess("/user/draft/index/id/{$blogId}", "Blog status updated");
        } else {
            $this->redirectForFailure("/user/draft/index/id/{$blogId}", "Something went wrong");
        }
    }
}
