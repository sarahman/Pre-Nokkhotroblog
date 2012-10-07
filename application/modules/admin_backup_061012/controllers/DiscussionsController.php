<?php
/**
 * Discussion Controller
 *
 * Discussion   Controller
 * @package     Discussion
 * @author      Mustafa Ahmed Khan <tamal_29@yahoo.com>
 */
class Admin_DiscussionsController extends Speed_Controller_ActionController
{

   protected function initialize()
    {
        $this->view->navBar = 'admins';
        $this->_helper->layout->setLayout('admin');
        $this->validateAdmin();
    }

    public function indexAction()
    {
        
        $this->validateAdmin();         
        $discussionModel = new Admin_Model_Discussion(); 
        $display = $discussionModel->getAll();	
        $this->view->display = $display;

    }

    
    public function editAction()
    {
        $this->validateAdmin();      
       
        $discussionModel = new Admin_Model_Discussion(); 
        $discussionId = $this->_request->getParam('id'); 
        $discussionModel->getDetail($discussionId);      
        $options = array(
            'isEdit'   => true,
            'discussion_id' => $discussionId             
        );
        $discussionEntry = new Admin_Form_DiscussionEntry($options);  


        if ($this->_request->isPost()) {
            $data = $this->_request->getParams();
            if ($discussionEntry->isValid($data)) {              
                $result = $discussionModel->modify($data, $discussionId);  
                if (empty($result)) {
                    $this->redirectForFailure('/admin/discussions/index', 'Problem , Please try again.');
                } else {
                    $this->redirectForSuccess('/admin/discussions/index', 'Discussions has updated successfully.');
                }
            } else {
                $discussionEntry->populate($data);     
            }
        } else {

            if (empty($discussionId)) {              
                $this->redirectForFailure('/admin/discussions', 'No Discussion found');
            } else {
                $discussionModel = new Admin_Model_Discussion();         
                $discussionData = $discussionModel->getDetail($discussionId);    
                if (empty($discussionData)) {      
                    $this->redirectForFailure('/admin/discussions', 'No Discussion found.');
                } else {
                    $discussionEntry->populate($discussionData);    
                }
            }
        }
        $this->view->DiscussionEntry = $discussionEntry;

    }
    public function deleteAction()
    {
        $this->validateAdmin();
       
        $discussionModel = new Admin_Model_Discussion();             

        $discussionId = $this->_request->getParam('id');	

        $status = $discussionModel->delete($discussionId);	

        if ($status) {
            $this->redirectForSuccess("/admin/discussions/index", "Discussions deleted Sucessfully.");			
        } else {
            $this->redirectForFailure("/admin/discussions/index", "Discussions went wrong. Please try again");		
        }
    }

    public function showAction()
    {
        $this->validateAdmin();
        
                
        $discussionModel = new Admin_Model_Discussion();				
        $discussionId = $this->_request->getParam('id');			

        $discussion = $discussionModel->getDetailForAdmin($discussionId);		

        if (empty($discussion)) {			
            $this->redirectForFailure("/blog/discussions", "Discussions has been deleted.");		
        }

        $this->view->discussion = $discussion;		
    }
    
    public function publishAction()
    {
        $data = array();

        

        $discussionId = $this->_request->getParam('id');

        $authNamespace = new Zend_Session_Namespace('adminInformation');
        $adminId = $authNamespace->adminData['admin_id'];

        $data['update_by'] = $adminId;

        $discussionModel = new Admin_Model_Discussion();                
        $status = $discussionModel->setPublishStatus($data, $discussionId); 

        if ($status) {
            $this->redirectForSuccess("/admin/discussions/show/id/{$discussionId}", "Discussion status updated");
        } else {
            $this->redirectForFailure("/admin/discussions/show/id/{$discussionId}", "Something went wrong");
        }

    }
    
}
