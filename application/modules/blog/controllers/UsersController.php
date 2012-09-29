<?php
/**
 * Index Controller
 *
 * @category        Controller
 * @package         User
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2011
 */
class Blog_UsersController extends Speed_Controller_ActionController
{

    public function init()
    {
        parent::init();
        $this->_helper->layout->setLayout('userprofile');
        $authNamespace = new Zend_Session_Namespace('userInformation');

        $username = $authNamespace->userData['username'];
        $userModel = new Speed_Model_User();

        if (!empty($authNamespace->userData)) {
          $this->view->blogInfo = $userModel->getDetailByUsername($username);
        }

        $categoryModel = new Blog_Model_BlogCategory();
        $this->view->Category   = $categoryModel->getAll();
        $pageModel = new Admin_Model_Page();
        $this->view->pages = $pageModel->getAll();


    }


    public function initialize(){
        $authNamespace = new Zend_Session_Namespace('userInformation');

        $username = $authNamespace->userData['username'];
        $userModel = new Speed_Model_User();

        if (!empty($authNamespace->userData)) {
          $this->view->blogInfo = $userModel->getDetailByUsername($username);
        }
    }


    public function indexAction()
    {
        $data = $this->_request->getParams();

        $userModel = new Speed_Model_User();

        $user = $userModel->getDetailByUsername($data['username']);

        $blogModel = new Blog_Model_Blog();

        $blogs = $blogModel->getUserPosts($user['user_id']);
        $blogs['username'] = $user['username'];

        if (empty($blogs)) {
            $this->redirectForFailure("/live", "No post publish yet");
        } else {
            $this->view->recentBlogs = $blogs;
        }

    }


    public function editAction()
    {
        $this->validateUser();
	
        $data = $this->_request->getParams();
	 $blogstatus= new Blog_Model_BlogStatus();
        $blogCategoryModel = new Blog_Model_BlogCategory();
        $blogModel = new Blog_Model_Blog();
        $userModel = new Speed_Model_User();

        $user = $userModel->getDetailByUsername($data['username']);

        if (empty($user)) {
            $this->redirectForFailure('/me', 'Your requested post was deleted.');
        }

        $blog = $blogModel->getDetailByPermalink($data['permalink']);

        if ($blog['create_by'] != $user['user_id']) {
            $this->redirectForFailure('/me', 'You are not permitted to edit this blog');
        }

        $blogForm = new Blog_Form_BlogEntry(array(
            'blog_category_id' => $blogCategoryModel->getAll(),	
            'status' => $blogstatus->getSelected(),
            'isEdit' => true,
            'blog_id' => $blog['blog_id']
        ));

        if ($this->_request->isPost()) {

            $data = $this->_request->getParams();

            if ($blogForm->isValid($data)) {
                $result = $blogModel->modify($data, $data['blog_id']);
                if (empty($result)) {
                    $this->redirectForFailure('/me', 'Problem , Please try again.');
                } else {
                    $this->redirectForSuccess('/me', 'Blog has updated successfully.');
                }

            } else {
                $blogForm->populate($data);
            }

        } else {

            if (empty($data['permalink'])) {

                $this->redirectForFailure('/me', 'Blog has not been found.');

            } else {

                $blogModel = new Blog_Model_Blog();
                $blogData = $blogModel->getDetailByPermalink($data['permalink']);

                if (empty($blogData)) {

                    $this->redirectForFailure('/me', 'Blog data has not been found.');

                } else {
                    $blogForm->populate($blogData);
                }
            }
        }

        $this->view->blogForm = $blogForm;
     $this->view->userDetail = $user;
    }

    public function addAction()
    {

        $this->validateUser();
        $userModel = new Speed_Model_User();
        $this->_helper->layout->setLayout('userprofile');

        $userName = $this->_request->getParams();

        $userDetail = $userModel->getDetailByUsername($userName['username']);

        $blogCategoryModel = new Blog_Model_BlogCategory();
        $blogstatus= new Blog_Model_BlogStatus();

        $blogForm = new Blog_Form_BlogEntry(array(
            'blog_category_id' => $blogCategoryModel->getAll(),
	    'status' => $blogstatus->getSelected()
        ));
        

        if ($this->_request->isPost()) {

            $data = $this->_request->getParams();
            
            $data['description'] = stripslashes($this->_request->getParam('description'));

            if ($blogForm->isValid($data)) {

                $blogModel = new Blog_Model_Blog();

                $result = $blogModel->save($data);

                 if (empty($result)) {
                    $this->redirectForFailure('/me', 'There was a problem , Please try again.');
                } else {

                    $this->redirectForSuccess('/me', 'Blog Posted sucessfully');
                }

            } else {
                $blogForm->populate($data);
            }
        }

        $this->view->blogForm = $blogForm;
        $this->view->userDetail = $userDetail;

    }

    public function showAction()
    {
        $data = $this->_request->getParams();
        $userModel = new Speed_Model_User();
        $this->_helper->layout->setLayout('userprofile');

        $userName = $this->_request->getParams();

        $userDetail = $userModel->getDetailByUsername($userName['username']);

        $blogModel = new Blog_Model_Blog();
        $commentModel = new Blog_Model_BlogComment();

        $blog = $blogModel->getDetailByPermalink($data['permalink']);

        $comments = $commentModel->getCommentsByBlogId($blog['blog_id']);

        $commentsForm = new User_Form_CommentsForm(array('blog_id' => $blog['blog_id'], 'action' => '/blog/users/comment'));

        if (empty($blog)) {
            $this->redirectForFailure("/live", "Post has been deleted.");
        }

        $blogModel->updateBlogViewed($blog['blog_id'],$blog['viewed']);

        $this->view->blog = $blog;
        $this->view->comments = $comments;
	$this->view->userDetail = $userDetail;
    }

    public function deleteAction()
    {
        $blogDeleteModel = new Blog_Model_BlogDisplay();

        $blogId = $this->_request->getParam('id');

        $status = $blogDeleteModel->delete($blogId);

        if ($status) {
            $this->redirectForSuccess("/user/blogs/display", "Blog deleted Sucessfully.");
        } else {
            $this->redirectForFailure("/user/blogs/delete/id/{$blogId}", "Something went wrong. Please try again");
        }
    }


    public function addCommentAction()
    {
        $this->validateUser();
        $blogModel = new Blog_Model_Blog();
        $userModel = new Speed_Model_User();
        $comment = $this->_request->getParams();
        $user = $userModel->getDetailByUsername($comment['username']);
	//$userDetail = $userModel->getDetailByUsername($userName['username']);
        $commentsForm = new User_Form_CommentsForm(array('user_id' => $user['user_id'], 'action' => '/blog/users/add-comment'));

        $blog = $blogModel->getDetailByPermalink($comment['permalink']);

        if (empty($blog)) {
            $this->redirectForFailure("/live", "Post has been deleted.");
        }

        $authNamespace = new Zend_Session_Namespace('userInformation');

        $authNamespace->userData['user_id'];


        if ($this->_request->isPost()) {

            $data = $this->_request->getParams();
            $data['comments'] = stripslashes($this->_request->getParam('comments'));
            $data['blog_id'] = $blog['blog_id'];

            if ($commentsForm->isValid($data)) {

                $commentModel = new Blog_Model_BlogComment();

                $result = $commentModel->save($data);
                if (empty($result)) {
                    $this->redirectForFailure("/show/{$comment['username']}/{$comment['permalink']}", "A problem occured");
                } else {

                    $this->redirectForSuccess("/show/{$comment['username']}/{$comment['permalink']}", 'You have successfully logged in.');
                }

            } else {
                $commentsForm->populate($data);
            }
        }

        $this->view->blog = $blog;

        $this->view->commentsForm = $commentsForm;
	$this->view->userDetail =$user;
    }

    public function meAction()
    {
        $this->_helper->layout->setLayout('userprofile');

        $userdetailModel = new Speed_Model_User();

        $authNamespace = new Zend_Session_Namespace('userInformation');

        $userName = $authNamespace->userData['username'];

        $userDetail = $userdetailModel->getDetailByUserName($userName);


        if (empty($userDetail)) {
            $this->redirectForFailure("/live", "User have been deleted.");
        }

        $this->view->userdetail = $userDetail;
	$this->view->userDetail = $userDetail;
    }

    public function profileAction()
    {
        $userModel = new Speed_Model_User();
        $commentModel = new Blog_Model_BlogComment();
        $this->_helper->layout->setLayout('userprofile');

        $userName = $this->_request->getParams();
        
        $userDetail = $userModel->getDetailByUsername($userName['username']);
	$userComment=$commentModel->getCommentByUser($userName['username']);


        if (empty($userDetail)) {
            $this->redirectForFailure("/live", "user have been deleted.");
        }
        $this->view->userDetail = $userDetail;
        $this->view->userComment = $userComment;

    }

    public function blogAction()
    {
        $this->_helper->layout->setLayout('userprofile');

        $data = $this->_request->getParams();

        $userModel = new Speed_Model_User();
        $commentsModel = new Blog_Model_BlogComment();

        $user = $userModel->getDetailByUsername($data['username']);

        $blogModel = new Blog_Model_Blog();

        $blogs = $blogModel->getUserPosts($user['user_id']);

        $comments = $commentsModel->getCommentsByUserId($user['user_id']);

        if (empty($blogs)) {
            $this->redirectForFailure("/live", "No post publish yet");
        } else {
            $this->view->comments = $comments;
            $this->view->userBlogs = $blogs;
            $this->view->userDetail = $user;
        }

    }


    public function profileEditAction()
    {
        $this->validateUser();

        $userModel = new Speed_Model_User();

        $profileForm = new Blog_Form_ProfileForm(array(
            'isEdit' => true
        ));

        $authNamespace = new Zend_Session_Namespace('userInformation');

        $userId = $authNamespace->userData['user_id'];

        if ($this->_request->isPost()) {

            $data = $this->_request->getParams();

            if ($profileForm->isValid($data)) {
                if ($profileForm->profile_picture->receive()) {
//                   AND $settingsForm->sponser_image->receive()
//                   AND $settingsForm->ticket_background_image->receive()) {

                    $pathProfileImage = $profileForm->profile_picture->getFileName();
//                    $pathTicketSponsorImage = $settingsForm->sponser_image->getFileName();
//                    $pathTicketBackgroundImage = $settingsForm->ticket_background_image->getFileName();

                    $data['profile_picture'] = $pathProfileImage;
//                    $data['sponser_image'] = $pathTicketSponsorImage;
//                    $data['ticket_background_image'] = $pathTicketBackgroundImage;

                    $result = $userModel->modify($data, $userId);

                    if (empty($result)) {
                        $this->redirectForFailure('/me', 'Problem , Please try again.');
                    } else {
                        $this->redirectForSuccess('/me', 'Blog has updated successfully.');
                    }
                }


            } else {
                $profileForm->populate($data);
            }

        } else {

            $userData = $userModel->getDetail($userId);

            if (empty($userData)) {

                $this->redirectForFailure('/me', 'Blog data has not been found.');

            } else {
                $profileForm->populate($userData);
            }

        }

        $this->view->userProfileEntry = $profileForm;
    }

    public function selectedPostsAction()
    {
        $this->_helper->layout->setLayout('general');
        $blogModel   = new Blog_Model_Blog();
        $this->view->selectedBlogs    = $blogModel->getSelectedPosts();


    }
//Added by Sayeed- 210912
    public function showNoticAction()
   {
      $this->_helper->layout->setLayout('general');
       $noticeModel = new Admin_Model_Notice();
      $noticeId = $this->_request->getParam('id');
      $commentsId = $this->_request->getParam('id');
      $notice = $noticeModel->getDetailForAdmin($noticeId);
       $commentModel =  new Blog_Model_NoticComment();
      $comment = $commentModel->getAll($commentsId);
       if (empty($notice)) {
          $this->redirectForFailure("/live", "Notice has been deleted.");
      }

        $this->view->notice = $notice;
        $this->view->comment = $comment;
	
    }

    public function addNoticcommentAction()
    {
        $this->validateUser();
        $this->_helper->layout->setLayout('general');
        $noticeModel = new Admin_Model_Notice();
        $noticeId = $this->_request->getParam('id');
        //$notice = $noticeModel->getDetailForAdmin($noticeId)
        $commentsForm = new User_Form_CommentsForm();
        if (empty($noticeId)) {
            $this->redirectForFailure("/live", "Post has been deleted.");
        }

        $authNamespace = new Zend_Session_Namespace('userInformation');

        $authNamespace->userData['user_id'];


        if ($this->_request->isPost()) {

            $data = $this->_request->getParams();
            $data['notice_id'] = $noticeId['notice_id'];

            if ($commentsForm->isValid($data)) {

                $commentModel = new Blog_Model_NoticComment();

                $result = $commentModel->save($data);
                if (empty($result)) {
                    $this->redirectForFailure("/live", "A problem occured");
                } else {

                    $this->redirectForSuccess("/live", 'You have successfully logged in.');
                }

            } else {
                $commentsForm->populate($data);
            }
        }



        $this->view->commentsForm = $commentsForm;
//$this->view->notice = $notice;

    }
    public function showAllnoticAction()
   {
      $this->_helper->layout->setLayout('general');
       $noticeModel = new Admin_Model_Notice();
       $notice = $noticeModel->getAllNotic();
       if (empty($notice)) {
          $this->redirectForFailure("/live", "There is Notice.");
      }

        $this->view->notice = $notice;

	
    }

}
