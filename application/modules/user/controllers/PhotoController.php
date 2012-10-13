<?php

/**
 * Users Controller
 * @category    Controller
 * @package     User
 * Sirajus Salayhin <salayhin@gmail.com>
 */
class User_PhotoController extends Speed_Controller_CrudController
{
    protected function initialize()
    {
        $this->_helper->layout->setLayout('userprofile');
        $categoryModel        = new Blog_Model_BlogCategory();
        $this->view->Category = $categoryModel->getAll();
        $pageModel            = new Admin_Model_Page();
        $this->view->pages    = $pageModel->getAll();
    }

    public function indexAction()
    {
        $userdetailModel        = new Speed_Model_User();
        $authNamespace          = new Zend_Session_Namespace('userInformation');
        $userName               = $authNamespace->userData['username'];
        $userDetail             = $userdetailModel->getDetailByUserName($userName);
        $this->view->userDetail = $userDetail;
        // $this->view->users = $this->userModel->getSummary();
    }

    //   public function addAction()
    //   {
    //      $this->validateUser();
    //      $userModel = new Speed_Model_User();
//
    //       $photoForm = new User_Form_PhotoForm(array(
    //          'isEdit' => true
    //       ));
    //   $authNamespace = new Zend_Session_Namespace('userInformation');
    //  $userId = $authNamespace->userData['user_id'];
    //      if ($this->_request->isPost()) {
    //         $data = $this->_request->getParams();
    //         if ($profileForm->isValid($data)) {
    //           if ($photoForm->profile_picture->receive()) {
    //               $pathProfileImage = $photoForm->profile_picture->getFileName();
    //              $data['profile_picture'] = $pathProfileImage;
    //                $result = $userModel->modify($data, $userId);
    //             if (empty($result)) {
    //                 $this->redirectForFailure('/user/photo/index', 'Problem , Please try again.');
    //              } else {
    //                 $this->redirectForSuccess('/user/photo/index', 'Blog has updated successfully.');
    //            }
    //        }
//
    //          } else {
    //               $profileForm->populate($data);
    //           }
//
//        } else {
//
    ////           $userData = $userModel->getDetail($userId);
//
    //           if (empty($userData)) {
//
//                $this->redirectForFailure('/me', 'Blog data has not been found.');
//
    //           } else {
    //               $profileForm->populate($userData);
    //           }
//
//        }
//
    //       $this->view->userProfileEntry = $profileForm;
    //   }
    public function addAction()
    {
        //
        $this->validateUser();
        $userModel     = new Speed_Model_Photo();
        $photoForm     = new User_Form_PhotoForm(array(
            'isEdit' => true
        ));
        $authNamespace = new Zend_Session_Namespace('userInformation');
        $userId        = $authNamespace->userData['user_id'];
        if ($this->_request->isPost()) {
            $data = $this->_request->getParams();
            if ($profileForm->isValid($data)) {
                if ($photoForm->albam_picture->receive()) {
                    $pathAlbamImage        = $photoForm->albam_picture->getFileName();
                    $data['albam_picture'] = $pathAlbamImage;
                    $result                = $userModel->save($data);
                    if (empty($result)) {
                        $this->redirectForFailure('/user/photo/index', 'There was a problem , Please try again.');
                    } else {
                        $this->redirectForSuccess('/user/photo/index', 'Albam Posted sucessfully');
                    }
                } else {
                    $photoForm->populate($data);
                }
            }
            $this->view->photoForm = $photoForm;
        }
    }
}
