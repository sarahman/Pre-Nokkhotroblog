<?php

/**
 * Profiles Controller
 * @category    Controller
 * @package     User
 * @author      Md. Eftakhairul Islam <eftakhairul@gmail.com>
 * @author      Syed Abidur Rahman <aabid048@gmail.com>
 * @author      Md. Sirajus Salayhin <salayhin@gmail.com>
 */
class User_ProfilesController extends Speed_Controller_CrudController
{
    public function init()
    {
        parent::init();
        $this->_helper->layout->setLayout('userprofile');
        $categoryModel        = new Blog_Model_BlogCategory();
        $this->view->Category = $categoryModel->getAll();
        $pageModel            = new Admin_Model_Page();
        $this->view->pages    = $pageModel->getAll();
    }

    protected function initialize()
    {
        $this->view->navBar = 'users-profile';
    }

    public function indexAction()
    {
        $this->validateUser();
        //$userdetailModel = new User_Model_UserProfile();
        $userdetailId = $this->_request->getParam('id');
        $userdetail   = $userdetailModel->getDetailForAdmin($userdetailId);
        if (empty($userdetail)) {
            $this->redirectForFailure("/user/show", "Post has been deleted.");
        }
        $this->view->userdetail = $userdetail;
    }

    public function editProfileAction()
    {
        $id          = $this->_request->getParam('id');
        $userModel   = new Speed_Model_User();
        $userDetails = $userModel->getDetail($id);
    }

    private function getRoles()
    {
        $roleModel = new User_Model_Role();
        $data      = array();
        $roles     = $roleModel->getAll();
        foreach ($roles AS $role)
        {
            $data[$role['role_id']] = $role['title'];
        }
        return $data;
    }
}
