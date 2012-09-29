<?php
/**
 * Episod Controller
 *
 * @Group Type   Controller
 * @package     Blog
 * @author      Md. Sirajus Salayhin <salayhin@gmail.com>
 */
class Blog_EpisodesController extends Speed_Controller_ActionController
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
        $this->_helper->layout->setLayout('general');
        $episodnameModel = new Blog_Model_EpisodName();
        $display = $episodnameModel->getAll();
        $this->view->display = $display;
    }

    public function myEpisodesAction()
    { 
        $this->validateUser();
        $this->_helper->layout->setLayout('userprofile');
        $username = $this->_request->getParam('username');
        $userModel = new Speed_Model_User();
        $user = $userModel->getDetailByUsername($username);
        $episodesModel = new Blog_Model_EpisodName();
        $episodes = $episodesModel->getEpisodesByUser($user['user_id']);
        $allEpisode = $episodesModel->getAll();
        $this->view->episode = $episodes;
        $this->view->userDetail = $user;
        $this->view->allEpisode = $allEpisode;
    }

    public function addAction()
    {
        $this->validateUser();
        $this->_helper->layout->setLayout('userprofile');
        $userId = $this->_request->getParam('id');
        $episodeModel = new Blog_Model_EpisodName();
        $blogstatus = new Blog_Model_BlogStatus();
        $options = array(
            'episode_name' => $episodeModel->getDetailForEpisode($userId),
            'status' => $blogstatus->getSelected(),
            'isEdit' => false
        );

        $authNamespace = new Zend_Session_Namespace('userInformation');

        $username = $authNamespace->userData['username'];
        $userModel = new Speed_Model_User();
        $user = $userModel->getDetailByUsername($username);
        $episodeForm = new Blog_Form_Episode($options);
        if ($this->_request->isPost()) {
            $data = $this->_request->getParams();
            if ($episodeForm->isValid($data)) {
                $episodesModel = new Blog_Model_Episod();
                $result = $episodesModel->save($data);
                if (empty($result)) {
                    $this->redirectForFailure("/episode-list/{$user['username']}", "There was a problem , Please try again.");
                } else {
                    $this->redirectForSuccess("/episode-list/{$user['username']}", "Your Episode is Submited.");
                }

            } else {
                $episodeForm->populate($data);
            }
        }
        $this->view->NovelForm = $episodeForm;
        $this->view->userDetail = $user;
    }

    public function editDraftAction()
    {
        $this->validateUser();
        $this->_helper->layout->setLayout('userprofile');
        $draftId = $this->_request->getParam('id');
        $episodModel = new Blog_Model_Episod();
        $episodname = new Blog_Model_EpisodName();

        $authNamespace = new Zend_Session_Namespace('userInformation');

        $username = $authNamespace->userData['username'];
        $userModel = new Speed_Model_User();
        $user = $userModel->getDetailByUsername($username);
        $blogstatus = new Blog_Model_BlogStatus();
        $options = array(
            'isEdit' => true,
            'status' => $blogstatus->getSelected(),
            'episode_id' => $episodname->getAll()
        );
        $episodEntry = new Blog_Form_EpisodEntry($options);
        $data = $this->_request->getParams();

        if ($this->_request->isPost()) {


            if ($episodEntry->isValid($data)) {
                $result = $episodModel->modify($data, $draftId);
                if (empty($result)) {
                    $this->redirectForFailure("/episode-list/{$data['username']}", 'Problem , Please try again.');
                } else {
                    $this->redirectForSuccess("/episode-list/{$data['username']}", 'Draft has updated successfully.');
                }
            } else {
                $episodEntry->populate($data);
            }
        } else {

            if (empty($draftId)) {
                $this->redirectForFailure('/blog/episods/display-draft', 'No drafts found');
            } else {
                $episodModel = new Blog_Model_Episod();
                $episodData = $episodModel->getDetail($draftId);
                if (empty($episodData)) {
                    $this->redirectForFailure('/blog/episods/', 'No Episod found.');
                } else {
                    $episodEntry->populate($episodData);
                }
            }
        }
        $this->view->DraftForm = $episodEntry;
        $this->view->userDetail = $user;
    }


    public function editAction()
    {
        $this->validateUser();
        $this->_helper->layout->setLayout('userprofile');
        $episodModel = new Blog_Model_Episod();
        $episodId = $this->_request->getParam('id');
        $episodModel->getDetail($episodId);
        $blogstatus = new Blog_Model_BlogStatus();
        $options = array(
            'isEdit' => true,
            'status' => $blogstatus->getSelected(),
            'discussion_id' => $episodId
        );
        $episodEntry = new Blog_Form_EpisodEntry($options);
        $authNamespace = new Zend_Session_Namespace('userInformation');

        $username = $authNamespace->userData['username'];
        $userModel = new Speed_Model_User();
        $user = $userModel->getDetailByUsername($username);

        if ($this->_request->isPost()) {
            $data = $this->_request->getParams();
            if ($episodEntry->isValid($data)) {
                $result = $episodModel->modify($data, $episodId);
                if (empty($result)) {
                    $this->redirectForFailure("/episode-list/{$data['username']}", 'Problem , Please try again.');
                } else {
                    $this->redirectForSuccess("/episode-list/{$data['username']}", 'Episods has updated successfully.');
                }
            } else {
                $episodEntry->populate($data);
            }
        } else {

            if (empty($episodId)) {
                $this->redirectForFailure('/blog/episods/', 'No Episod found');
            } else {
                $episodModel = new Blog_Model_Episod();
                $episodData = $episodModel->getDetail($episodId);
                if (empty($episodData)) {
                    $this->redirectForFailure('/blog/episods/', 'No Episod found.');
                } else {
                    $episodEntry->populate($episodData);
                }
            }
        }
        $this->view->PostEntry = $episodEntry;
        $this->view->userDetail = $user;

    }


    public function deleteAction()
    {
        $this->validateUser();
        $this->_helper->layout->setLayout('userprofile');
        $episodModel = new Blog_Model_Episod();

        $episodeId = $this->_request->getParam('id');

        $status = $episodModel->delete($episodeId);

        if ($status) {
            $this->redirectForSuccess("/live']}", "Episod deleted Sucessfully.");
        } else {
            $this->redirectForFailure("/live']}", "Something went wrong. Please try again");
        }
    }


    public function showAction()
    {
        $this->validateUser();
        $this->_helper->layout->setLayout('userprofile');
        $data =$this->_request->getParams();
        $episodeModel = new Blog_Model_Episod();
        $userModel = new Speed_Model_User();
        $user = $userModel->getDetailByUsername($data['username']);
        $episode = $episodeModel->getDetailForEpisode($data['id']);
        $allEpisode = $episodeModel->getAll();

        if (empty($episode)) {
            $this->redirectForFailure("/episode-list/{$data['username']}","No Episode post found");
        }

        $this->view->episode = $episode;
        $this->view->userDetail = $user;
        $this->view->allEpisode = $allEpisode;

    }

    public function showDetailAction()
    {

        $this->_helper->layout->setLayout('general');
        $data = $this->_request->getParams();
        $userModel = new Speed_Model_User();
        $user = $userModel->getDetailByUsername($data['username']);
        $episodModel = new Blog_Model_Episod();

        $episode = $episodModel->getDetailForEpisode($data['permalink']);
        $allEpisode = $episodModel->getAll();

        if (empty($episode)) {
            $this->redirectForFailure("/episode-list/{$data['username']}","No Episode Detail found");
        }

        $this->view->episode = $episode;
        $this->view->userDetail = $user;
        $this->view->allEpisode = $allEpisode;


    }


    public function addNameAction()
    {
        $this->validateUser();
        $this->_helper->layout->setLayout('userprofile');

        $userName = $this->_request->getParam('username');

        $userModel = new Speed_Model_User();
        $user = $userModel->getDetailByUsername($userName);
        $options = array(
            'isEdit' => false
        );
        $nameEntry = new Blog_Form_EpisodName($options);


        if ($this->_request->isPost()) {

            $data = $this->_request->getParams();
            if ($nameEntry->isValid($data)) {
                $episodnameModel = new Blog_Model_EpisodName();

                $result = $episodnameModel->save($data);
                if (empty($result)) {
                    $this->redirectForFailure("/episode-list/{$data['username']}","There was a problem. Please try again.");
                } else {

                    $this->redirectForSuccess("/episode-list/{$data['username']}","Episode name save successfully.");
                }

            } else {
                $nameEntry->populate($data);
            }
        }
        $this->view->NameEntry = $nameEntry;
        $this->view->userDetail = $user;
    }

    public function displayDraftAction()
    { 
       $this->validateUser();
        $userdetailModel = new Speed_Model_User();

        $authNamespace = new Zend_Session_Namespace('userInformation');
         $userName = $authNamespace->userData['username'];
        $userDetail = $userdetailModel->getDetailByUserName($userName);

        $this->_helper->layout->setLayout('userprofile');
        $episodModel = new Blog_Model_Episod();
        $display = $episodModel->getDraft();
        $this->view->Display = $display;
$this->view->userDetail = $userDetail;
    }

    // Trash Action
   
    public function trashAction()
    {
     $this->validateUser();
        $data = array();

        $this->disableLayout();

        $blogId = $this->_request->getParam('id');

        $authNamespace = new Zend_Session_Namespace('userInformation');
        $adminId = $authNamespace->userData['user_id'];

        $data['last_modarate_by'] = $adminId;
        $trashModel = new Blog_Model_Episod();
        $status = $trashModel->setTrashStatus($data, $blogId);

        if ($status) {
            $this->redirectForSuccess("/user/draft/index/id/{$blogId}", "Blog status updated");
        } else {
            $this->redirectForFailure("/user/draft/index/id/{$blogId}", "Something went wrong");
        }

    }

    public function displayTrashAction()
    {
        $this->validateUser();
        $userdetailModel = new Speed_Model_User();

        $authNamespace = new Zend_Session_Namespace('userInformation');
         $userName = $authNamespace->userData['username'];
        $userDetail = $userdetailModel->getDetailByUserName($userName);
        $this->_helper->layout->setLayout('userprofile');
        $episodModel = new Blog_Model_Episod();
        $TrashEpisode = $episodModel->getAllTrash();
        $this->view->Displaytrash = $TrashEpisode;
        $this->view->userDetail = $userDetail;
    }

 public  function showAllAction()

 {

     $this->_helper->layout->setLayout('general');
     $episoeModel= new Blog_Model_Episod();
     $episodeId=$this->_request->getParam('id');
      $episode= $episoeModel->getDetailForEpisode($episodeId);
     if (empty($episode)) {
            $this->redirectForFailure("/blog/episodes/index", "No Episode has been found. Please try again later.");
        }

        $this->view->episode = $episode;







 }

}
