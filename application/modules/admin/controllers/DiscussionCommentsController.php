<?php
/**
 * Discussion Controller
 * Discussion   Controller
 * @package     Discussion
 * @author      Mustafa Ahmed Khan <tamal_29@yahoo.com>
 */
class Admin_DiscussionCommentsController extends Speed_Controller_ActionController
{
    protected function initialize()
    {
        $this->view->navBar = 'admins';
        $this->_helper->layout->setLayout('admin');
        $this->validateAdmin();
    }

    public function indexAction()
    {
        $this->validateAdmin();
        $discussioncommentModel = new Admin_Model_DiscussionComment();
        $display                = $discussioncommentModel->getAll();
        $this->view->display    = $display;
    }

    public function deleteAction()
    {
        $this->validateAdmin();
        $discussionModel = new Admin_Model_DiscussionComment();
        $discussionId    = $this->_request->getParam('id');
        $status          = $discussionModel->delete($discussionId);
        if ($status) {
            $this->redirectForSuccess("/admin/discussion-comments/index", "Comments deleted Sucessfully.");
        } else {
            $this->redirectForFailure("/admin/discussion-comments/index", "Comments went wrong. Please try again");
        }
    }

    public function showAction()
    {
        $this->validateAdmin();
        $discussioncommentModel = new Admin_Model_DiscussionComment();
        $discussioncommentId    = $this->_request->getParam('id');
        $discussioncomment      = $discussioncommentModel->getDetailForAdmin($discussioncommentId);
        if (empty($discussioncomment)) {
            $this->redirectForFailure("/admin/discussion-comments", "Discussion comments has been deleted.");
        }
        $this->view->discussioncomment = $discussioncomment;
    }

    public function publishAction()
    {
        $data              = array();
        $discussionId      = $this->_request->getParam('id');
        $authNamespace     = new Zend_Session_Namespace('adminInformation');
        $adminId           = $authNamespace->adminData['admin_id'];
        $data['update_by'] = $adminId;
        $discussionModel   = new Admin_Model_DiscussionComment();
        $status            = $discussionModel->setPublishStatus($data, $discussionId);
        if ($status) {
            $this->redirectForSuccess("/admin/discussion-comments/show/id/{$discussionId}", "Discussion status updated");
        } else {
            $this->redirectForFailure("/admin/discussion-comments/show/id/{$discussionId}", "Something went wrong");
        }
    }
}
