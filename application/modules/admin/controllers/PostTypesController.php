<?php
/**
 * Post Type Controller
 * @Post Type   Controller
 * @package     Admin
 * @author      Md. Sirajus Salayhin <salayhin@gmail.com>
 */
class Admin_PostTypesController extends Speed_Controller_ActionController
{
    protected $posttype;

    protected function initialize()
    {
        $this->view->navBar = 'post-types';
        $this->_helper->layout->setLayout('admin');
        $this->validateAdmin();
    }

    public function indexAction()
    {
        $this->validateAdmin();
        $posttypeDisplayModel = new Admin_Model_PostType();
        $display              = $posttypeDisplayModel->getAll();
        $this->view->display  = $display;
    }

    public function editAction()
    {
        $this->validateAdmin();
        $posttypeModel = new Admin_Model_PostType();
        $postId        = $this->_request->getParam('id');
        $posttypeModel->getDetail($postId);
        $postEntry = new Admin_Form_PostTypeEntry(array(
            'isEdit' => true,
            'post_type' => $postId
        ));
        if ($this->_request->isPost()) {
            $data = $this->_request->getParams();
            if ($postEntry->isValid($data)) {
                $result = $posttypeModel->modify($data, $data['post_type_id']);
                if (empty($result)) {
                    $this->redirectForFailure('/admin/post-types', 'Problem , Please try again.');
                } else {
                    $this->redirectForSuccess('/admin/post-types', 'Post has updated successfully.');
                }
            } else {
                $postEntry->populate($data);
            }
        } else {
            if (empty($postId)) {
                $this->redirectForFailure('/post-types/index', 'No Post found');
            } else {
                $posttypeModel = new Admin_Model_PostType();
                $postData      = $posttypeModel->getDetail($postId);
                if (empty($postData)) {
                    $this->redirectForFailure('/post-types/index', 'No Post found.');
                } else {
                    $postEntry->populate($postData);
                }
            }
        }
        $this->view->PostEntry = $postEntry;
    }

    public function deleteAction()
    {
        $this->validateAdmin();
        $posttypeDeleteModel = new Admin_Model_PostType();
        $postId              = $this->_request->getParam('id');
        $status              = $posttypeDeleteModel->delete($postId);
        if ($status) {
            $this->redirectForSuccess("/admin/post-types", "Post deleted Sucessfully.");
        } else {
            $this->redirectForFailure("/admin/post-types/", "Something went wrong. Please try again");
        }
    }

    public function addAction()
    {
        $this->validateAdmin();
        $postEntry = new Admin_Form_PostTypeEntry();
        if ($this->_request->isPost()) {
            $data              = $this->_request->getParams();
            $data['post_type'] = stripslashes($this->_request->getParam('post_type'));
            if ($postEntry->isValid($data)) {
                $posttypeModel = new Admin_Model_PostType();
                $result        = $posttypeModel->save($data);
                if (empty($result)) {
                    $this->redirectForFailure('/admin/post-types/index', 'There was a problem , Please try again.');
                } else {
                    $this->redirectForSuccess('/admin/post-types/index', 'Post Type inserted sucessfully');
                }
            } else {
                $postEntry->populate($data);
            }
        }
        $this->view->PostEntry = $postEntry;
    }
}
