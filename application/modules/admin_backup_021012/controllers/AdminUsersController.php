<?php
/**
 * Created by JetBrains PhpStorm.
 * User: salayhin
 * Date: 6/16/12
 * Time: 1:29 AM
 * To change this template use File | Settings | File Templates.
 */
class Admin_AdminUsersController extends Speed_Controller_ActionController
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

        $blogDisplayModel = new Admin_Model_AdminUser();

        $display = $blogDisplayModel->getAll();


        $this->view->display = $display;
    }

    public function showAction()
    {
        $this->validateAdmin();

        $blogModel = new Admin_Model_AdminUser();
        $userId = $this->_request->getParam('id');

        $displayp = $blogModel->getDetailForAdmin($userId);

        $this->view->displayp = $displayp;
    }

    public function addAction()

    {
        $options = array(
            'isEdit' => false
        );

        $adminForm = new Admin_Form_AdminUser($options);

        if ($this->_request->isPost()) {

            $data = $this->_request->getParams();

            if ($adminForm->isValid($data)) {

                $userModel = new Admin_Model_AdminUser();

                $result = $userModel->save($data);
                if (empty($result)) {
                    $this->redirectForFailure('/admin/auth/login', "There was a problem , Please try again.");
                } else {


                    $this->redirectForSuccess('/admin/admin-users', "Your registration is complete. Please sign in here.");
                }

            } else {
                $adminForm->populate($data);
            }
        }


        $this->view->adminForm = $adminForm;

    }

    public function deleteAction()
    {
        $this->validateAdmin();
        $posttypeDeleteModel = new Admin_Model_AdminUser();

        $postId = $this->_request->getParam('id');

        $status = $posttypeDeleteModel->delete($postId);

        if ($status) {
            $this->redirectForSuccess('/admin/admin-users', "Admin User deleted Sucessfully.");
        } else {
            $this->redirectForFailure('/admin/admin-users/', "Something went wrong. Please try again");
        }
    }

    //Edit
    public function editAction()
    {
        $this->validateAdmin();
        $posttypeModel = new Admin_Model_AdminUser();
        $postId = $this->_request->getParam('id');
        $posttypeModel->getDetail($postId);
        $options = array(
            'isEdit' => true,
            'admin_id' => $postId
        );
        $postEntry = new Admin_Form_AdminUser($options);


        if ($this->_request->isPost()) {
            $data = $this->_request->getParams();
            if ($postEntry->isValid($data)) {
                $result = $posttypeModel->modify($data, $postId);
                if (empty($result)) {
                    $this->redirectForFailure('/admin/admin-users', 'Problem , Please try again.');
                } else {
                    $this->redirectForSuccess('/admin/admin-users', 'Admin has updated successfully.');
                }
            } else {
                $postEntry->populate($data);
            }
        } else {

            if (empty($postId)) {
                $this->redirectForFailure('/admin/admin-users', 'No Post found');
            } else {
                $posttypeModel = new Admin_Model_AdminUser();
                $postData = $posttypeModel->getDetail($postId);
                if (empty($postData)) {
                    $this->redirectForFailure('/admin/admin-users', 'No Post found.');
                } else {
                    $postEntry->populate($postData);
                }
            }
        }
        $this->view->PostEntry = $postEntry;

    }


    public function selectstatusAction()
    {
        $data = array();

        $this->disableLayout();

        $userId = $this->_request->getParam('id');

        $blogModel = new Admin_Model_AdminUser();
        $status = $blogModel->setSelectStatus($data, $userId);
        $this->view->status = $status;

        if ($status) {
            $this->redirectForSuccess("/admin/admin-users/show/id/{$userId}", "User select status updated");
        } else {
            $this->redirectForFailure("/admin/admin-users/show/id/{$userId}", "Something went wrong");
        }

    }
}

        

