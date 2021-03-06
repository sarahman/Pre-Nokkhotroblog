<?php

/**
 * Blog Controller
 * @category        Controller
 * @package         Blog
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2011
 */
class Blog_NovelsController extends Speed_Controller_ActionController
{
    protected $blogModel;

    protected function initialize()
    {
        $categoryModel        = new Blog_Model_BlogCategory();
        $this->view->Category = $categoryModel->getAll();
        $pageModel            = new Admin_Model_Page();
        $this->view->pages    = $pageModel->getAll();
    }

    public function indexAction()
    {
        $this->_helper->layout->setLayout('general');
        $noveDisplayModel       = new Blog_Model_NovelName();
        $noveldisplay           = $noveDisplayModel->getAll();
        $this->view->novelNames = $noveldisplay;
    }

    public function showAction()
    {
        $this->_helper->layout->setLayout('general');
        $novelModel        = new Blog_Model_Novel();
        $data              = $this->_request->getParams();
        $novelDetail       = $novelModel->getSingleNovelEntry($data['permalink']);
        $this->view->novel = $novelDetail;
    }

    public function novelListAction()
    {
        $this->_helper->layout->setLayout('general');
        $novelModel            = new Blog_Model_Novel();
        $novelNameModel        = new Blog_Model_NovelName();
        $novelName             = $this->_request->getParam('permalink');
        $novel                 = $novelNameModel->getDetailByNovelPermalink($novelName);
        $novels                = $novelModel->getNovelDetail($novel['novel_name_id']);
        $this->view->novels    = $novels;
        $this->view->novelname = $novelName;
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
        $this->validateUser();
        $novelModel        = new Blog_Model_Novel();
        $data              = $this->_request->getParams();
        $novelDetail       = $novelModel->getSingleNovelEntry($data['permalink']);
        $this->view->novel = $novelDetail;
        $status            = $novelModel->delete($novelDetail['novel_id']);
        if ($status) {
            $this->redirectForSuccess('/novels', "'Novel has been deleted Sucessfully.");
        } else {
            $this->redirectForFailure('/novels', "Something went wrong. Please try again");
        }
    }

    public function editAction()
    {
        $this->_helper->layout->setLayout('userprofile');
        $this->validateUser();
        $novelModel  = new Blog_Model_Novel();
        $userModel   = new Speed_Model_User();
        $novelData   = $this->_request->getParams();
        $userDetail  = $userModel->getDetailByUsername($novelData['username']);
        $novelDetail = $novelModel->getSingleNovelEntry($novelData['permalink']);
        $options     = array(
            'isEdit' => true,
            'novel_id' => $novelDetail['novel_id']
        );
        $postEntry   = new Blog_Form_NovelForm($options);
        if ($this->_request->isPost()) {
            $data = $this->_request->getParams();
            if ($postEntry->isValid($data)) {
                $result = $novelModel->modify($data, $novelDetail['novel_id']);
                if (empty($result)) {
                    $this->redirectForFailure("/{$novelData['username']}/novel-list", 'Problem , Please try again.');
                } else {
                    $this->redirectForSuccess("/{$novelData['username']}/novel-list", 'Novel has updated successfully.');
                }
            } else {
                $postEntry->populate($data);
            }
        } else {
            if (empty($novelDetail['novel_id'])) {
                $this->redirectForFailure("/{$novelData['username']}/novel-list", 'No novel found');
            } else {
                $postData = $novelModel->getSingleNovelEntry($novelData['permalink']);
                if (empty($postData)) {
                    $this->redirectForFailure("/{$novelData['username']}/novel-list", 'No novel found.');
                } else {
                    $postEntry->populate($postData);
                }
            }
        }
        $this->view->PostEntry = $postEntry;
        $this->view->blogInfo  = $userDetail;
    }

    public function myNovelNameEditAction()
    {
        $this->_helper->layout->setLayout('userprofile');
        $novelNameModel = new Blog_Model_NovelName();
        $userModel      = new Speed_Model_User();
        $novelData      = $this->_request->getParams();
        $novelDetail    = $novelNameModel->getDetailByNovelPermalink($novelData['permalink']);
        $userDetail     = $userModel->getDetailByUsername($novelData['username']);
        $options        = array(
            'isEdit' => true,
            'novel_name_id' => $novelDetail['novel_name_id']
        );
        $postEntry      = new Blog_Form_NovelName($options);
        if ($this->_request->isPost()) {
            $data = $this->_request->getParams();
            if ($postEntry->isValid($data)) {
                $result = $novelNameModel->modify($data, $novelDetail['novel_name_id']);
                if (empty($result)) {
                    $this->redirectForFailure("/{$novelData['username']}/novel-list", 'Problem , Please try again.');
                } else {
                    $this->redirectForSuccess("/{$novelData['username']}/novel-list", 'Novel has updated successfully.');
                }
            } else {
                $postEntry->populate($data);
            }
        } else {
            if (empty($novelDetail['novel_name_id'])) {
                $this->redirectForFailure("{$novelData['username']}/novel-list", 'No novel found');
            } else {
                $postData = $novelNameModel->getDetailByNovelPermalink($novelData['permalink']);
                if (empty($postData)) {
                    $this->redirectForFailure("/{$novelData['username']}/novel-list", 'No novel found.');
                } else {
                    $postEntry->populate($postData);
                }
            }
        }
        $this->view->novelNameForm = $postEntry;
        $this->view->blogInfo      = $userDetail;
    }

    public function myNovelNameDeleteAction()
    {
        $this->disableLayout();
        $novelNameModel = new Blog_Model_NovelName();
        $data           = $this->_request->getParams();
        $novelDetail    = $novelNameModel->getDetailByNovelPermalink($data['permalink']);
        $status         = $novelNameModel->delete($novelDetail['novel_name_id']);
        if ($status) {
            $this->redirectForSuccess("/{$data['username']}/novel-list", "'Novel name has been deleted Sucessfully.");
        } else {
            $this->redirectForFailure("/{$data['username']}/novel-list", "Something went wrong. Please try again");
        }
    }
}
