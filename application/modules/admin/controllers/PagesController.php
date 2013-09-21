<?php
/**
 * Pages Controller
 * Pages   Controller
 * @package     Pages
 * @author      Mustafa Ahmed Khan <tamal_29@yahoo.com>
 */
class Admin_PagesController extends Speed_Controller_ActionController
{
    protected function initialize()
    {
        $this->view->navBar = 'pages';
        $this->_helper->layout->setLayout('admin');
        $this->validateAdmin();
    }

    public function indexAction()
    {
        $this->validateAdmin();
        $pageModel           = new Admin_Model_Page();
        $display             = $pageModel->getAll();
        $this->view->display = $display;
    }

    public function addAction()
    {
        $this->validateAdmin();
        $pageEntry = new Admin_Form_PageEntry(array(
            'isEdit' => true
        ));
        if ($this->_request->isPost()) {
            $data               = $this->_request->getParams();
            $data['group_type'] = stripslashes($this->_request->getParam('group_type'));
            if ($pageEntry->isValid($data)) {
                $pageModel = new Admin_Model_Page();
                $result    = $pageModel->save($data);
                if (empty($result)) {
                    $this->redirectForFailure('/admin/pages/add', 'There was a problem , Please try again.');
                } else {
                    $this->redirectForSuccess('/admin/pages/index', 'Page created sucessfully');
                }
            } else {
                $pageEntry->populate($data);
            }
        }
        $this->view->PageEntry = $pageEntry;
    }

    public function editAction()
    {
        $this->validateAdmin();
        $pageModel = new Admin_Model_Page();
        $pageId    = $this->_request->getParam('id');
        $pageModel->getDetail($pageId);
        $pageEntry = new Admin_Form_PageEntry(array(
            'isEdit' => true,
            'page_id' => $pageId
        ));
        if ($this->_request->isPost()) {
            $data = $this->_request->getParams();
            if ($pageEntry->isValid($data)) {
                $result = $pageModel->modify($data, $pageId);
                if (empty($result)) {
                    $this->redirectForFailure('/admin/pages', 'Problem , Please try again.');
                } else {
                    $this->redirectForSuccess('/admin/pages', 'Category has updated successfully.');
                }
            } else {
                $pageEntry->populate($data);
            }
        } else {
            if (empty($pageId)) {
                $this->redirectForFailure('/admin/pages', 'No Category found');
            } else {
                // $pageModel = new Admin_Model_Page();
                $pageData = $pageModel->getDetail($pageId);
                if (empty($pageData)) {
                    $this->redirectForFailure('/admin/pages', 'No Category found.');
                } else {
                    $pageEntry->populate($pageData);
                }
            }
        }
        $this->view->PageEntry = $pageEntry;
    }

    public function trashAction()
    {
        $data                     = array();
        $pageId                   = $this->_request->getParam('id');
        $authNamespace            = new Zend_Session_Namespace('userInformation');
        $adminId                  = $authNamespace->userData['user_id'];
        $data['last_modarate_by'] = $adminId;
        $pageModel                = new Admin_Model_Page();
        $status                   = $pageModel->setTrashStatus($data, $pageId);
        if ($status) {
            $this->redirectForSuccess("/admin/pages/display-trash", "Page has been trashed");
        } else {
            $this->redirectForFailure("/admin/pages/display-trash", "Something went wrong");
        }
    }

    public function displayTrashAction()
    {
        $this->validateAdmin();
        $pageModel           = new Admin_Model_Page();
        $display             = $pageModel->getAllTrash();
        $this->view->display = $display;
    }

    public function deleteAction()
    {
        $this->validateAdmin();
        $pageModel = new Admin_Model_Page();
        $pageId    = $this->_request->getParam('id');
        $status    = $pageModel->delete($pageId);
        if ($status) {
            $this->redirectForSuccess("/admin/pages", "Page deleted Sucessfully.");
        } else {
            $this->redirectForFailure("/admin/pages", "Something went wrong. Please try again");
        }
    }

    //display publish page
    public function showPublishAction()
    {
        $this->validateAdmin();
        $pageModel           = new Admin_Model_Page();
        $display             = $pageModel->getPublish();
        $this->view->display = $display;
    }

    //show detail for a page
    public function showAction()
    {
        $this->validateAdmin();
        $pageModel = new Admin_Model_Page();
        $pageId    = $this->_request->getParam('id');
        $page      = $pageModel->getDetail($pageId);
        if (empty($page)) {
            $this->redirectForFailure("/admin/pages", "Nothing to display.");
        }
        $this->view->page = $page;
    }

    //publish/pending option
    public function pendingAction()
    {
        $data                     = array();
        $pageId                   = $this->_request->getParam('id');
        $authNamespace            = new Zend_Session_Namespace('adminInformation');
        $adminId                  = $authNamespace->adminData['admin_id'];
        $data['last_moderate_by'] = $adminId;
        $pageModel                = new Admin_Model_Page();
        $status                   = $pageModel->setPendingStatus($data, $pageId);
        if ($status) {
            $this->redirectForSuccess("/admin/pages/show/id/{$pageId}", "Page status updated");
        } else {
            $this->redirectForFailure("/admin/pages/show/id/{$pageId}", "Something went wrong");
        }
    }
}
