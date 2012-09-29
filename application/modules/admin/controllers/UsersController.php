<?php
/**
 * users Controller
 *
 * @users    Controller
 * @package     Admin
 * @author      Md. Sirajus Salayhin <salayhin@gmail.com>
 */
class Admin_UsersController extends Speed_Controller_ActionController
{
    protected $blogModel;

    protected function initialize()
    {
        $this->view->navBar = 'user';
        $this->_helper->layout->setLayout('admin');
        $this->validateAdmin();
    }

    public function indexAction()
    {
        $this->validateAdmin();
        $userDisplayModel = new Admin_Model_User();
        $display = $userDisplayModel->getAll();
        $this->view->display = $display;

    }

    public function showAction()
    {
        $this->validateAdmin();

        $userModel = new Admin_Model_User();
        $userId = $this->_request->getParam('id');

        $user = $userModel->getDetailForAdmin($userId);

        if (empty($user)) {
            $this->redirectForFailure("/admin/users/show/id/{$userId}", "Notice has been deleted.");
        }

        $this->view->user = $user;
    }


    public function deleteAction()
    {
        $userDeleteModel = new Admin_Model_User();

        $userId = $this->_request->getParam('id');

        $status = $userDeleteModel->delete($userId);

        if ($status) {
            $this->redirectForSuccess("/admin/users", "User deleted Sucessfully.");
        } else {
            $this->redirectForFailure("/admin/users", "Something went wrong. Please try again");
        }
    }


    public function validAction()
    {
        $data = array();

        $this->disableLayout();

        $userId = $this->_request->getParam('id');

        $authNamespace = new Zend_Session_Namespace('adminInformation');

        $adminId = $authNamespace->adminData['admin_id'];

        $userModel = new Admin_Model_User();
        $status = $userModel->setPublishStatus($data, $userId);

        if ($status) {
            $this->redirectForSuccess("/admin/users/show/id/{$userId}", "Notice status updated");
        } else {
            $this->redirectForFailure("/admin/users/show/id/{$userId}", "Something went wrong");
        }

    }


    public function bannedAction()
    {
        $data = array();

        $this->disableLayout();

        $userId = $this->_request->getParam('id');

        $authNamespace = new Zend_Session_Namespace('adminInformation');
        $adminId = $authNamespace->adminData['admin_id'];

        $userModel = new Admin_Model_User();
        $status = $userModel->setBannedStatus($data, $userId);

        if ($status) {
            $this->redirectForSuccess("/admin/users/show/id/{$userId}", "Notice status updated");
        } else {
            $this->redirectForFailure("/admin/users/show/id/{$userId}", "Something went wrong");
        }

    }

}
