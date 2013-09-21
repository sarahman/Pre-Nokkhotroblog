<?php
/**
 * Group Type Controller
 * @Group Type   Controller
 * @package     Admin
 * @author      Md. Sirajus Salayhin <salayhin@gmail.com>
 */
class Admin_BlogGroupTypesController extends Speed_Controller_ActionController
{
    protected $group;

    protected function initialize()
    {
        $this->view->navBar = 'post';
        $this->_helper->layout->setLayout('admin');
        $this->validateAdmin();
    }

    public function indexAction()
    {
        $this->validateAdmin();
        $groupModel          = new Admin_Model_BlogGroupType();
        $display             = $groupModel->getAll();
        $this->view->display = $display;
    }

    public function editAction()
    {
        $this->validateAdmin();
        $groupModel = new Admin_Model_BlogGroupType();
        $groupId    = $this->_request->getParam('id');
        $groupModel->getDetail($groupId);
        $groupEntry = new Admin_Form_BlogGroupTypesEntry(array(
            'isEdit' => true,
            'post_type' => $groupId
        ));
        if ($this->_request->isPost()) {
            $data = $this->_request->getParams();
            if ($groupEntry->isValid($data)) {
                $result = $groupModel->modify($data, $data['blog_group_type_id']);
                if (empty($result)) {
                    $this->redirectForFailure('/admin/blog-group-types', 'Problem , Please try again.');
                } else {
                    $this->redirectForSuccess('/admin/blog-group-types', 'Blog group type has been updated successfully.');
                }
            } else {
                $groupEntry->populate($data);
            }
        } else {
            if (empty($groupId)) {
                $this->redirectForFailure('/blog-group-types/index', 'No Post found');
            } else {
                $groupModel = new Admin_Model_BlogGroupType();
                $groupData  = $groupModel->getDetail($groupId);
                if (empty($groupData)) {
                    $this->redirectForFailure('/blog-group-types/index', 'No Post found.');
                } else {
                    $groupEntry->populate($groupData);
                }
            }
        }
        $this->view->GroupEntry = $groupEntry;
    }

    public function deleteAction()
    {
        $this->validateAdmin();
        $groupModel = new Admin_Model_BlogGroupType();
        $groupId    = $this->_request->getParam('id');
        $status     = $groupModel->delete($groupId);
        if ($status) {
            $this->redirectForSuccess("/admin/blog-group-types", "Blog group type deleted Sucessfully.");
        } else {
            $this->redirectForFailure("/admin/blog-group-types/", "Something went wrong. Please try again");
        }
    }

    public function addAction()
    {
        $this->validateAdmin();
        $groupEntry = new Admin_Form_BlogGroupTypesEntry();
        if ($this->_request->isPost()) {
            $data               = $this->_request->getParams();
            $data['group_type'] = stripslashes($this->_request->getParam('group_type'));
            if ($groupEntry->isValid($data)) {
                $groupModel = new Admin_Model_BlogGroupType();
                $result     = $groupModel->save($data);
                if (empty($result)) {
                    $this->redirectForFailure('/admin/blog-group-types/index', 'There was a problem , Please try again.');
                } else {
                    $this->redirectForSuccess('/admin/blog-group-types/index', 'Blog group type inserted sucessfully');
                }
            } else {
                $groupEntry->populate($data);
            }
        }
        $this->view->GroupEntry = $groupEntry;
    }
}
