<?php
/**
 * notices Controller
 *
 * @notices    Controller
 * @package     Admin
 * @author      Md. Sirajus Salayhin <salayhin@gmail.com>
 */
class Admin_NoticeController extends Speed_Controller_ActionController
{
    protected $blogModel;

    protected function initialize()
    {
        $this->view->navBar = 'notice';
        $this->_helper->layout->setLayout('admin');
        $this->validateAdmin();
    }

    public function indexAction()
    {
        $this->validateAdmin();
        $noticsDisplayModel = new Admin_Model_Notice();
        $display = $noticsDisplayModel->getAll();
        $this->view->display = $display;

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
                $noticeData = $noticeModel->getDetailForAdmin($noticeId);

                if (empty($noticeData)) {

                    $this->redirectForFailure("/admin/notice", 'Notice data has not been found');
                } else {
                    $noticeForm->populate($noticeData);
                }
            }
        }

        $this->view->noticeForm = $noticeForm;
    }


    public function showAction()
    {
        $this->validateAdmin();

        $noticeModel = new Admin_Model_Notice();
        $noticeId = $this->_request->getParam('id');

        $notice = $noticeModel->getDetailForAdmin($noticeId);

        if (empty($notice)) {
            $this->redirectForFailure("/admin/notice", "Notice has been deleted.");
        }

        $this->view->notice = $notice;
    }


    protected function setPagination(Speed_Model_Abstract $model, $rows, $rowCount, $action = 'index')
    {
        $paginator = $model->getPaginator($rows, $rowCount);
        $this->view->paginator = $paginator;

        $this->view->paginatorOptions = array(
            'path' => '',
            'itemLink' => "/admin/blogs/{$action}/page/%d"
        );
    }


    public function deleteAction()
    {
        $noticeDeleteModel = new Admin_Model_Notice();

        $noticeId = $this->_request->getParam('id');

        $status = $noticeDeleteModel->delete($noticeId);

        if ($status) {
            $this->redirectForSuccess("/admin/notice", "notice deleted Sucessfully.");
        } else {
            $this->redirectForFailure("/admin/notice", "Something went wrong. Please try again");
        }
    }


    public function addAction()
    {

        $this->validateAdmin();
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
                    $this->redirectForFailure('/admin/notice','There was a problem , Please try again.');
                } else {
                    $this->redirectForSuccess("/admin/notice", "notice deleted Sucessfully.");
                }

            } else {
                $noticeEntry->populate($data);
            }
        }

        $this->view->noticeEntry = $noticeEntry;

    }


    public function validAction()
    {
        $data = array();

        $this->disableLayout();

        $noticeId = $this->_request->getParam('id');

        $authNamespace = new Zend_Session_Namespace('adminInformation');
        $adminId = $authNamespace->adminData['admin_id'];

        $noticeModel = new Admin_Model_Notice();
        $status = $noticeModel->setPublishStatus($data, $noticeId);

        if ($status) {
            $this->redirectForSuccess("/admin/notice", "Notice status updated");
        } else {
            $this->redirectForFailure("/admin/notice", "Something went wrong");
        }

    }
public function showAllcommentAction()
    {
        $this->validateAdmin();
        $noticeModel = new Blog_Model_NoticComment();
        $notice = $noticeModel->getAllPublished();
        if (empty($notice)) {
            $this->redirectForFailure("/admin/notice", "Notice has been deleted.");
        }

        $this->view->notice = $notice;
    }
    public function showPandingcommentAction()
    {
        $this->validateAdmin();
        $noticeModel = new Blog_Model_NoticComment();
        $notice = $noticeModel->getAllPanding();
        if (empty($notice)) {
            $this->redirectForFailure("/admin/notice", "Notice has been deleted.");
        }

        $this->view->notice = $notice;
    }

    public function showCommentAction()
    {
        $this->validateAdmin();

        $commentModel = new Blog_Model_NoticComment();

        $commentId = $this->_request->getParam('id');


        $comment = $commentModel->getDetailForComment($commentId);
//var_dump($comment);die;
        if (empty($comment)) {
            $this->redirectForFailure("/admin/notice", "Notice comment has been deleted.");
        }
        
        $this->view-> comment = $comment;
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
 $this->redirectForSuccess("/admin/notice/show-comment/id/{$commentId}", "Notice comment status updated");
 } else {
        $this->redirectForFailure("/admin/notice/show-comment/id/{$commentId}", "Something went wrong");
      }

  }
public function activeAction()
  {
$data = array();

        $this->disableLayout();

        $noticeId = $this->_request->getParam('id');

        $authNamespace = new Zend_Session_Namespace('adminInformation');
        $adminId = $authNamespace->adminData['admin_id'];

        $noticeModel = new Admin_Model_Notice();
        $status = $noticeModel->setActiveStatus($data, $noticeId);

        if ($status) {
            $this->redirectForSuccess("/admin/notice", "Notice status updated");
        } else {
            $this->redirectForFailure("/admin/notice", "Something went wrong");
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

}
