<?php

/**
 * Blog Controller
 * @category        Controller
 * @package         Blog
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2011
 */
class Admin_NovelsController extends Speed_Controller_ActionController
{
    protected $blogModel;

    protected function initialize()
    {
        $this->_helper->layout->setLayout('admin');
        $this->validateAdmin();
    }

    public function indexAction()
    {
        $noveDisplayModel       = new Admin_Model_NovelName();
        $noveldisplay           = $noveDisplayModel->getAll();
        $this->view->novelNames = $noveldisplay;
    }

    public function showAction()
    {
        $novelModel        = new Admin_Model_Novel();
        $data              = $this->_request->getParams();
        $novelDetail       = $novelModel->getDetail($data['id']);
        $this->view->novel = $novelDetail;
    }

    public function novelPostAction()
    {
        $novelModel            = new Admin_Model_Novel();
        $novelNameModel        = new Admin_Model_NovelName();
        $novelId               = $this->_request->getParam('id');
        $novel                 = $novelNameModel->getDetail($novelId);
        $novels                = $novelModel->getNovelDetail($novel['novel_name_id']);
        $this->view->novels    = $novels;
        $this->view->novelname = $novelId;
    }

    public function myNovelListAction()
    {
        $this->_helper->layout->setLayout('userprofile');
        $novelModel             = new Blog_Model_NovelName();
        $userModel              = new Speed_Model_User();
        $username               = $this->_request->getParam('username');
        $userDetail             = $userModel->getDetailByUsername($username);
        $myNovels               = $novelModel->myNovel($userDetail['user_id']);
        $this->view->novelNames = $myNovels;
        $this->view->blogInfo   = $userDetail;
    }

    public function myNovelPostAction()
    {
        $this->_helper->layout->setLayout('userprofile');
        $novelModel            = new Blog_Model_Novel();
        $userModel             = new Speed_Model_User();
        $novelNameModel        = new Blog_Model_NovelName();
        $data                  = $this->_request->getParams();
        $novel                 = $novelNameModel->getDetailByNovelPermalink($data['permalink']);
        $userDetail            = $userModel->getDetailByUsername($data['username']);
        $novels                = $novelModel->getNovelDetail($novel['novel_name_id']);
        $this->view->blogInfo  = $userDetail;
        $this->view->novels    = $novels;
        $this->view->novelname = $data;
    }

    public function myNovelPostDetailAction()
    {
        $this->_helper->layout->setLayout('userprofile');
        $novelModel           = new Blog_Model_Novel();
        $userModel            = new Speed_Model_User();
        $data                 = $this->_request->getParams();
        $novelDetail          = $novelModel->getSingleNovelEntry($data['permalink']);
        $userDetail           = $userModel->getDetailByUsername($data['username']);
        $this->view->novel    = $novelDetail;
        $this->view->blogInfo = $userDetail;
    }

    public function addAction()
    {
        $this->_helper->layout->setLayout('userprofile');
        $this->validateUser();
        $novelNameModel = new Blog_Model_NovelName();
        $linkData       = $this->_request->getParams();
        $userModel      = new Speed_Model_User();
        $userDetail     = $userModel->getDetailByUsername($linkData['username']);
        $novel          = $novelNameModel->getDetailByNovelPermalink($linkData['name']);
        $novelForm      = new Blog_Form_NovelForm($options = array('isEdit' => false));
        if ($this->_request->isPost()) {
            $data                  = $this->_request->getParams();
            $data['novel_name_id'] = $novel['novel_name_id'];
            if ($novelForm->isValid($data)) {
                $novelModel = new Blog_Model_Novel();
                $result     = $novelModel->save($data);
                if (empty($result)) {
                    $this->redirectForFailure("/{$linkData['username']}/novel-list", "There was a problem , Please try again.");
                } else {
                    $this->redirectForSuccess("/{$linkData['username']}/novel-list", "Your Novel is Submited.");
                }
            } else {
                $novelForm->populate($data);
            }
        }
        $this->view->NovelForm = $novelForm;
        $this->view->blogInfo  = $userDetail;
    }

    public function addNameAction()
    {
        $this->_helper->layout->setLayout('userprofile');
        $this->validateUser();
        $authNamespace = new Zend_Session_Namespace('userInformation');
        $username      = $authNamespace->userData['username'];
        $userModel     = new Speed_Model_User();
        $userDetail    = $userModel->getDetailByUsername($username);
        $options       = array(
            'isEdit' => false
        );
        $novelForm     = new Blog_Form_NovelName($options);
        if ($this->_request->isPost()) {
            $data = $this->_request->getParams();
            if ($novelForm->isValid($data)) {
                $noveNamelModel = new Blog_Model_NovelName();
                $result         = $noveNamelModel->save($data);
                if (empty($result)) {
                    $this->redirectForFailure('/novels/name/new', "There was a problem , Please try again.");
                } else {
                    $this->redirectForSuccess('/novels/name/new', "Your Novel Name was submitted.");
                }
            } else {
                $novelForm->populate($data);
            }
        }
        $this->view->novelForm = $novelForm;
        $this->view->blogInfo  = $userDetail;
    }

    public function deleteAction()
    {
        $novelModel  = new Admin_Model_Novel();
        $data        = $this->_request->getParams();
        $novelDetail = $novelModel->getDetail($data['id']);
        $status      = $novelModel->delete($novelDetail['novel_id']);
        if ($status) {
            $this->redirectForSuccess('/admin/novels', "'Novel has been deleted Sucessfully.");
        } else {
            $this->redirectForFailure('/admin/novels', "Something went wrong. Please try again");
        }
    }

    public function editAction()
    {
        $novelModel  = new Admin_Model_Novel();
        $novelData   = $this->_request->getParams();
        $novelDetail = $novelModel->getDetail($novelData['id']);
        $options     = array(
            'isEdit' => true,
            'novel_id' => $novelDetail['novel_id']
        );
        $postEntry   = new Admin_Form_NovelForm($options);
        if ($this->_request->isPost()) {
            $data = $this->_request->getParams();
            if ($postEntry->isValid($data)) {
                $result = $novelModel->modify($data, $novelDetail['novel_id']);
                if (empty($result)) {
                    $this->redirectForFailure("/admin/novels/show/id/{$novelData['id']}", 'Problem , Please try again.');
                } else {
                    $this->redirectForSuccess("/admin/novels/show/id/{$novelData['id']}", 'Novel has updated successfully.');
                }
            } else {
                $postEntry->populate($data);
            }
        } else {
            if (empty($novelDetail['novel_id'])) {
                $this->redirectForFailure("/admin/novels/show/id/{$novelData['id']}", 'No novel found');
            } else {
                $postData = $novelModel->getDetail($novelData['id']);
                if (empty($postData)) {
                    $this->redirectForFailure("/admin/novels/show/id/{$novelData['id']}", 'No novel found.');
                } else {
                    $postEntry->populate($postData);
                }
            }
        }
        $this->view->PostEntry = $postEntry;
    }

    public function editNovelNameAction()
    {
        $novelNameModel = new Admin_Model_NovelName();
        $novelData      = $this->_request->getParams();
        $novelDetail    = $novelNameModel->getDetail($novelData['id']);
        $options        = array(
            'isEdit' => true,
            'novel_name_id' => $novelDetail['novel_name_id']
        );
        $postEntry      = new Admin_Form_NovelName($options);
        if ($this->_request->isPost()) {
            $data = $this->_request->getParams();
            if ($postEntry->isValid($data)) {
                $result = $novelNameModel->modify($data, $novelDetail['novel_name_id']);
                if (empty($result)) {
                    $this->redirectForFailure("/admin/novels", 'Problem , Please try again.');
                } else {
                    $this->redirectForSuccess("/admin/novels", 'Novel has updated successfully.');
                }
            } else {
                $postEntry->populate($data);
            }
        } else {
            if (empty($novelDetail['novel_name_id'])) {
                $this->redirectForFailure("/admin/novels", 'No novel found');
            } else {
                $postData = $novelNameModel->getDetail($novelData['id']);
                if (empty($postData)) {
                    $this->redirectForFailure("/admin/novels", 'No novel found.');
                } else {
                    $postEntry->populate($postData);
                }
            }
        }
        $this->view->novelNameForm = $postEntry;
    }

    public function deleteNovelNameAction()
    {
        $this->disableLayout();
        $novelNameModel = new Admin_Model_NovelName();
        $data           = $this->_request->getParams();
        $novelDetail    = $novelNameModel->getDetail($data['id']);
        $status         = $novelNameModel->delete($novelDetail['novel_name_id']);
        if ($status) {
            $this->redirectForSuccess('/admin/novels', "'Novel name has been deleted Sucessfully.");
        } else {
            $this->redirectForFailure('/admin/novels', "Something went wrong. Please try again");
        }
    }

    public function novelNamePublishStatusAction()
    {
        $this->disableLayout();
        $novelNameModel                  = new Admin_Model_NovelName();
        $data                            = $this->_request->getParams();
        $novelDetail                     = $novelNameModel->getDetail($data['id']);
        $authNamespace                   = new Zend_Session_Namespace('adminInformation');
        $adminId                         = $authNamespace->adminData['admin_id'];
        $data['last_modarate_by']        = $adminId;
        $data['novel_name_is_published'] = $novelDetail['novel_name_is_published'];
        $status                          = $novelNameModel->changeNovelNamePublishStatus($data, $novelDetail['novel_name_id']);
        if ($status) {
            $this->redirectForSuccess('/admin/novels', "'Novel status has been changed Sucessfully.");
        } else {
            $this->redirectForFailure('/admin/novels', "Something went wrong. Please try again");
        }
    }

    public function novelPublishStatusAction()
    {
        $this->disableLayout();
        $novelNameModel             = new Admin_Model_Novel();
        $data                       = $this->_request->getParams();
        $novelDetail                = $novelNameModel->getDetail($data['id']);
        $authNamespace              = new Zend_Session_Namespace('adminInformation');
        $adminId                    = $authNamespace->adminData['admin_id'];
        $data['last_modarate_by']   = $adminId;
        $data['novel_is_published'] = $novelDetail['novel_is_published'];
        $status                     = $novelNameModel->changeNovelPublishStatus($data, $novelDetail['novel_id']);
        if ($status) {
            $this->redirectForSuccess("/admin/novels/show/id/{$data['id']}", "'Novel status has been changed Sucessfully.");
        } else {
            $this->redirectForFailure("/admin/novels/show/id/{$data['id']}", "Something went wrong. Please try again");
        }
    }
}
