<?php
/**
 * Draft Controller
 *
 * @category        Controller
 * @package         User
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2011
 */
class User_DraftController extends Speed_Controller_ActionController
{
    public function init()
    {
        parent::init();
        $this->_helper->layout->setLayout('userprofile');
        $categoryModel = new Blog_Model_BlogCategory();
        $this->view->Category   = $categoryModel->getAll();
        $pageModel = new Admin_Model_Page();
        $this->view->pages = $pageModel->getAll();
        
    }
    protected function initialize()
    {
        $this->_helper->layout->setLayout('userprofile');
    }

    public function indexAction()
            
    {
         $userdetailModel = new Speed_Model_User();

        $authNamespace = new Zend_Session_Namespace('userInformation');

        $userName = $authNamespace->userData['username'];

        $userDetail = $userdetailModel->getDetailByUserName($userName);
        //$authNamespace = new Zend_Session_Namespace('userInformation');

        if (!empty ($authNamespace->userData['username'])) {
            $userId = $authNamespace->userData['user_id'];
        }

        $id = $this->_request->getParam('id');

        if (!empty ($id)) {
            $userId = $id;
        }

        $draftModel = new Blog_Model_Draft();

        $draft = $draftModel->getAll();

        if (empty($draft)) {
            $this->redirectForFailure("/user/draft/index", "No post publish yet");
        } else {
            $this->view->draftPosts = $draft;
            $this->view->userDetail = $userDetail;

        }

    }
//Edit
    public function editDraftAction()
    {
        $this->_helper->layout->setLayout('userprofile');
        $this->validateUser();
        $draftId = $this->_request->getParam('id');
        $blogstatus = new Blog_Model_BlogStatus();
        $blogCategoryModel = new Blog_Model_BlogCategory();
         $draftModel = new Blog_Model_Draft();
            
        $options = array(
            'isEdit' => true,
             'blog_category_id' => $blogCategoryModel->getAll(),
            'status' => $blogstatus->getSelected()
        );
       $draftForm = new Blog_Form_BlogEntry($options); 
       
        if ($this->_request->isPost()) {
            $data = $this->_request->getParams();
            if ($draftForm->isValid($data)) {
                $result = $draftModel->modify($data, $draftId);
                if (empty($result)) {
                    $this->redirectForFailure('/user/draft/index', 'Problem , Please try again.');
                } else {
                    $this->redirectForSuccess('/user/draft/index', 'Draft has updated successfully.');
                }
            } else {
                $draftForm->populate($data);
            }
        } else {

            if (empty($draftId)) {
                $this->redirectForFailure('/blog/drafts', 'No drafts found');
            } else {
                $draftModel = new Blog_Model_Draft();
                $postDraft = $draftModel->getDraftDetail($draftId);
                if (empty($postDraft)) {
                    $this->redirectForFailure('/blog/drafts', 'No drafts found.');
                } else {
                    $draftForm->populate($postDraft);
                }
            }
        }
        $this->view->DraftForm = $draftForm;
    }
   public function deleteAction()
    {
        $this->validateUser();
        $draftModel = new Blog_Model_Draft();
        
        $draftId = $this->_request->getParam('id');

        $status = $draftModel->delete($draftId);

        if ($status) {
            $this->redirectForSuccess('/user/draft/index', "'Draft has been deleted Sucessfully.");
        } else {
            $this->redirectForFailure('/me', "Something went wrong. Please try again");
        }
    }
    
    // Trash Action
     public function trashAction()
    {
        $data = array();

        $this->disableLayout();

        $blogId = $this->_request->getParam('id');

        $authNamespace = new Zend_Session_Namespace('userInformation');
        $adminId = $authNamespace->userData['user_id'];

        $data['last_modarate_by'] = $adminId;
        $trashModel = new Blog_Model_Draft();
        $status = $trashModel->setTrashStatus($data, $blogId);

        if ($status) {
            $this->redirectForSuccess("/user/draft/index/id/{$blogId}", "Blog status updated");
        } else {
            $this->redirectForFailure("/user/draft/index/id/{$blogId}", "Something went wrong");
        }

    }

    public function blogDraftAction()
            
    {
         $userdetailModel = new Speed_Model_User();

        $authNamespace = new Zend_Session_Namespace('userInformation');

        $userName = $authNamespace->userData['username'];

        $userDetail = $userdetailModel->getDetailByUserName($userName);
        //$authNamespace = new Zend_Session_Namespace('userInformation');

        if (!empty ($authNamespace->userData['username'])) {
            $userId = $authNamespace->userData['user_id'];
        }

        $id = $this->_request->getParam('id');

        if (!empty ($id)) {
            $userId = $id;
        }

        $draftModel = new Blog_Model_Draft();

        $draft = $draftModel->getAll();

        if (empty($draft)) {
            $this->redirectForFailure("/user/draft/index", "No post publish yet");
        } else {
            $this->view->draftPosts = $draft;
            $this->view->userDetail = $userDetail;


        }

    }
    
   
    
}
