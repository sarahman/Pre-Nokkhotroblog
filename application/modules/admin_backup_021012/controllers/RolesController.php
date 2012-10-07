<?php
/**
 * Admin Controller
 *
 * @roles Controller
 * @package Admin
 * @author Md. Sirajus Salayhin <salayhin@gmail.com>
 */

class Admin_RolesController extends Speed_Controller_ActionController
{
    protected $postModel;			//$blogModel;

    protected function initialize()
    {
        $this->view->navBar = 'roles';
        $this->_helper->layout->setLayout('admin');
        $this->validateAdmin();
    }

    public function indexAction()
    {
        $this->validateAdmin();
        $roleModel = new Admin_Model_Role();			//$userDisplayModel
        $display = $roleModel->getAll();			//$display = $userDisplayModel->getAll();
        $this->view->display = $display;

    }
    
    public function editAction()
    {
        $this->validateAdmin();
        $roleModel = new Admin_Model_Role();			//$blogCategoryModel 
        $roleId = $this->_request->getParam('id');		//$categoryId 
        $roleModel->getDetail($roleId);			//$blogCategoryModel->getDetail($categoryId);
        $roleEntry = new Admin_Form_RoleEntry(array(		//$categoryEntry
            'isEdit' => true,
            'role' => $roleId		//$categoryId
        ));

        if ($this->_request->isPost()) {
            $data = $this->_request->getParams();
            if ($roleEntry->isValid($data)) {		//if ($categoryEntry->isValid($data))
                $result = $roleModel->modify($data, $data['role_id']);		//$blogCategoryModel->modify	$categoryId
                if (empty($result)) {
                    $this->redirectForFailure('/admin/roles','Problem , Please try again.');
                } else {
                    $this->redirectForSuccess('/admin/roles','Role has updated successfully.');
                }
            } else {
                $roleEntry->populate($data);		//$categoryEntry
            }
        } else {

            if (empty($roleId)) {			//if (empty($categoryId))
                $this->redirectForFailure('/roles/index','No Category found');
            } else {
                $categoryModel = new Admin_Model_Role();
                $categoryData = $categoryModel->getDetail($roleId);		//getDetail($categoryId);
                if (empty($categoryData)) {
                    $this->redirectForFailure('/roles/index','No Category found.');
                } else {
                    $roleEntry->populate($categoryData);		//$categoryEntry
                }
            }
        }
        $this->view->RoleEntry = $roleEntry;			//$categoryEntry;

    }
    
    public function addAction()
    {
        $this->validateAdmin();

        $roleEntry = new Admin_Form_RoleEntry();		//$categoryEntry

        if ($this->_request->isPost()) {

            $data = $this->_request->getParams();
            $data['role'] = stripslashes($this->_request->getParam('role'));


            if ($roleEntry->isValid($data)) {			//if ($categoryEntry->isValid($data))

                $categoryModel = new Admin_Model_Role();

                $result = $categoryModel->save($data);
                if (empty($result)) {
                    $this->redirectForFailure('/admin/roles/index','There was a problem , Please try again.');
                } else {

                    $this->redirectForSuccess('/admin/roles/index','Role Posted sucessfully');
                }

            } else {
                $roleEntry->populate($data);		// $categoryEntry
            }
        }

        $this->view->RoleEntry = $roleEntry;		//$categoryEntry;

    }



    public function deleteAction()
    {
        $userDeleteModel = new Admin_Model_Role();

        $role_id = $this->_request->getParam('id');

        $status = $userDeleteModel->delete($role_id);

        if ($status) {
            $this->redirectForSuccess("/admin/roles", "Role deleted Sucessfully.");
        } else {
            $this->redirectForFailure("/admin/roles", "Something went wrong. Please try again");
        }
    }

}
