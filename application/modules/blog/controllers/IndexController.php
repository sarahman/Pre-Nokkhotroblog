<?php

/**
 * Index Controller
 *
 * @category        Controller
 * @package         User
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2011
 */

class Blog_IndexController extends Speed_Controller_ActionController
{
    public function init()
    {
        parent::init();
        $categoryModel = new Blog_Model_BlogCategory();
        $this->view->Category   = $categoryModel->getAll();
        $pageModel = new Admin_Model_Page();
        $this->view->pages = $pageModel->getAll();
    }

    public function indexAction()
    {
        $blogModel   = new Blog_Model_Blog();
        $noticeModel = new Blog_Model_Notice();
        $commentModel = new Blog_Model_BlogComment();

        $categoryModel = new Blog_Model_BlogCategory();
        $pageModel = new Admin_Model_Page();
	$discussionModel = new Blog_Model_Discussion();         //display top discussion
        $userModel = new Speed_Model_User();

        $this->view->selectedBlogs      = $blogModel->getSelectedPosts();
        $this->view->recentBlogs        = $blogModel->getRecentPosts();
        $this->view->notices            = $noticeModel->getNoticePost();
        $this->view->newBlogger         = $userModel->getAllUsers();
        $this->view->maxViewed          = $blogModel->getMaxViewBlog();
        $this->view->maxCommented       = $commentModel->getMaxCommentedBlog();
        $this->view->recentComments     = $commentModel->getRecentComments();
        $this->view->topBloger          = $blogModel->getTopBlogger();
        $this->view->topCommentPoster   = $commentModel->getTopCommentPoster();
	$this->view->CommentsNo		= $commentModel->getCommentsByBlogId(108);
        $this->view->Category   = $categoryModel->getAll();
        $this->view->pages = $pageModel->getAll();

        $this->view->stickyPost         = $blogModel->getStickeyPost();
 $this->view->topDiscussion         = $discussionModel->getTopDiscussion();         //display top discussion
     //start sign up form  
  if (!empty($data['email_address'])) {
                            $notifier = new User_Model_Notifier();
                            $userDetail = $userModel->getDetailByEmail($data['email']);
                            $notifier->sendRegistrationEmail($userDetail);
                        }
            $options = array(
                'isEdit'         => false
            );

            $userForm = new User_Form_SignupForm($options);

           if ($this->_request->isPost()) {

               $data = $this->_request->getParams();

                   if ($userForm->isValid($data)) {

                   $userModel = new Speed_Model_User();

                   $result = $userModel->save($data);
                   if (empty($result)) {
                       $this->redirectForFailure('/user/auth/login','There was a problem , Please try again.');
                   } else { 
                   
                     if (!empty($data['email_address'])) {
                           $notifier = new User_Model_Notifier();
                            
                           $userDetail = $userModel->getDetailByEmail($data['email_address']);
                           
                            
                            $notifier->sendRegistrationEmail($userDetail);
                            
                        }

                         $this->redirectForSuccess('/user/auth/login', "Your registration is complete. Please check your email to activate.");
                   }

               } else {
                   $userForm->populate($data);
               }
           }

           $this->view->userForm = $userForm;

       //end sine up form 
 
    //stat login form 

        $loginForm = new User_Form_Login();

        if ($this->_request->isPost()) {
            $data = $this->_request->getParams();
            if ($loginForm->isValid($data)) {

                $userModel = new Speed_Model_User();
                $result = $userModel->validateUser($data);

                if (empty($result)) {

                    $this->redirectForSuccess("/auth/login","Please enter correct username and password.");
                    $loginForm->populate($data);

                } else {
                    $authNamespace = new Zend_Session_Namespace('userInformation');
                    $authNamespace->userData = $result;
                    if (!isset($authNamespace->counter)) {
                        $authNamespace->counter = 1;
                    } else {
                        $authNamespace->counter++;
                    }

                    $userId = $authNamespace->userData['user_id'];
                    $userModel->updateLastLoginTime($userId);

                    $this->redirectForSuccess('/live', 'You have successfully logged in.');
                }

            } else {
                $loginForm->populate($data);
            }
        }

        $this->view->loginForm = $loginForm;
//end login form 

//start forget form 
        $forgetPasswordForm = new User_Form_ForgotPassword();

        if ($this->_request->isPost()) {
            $data = $this->_request->getParams();
            if ($forgetPasswordForm->isValid($data)) {

                $userModel = new Speed_Model_User();
                $result = $userModel->getActivationCode($data);

                if (empty($result)) {
                    $this->redirectForFailure("/auth/forgot","Please enter correct email address.");
                    $forgetPasswordForm->populate($data);

                } else {

                    $email = new Speed_Library_EmailManager();

                    $data = array_merge($data, $result);
                    $email->send('forget-password', "Password Recovery", $data['email_address'], $data['username'], $data);

                    $this->redirectForSuccess('/auth/login', 'You have been sent an email for password recovery.');
                }

            } else {
                $forgetPasswordForm->populate($data);
            }
        }

        $this->view->forgetPasswordForm = $forgetPasswordForm;

//end forget form 


    }
     public function addAction()
        {

            $options = array(
                'isEdit'         => false
            );

            $userForm = new User_Form_SignupForm($options);
            $data = array(
                'form'          => $userForm,
                'model'         => $this->userModel,
                'redirectLink'  => '/user/auth/login',
                'message'       => 'Your registration is complete. Please sign in here.'
            );

            $this->create($data);
            $this->view->userForm = $userForm;
        }

    public function categoryPostsAction()
    {
        $this->_helper->layout->setLayout('catagory');
         $blogModel = new Blog_Model_Blog();
        //$commentModel = new Blog_Model_BlogComment();
        $id = $this->_request->getParam('id');
        $category = $blogModel->getDetailByCategory($id);
       // $comment = $commentModel->getCommentByCatagoryId($id);
        $categoryPosts = $blogModel->getDetailByCategoryId($id);
    
                if (empty($categoryPosts)) {
            $this->redirectForFailure("/blog/Index/nopost", "কোনো পোস্ট নাই");
        }

        $this->view->categoryPosts = $categoryPosts;
        $this->view->category = $category;
        //$this->view->comment = $comment;
    }

     public function footerPageAction()
    {
        $this->_helper->layout->setLayout('catagory');
         $pageModel = new Admin_Model_Page();
        $permalink = $this->_request->getParam('permalink');

        $pagePosts = $pageModel->getDetailByPagePermalink($permalink);
                if (empty($pagePosts)) {
            $this->redirectForFailure("/blog/Index/footer-page/id/{$permalink }", "Notice has been deleted.");
        }

        $this->view->pagePosts = $pagePosts;
    }

	public function  countCommentAction()
    {
        $this->_helper->layout->setLayout('catagory');
        $postId=$this->_request->getParam('id');
        $commentModel=new Blog_Model_BlogComment();
        $count=$commentModel->countComment($postId);
        
        $this->view->Count=$count;
    }
    
    public function  countReadingblogAction()
    {
        $this->_helper->layout->setLayout('catagory');
        $countId=$this->_request->getParam('id');
        $commentModel=new Blog_Model_Blog();
        $count=$commentModel->getMaxViewBlog($countId);
        
        $this->view->Countreading=$count;
    }


public function nopostAction()
    {
        $this->_helper->layout->setLayout('catagory');
        $this->view->nopost ;
    }

}

