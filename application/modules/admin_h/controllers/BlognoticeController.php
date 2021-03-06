<?php
/**
 * Admin Controller
 *
 * @Notic    Controller
 * @package     Admin
 * @author      Md. sayeed hussain <sayeed.som@gmail.com>
 */
class Admin_BlognoticeController extends Speed_Controller_ActionController
{

    protected $blogModel;

    protected function initialize()
    {
        $this->view->navBar = 'admin';
        $this->_helper->layout->setLayout('admin');
        $this->validateAdmin();
    }

    public function indexAction()
    {
        $this->validateAdmin();
        $noticsDisplayModel = new Admin_Model_Notice();
        $notice = $noticsDisplayModel->getActiveNotic();
	$arcrive = $noticsDisplayModel->getArcriveNotic();
        $panding = $noticsDisplayModel->getPandingNotic();
	$trash = $noticsDisplayModel->getTrashNotic();
        $this->view->notice = $notice;
	$this->view->arcrive = $arcrive;
	$this->view->panding = $panding;
	$this->view->trash = $trash;
	$noticsDisplayModel = new Admin_Model_Notice();
        $noticeEntry = new Admin_Form_NoticeEntry();
        $authNamespace = new Zend_Session_Namespace('adminInformation');
        $authNamespace->adminData['admin_id'];
        if ($this->_request->isPost()) {

            $data = $this->_request->getParams();
            $data['description'] = stripslashes($this->_request->getParam('description'));


            if ($noticeEntry->isValid($data)) {

                $noticsDisplayModel = new Admin_Model_Notice();

                $result = $noticsDisplayModel->save($data);
                if (empty($result)) {
                    $this->redirectForFailure('/admin/blognotice','There was a problem , Please try again.');
                } else {
                    $this->redirectForSuccess("/admin/blognotice", "notice deleted Sucessfully.");
                }

            } else {
                $noticeEntry->populate($data);
            }
        }

        $this->view->noticeEntry = $noticeEntry;
        


    }
    public function showAction()
    {
        $this->validateAdmin();

        $noticeModel = new Admin_Model_Notice();
        $noticeId = $this->_request->getParam('id');
	$commentsId = $this->_request->getParam('id');
        $notice = $noticeModel->getDetailForAdmin($noticeId);
	$commentModel =  new Blog_Model_NoticComment();
        $comment = $commentModel->getAll($commentsId);
        if (empty($notice)) {
            $this->redirectForFailure("/admin/blognotice", "Notice has been deleted.");
        }

        $this->view->notice = $notice;
	$this->view->comment = $comment;
    }
  public function activeAction()
  {
        $data = array();

        $this->disableLayout();

        $noticeId = $this->_request->getParam('id');

        $authNamespace = new Zend_Session_Namespace('adminInformation');
        $adminId = $authNamespace->adminData['admin_id'];

        $noticeModel = new Admin_Model_Notice();
        $status = $noticeModel->setUnActiveStatus($data, $noticeId);

        if ($status) {
            $this->redirectForSuccess("/admin/blognotice", "Notice status updated");
        } else {
            $this->redirectForFailure("/admin/blognotice", "Something went wrong");
        }

  }

    public function showPandingAction()
    {
        $this->validateAdmin();

        $noticeModel = new Admin_Model_Notice();
        $noticeId = $this->_request->getParam('id');

        $notice = $noticeModel->getDetailForAdmin($noticeId);

        if (empty($notice)) {
            $this->redirectForFailure("/admin/blognotice/show-panding", "Notice has been deleted.");
        }

        $this->view->notice = $notice;

    }
    public function showTrashAction()
    {
        $this->validateAdmin();

        $noticeModel = new Admin_Model_Notice();
        $noticeId = $this->_request->getParam('id');

        $notice = $noticeModel->getDetailForAdmin($noticeId);

        if (empty($notice)) {
            $this->redirectForFailure("/admin/blognotice/show-trash", "Notice has been deleted.");
        }

        $this->view->notice = $notice;

    }

    public function editAction()
    {
        $this->validateAdmin();
        $authNamespace = new Zend_Session_Namespace('adminInformation');
        $authNamespace->adminData['admin_id'];
        $noticeModel = new Admin_Model_Notice();
        $noticeId = $this->_request->getParam('id');
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
                    $this->redirectForFailure("/admin/blognotice", 'Problem , Please try again.');
                } else {
                    $this->redirectForSuccess("/admin/blognotice", 'Notice has updated successfully.');
                }

            } else {
                $noticeForm->populate($data);
            }

        } else {

            if (empty($noticeId)) {


                $this->redirectForFailure("/admin/blognotice", 'Notice has not been found.');
            } else {

                $noticeModel = new Admin_Model_Notice();
                $noticeData = $noticeModel->getDetailForAdmin($noticeId);

                if (empty($noticeData)) {

                    $this->redirectForFailure("/admin/blognotice", 'Notice data has not been found');
                } else {
                    $noticeForm->populate($noticeData);
                }
            }
        }

        $this->view->noticeForm = $noticeForm;
    }


    public function deleteAction()
    {
        $noticeDeleteModel = new Admin_Model_Notice();

        $noticeId = $this->_request->getParam('id');

        $status = $noticeDeleteModel->delete($noticeId);

        if ($status) {
            $this->redirectForSuccess("/admin/blognotice", "notice deleted Sucessfully.");
        } else {
            $this->redirectForFailure("/admin/blognotice", "Something went wrong. Please try again");
        }
    }
public function activeNoticeAction()
  {
$data = array();

        $this->validateAdmin();

        $noticeId = $this->_request->getParam('id');

        $authNamespace = new Zend_Session_Namespace('adminInformation');
        $adminId = $authNamespace->adminData['admin_id'];

        $noticeModel = new Admin_Model_Notice();
        $status = $noticeModel->setActiveStatus($data, $noticeId);

        if ($status) {
            $this->redirectForSuccess("/admin/blognotice", "Notice status updated");
        } else {
            $this->redirectForFailure("/admin/blognotice", "Something went wrong");
        }

  }
public function trashNoticeAction()
  {
     $data = array();

       $this->validateAdmin();

        $noticeId = $this->_request->getParam('id');

        $authNamespace = new Zend_Session_Namespace('adminInformation');
        $adminId = $authNamespace->adminData['admin_id'];
	$data['update_by'] = $authNamespace->adminData['admin_id'];
        $noticeModel = new Admin_Model_Notice();
        $status = $noticeModel->setTrashStatus($data, $noticeId);

        if ($status) {
            $this->redirectForSuccess("/admin/blognotice", "Notice status updated");
        } else {
            $this->redirectForFailure("/admin/blognotice", "Something went wrong");
        }

  }
    public function deleteCommentAction()
    {
        $commentDeleteModel = new Blog_Model_NoticComment();

        $commentId = $this->_request->getParam('id');

        $status = $commentDeleteModel->delete($commentId);

        if ($status) {
            $this->redirectForSuccess("/admin/notice/show-comment/id/{$commentId}", "Notice Comment deleted Sucessfully.");
        } else {
            $this->redirectForFailure("/admin/notice/show-comment/id/{$commentId}", "Something went wrong. Please try again");
        }
    }

public function publishAction()
  {
     $data = array();
      $commentId = $this->_request->getParam('id');
      $authNamespace = new Zend_Session_Namespace('adminInformation');
     $adminId = $authNamespace->adminData['admin_id'];
       $data['update_by'] = $adminId;
       $noticModel = new Blog_Model_NoticComment();               
      $status = $noticModel->setPublishStatus($data, $commentId); 
      if ($status) {
 $this->redirectForSuccess("/admin/blognotice", "Notice comment status updated");
 } else {
        $this->redirectForFailure("/admin/blognotice", "Something went wrong");
      }

  }



}
