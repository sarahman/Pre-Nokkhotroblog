<?php

/**
 * Users Controller
 * @category    Controller
 * @package     User
 * Sirajus Salayhin <salayhin@gmail.com>
 */
class User_UsersController extends Speed_Controller_CrudController
{
    /**
     * @var Speed_Model_User
     */
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
        $this->_helper->layout->setLayout('userprofile');
    }

    public function indexAction()
    {
        // $this->view->users = $this->userModel->getSummary();
    }

    public function profileeditAction()
    {
        $this->validateUser();
        $userProfileEntry = new User_Form_ProfileForm();
        $authNamespace    = new Zend_Session_Namespace('userInformation');
        $authNamespace->userData['user_id'];
        if ($this->_request->isPost()) {
            $data                 = $this->_request->getParams();
            $data['display_name'] = stripslashes($this->_request->getParam('display_name'));
            if ($userProfileEntry->isValid($data)) {
                $userUpdateModel = new User_Model_UserProfile();
                $result          = $userUpdateModel->save($data);
                if (empty($result)) {
                    $this->redirectForFailure('/me', 'There was a problem , Please try again.');
                } else {
                    $this->redirectForSuccess("/me", "profile deleted Sucessfully.");
                }
            } else {
                $userProfileEntry->populate($data);
            }
        }
        $this->view->userProfileEntry = $userProfileEntry;
    }

    public function editAction()
    {
        $this->validateAdmin();
        $authNamespace = new Zend_Session_Namespace('userInformation');
        $authNamespace->adminData['user_id'];
        $noticeModel = new Admin_Model_Notice();
        $noticeId    = $this->_request->getParam('id');
        $noticeModel->getDetail($noticeId);
        $noticeForm = new Admin_Form_NoticeEntry(array(
            'isEdit' => true,
            'notice_id' => $noticeId
        ));
        if ($this->_request->isPost()) {
            $data = $this->_request->getParams();
            if ($noticeForm->isValid($data)) {
                $result = $noticeModel->modify($data, $data['notice_id']);
                if (empty($result)) {
                    $this->redirectForFailure("/admin/notice", 'Problem , Please try again.');
                } else {
                    $this->redirectForSuccess("/admin/notice", 'Notice has updated successfully.');
                }
            } else {
                $noticeForm->populate($data);
            }
        } else {
            if (empty($noticeId)) {
                $this->redirectForFailure("/admin/notice", 'Notice has not been found.');
            } else {
                $noticeModel = new Admin_Model_Notice();
                $noticeData  = $noticeModel->getDetailForAdmin($noticeId);
                if (empty($noticeData)) {
                    $this->redirectForFailure("/admin/notice", 'Notice data has not been found');
                } else {
                    $noticeForm->populate($noticeData);
                }
            }
        }
        $this->view->noticeForm = $noticeForm;
    }

    public function code()
    {
        $this->redirectForFailure("http://www.nokkhotroblog.com", '');
    }
}
