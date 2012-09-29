<?php

/**
 * Description of Action Controller
 *
 * @package         Action
 * @category        Controller
 * @author          Syed Abidur Rahman <aabid048@gmail.com>
 * @copyright       Copyright (c) 2011 Right Brain Solution Ltd. <http://www.rightbrainsolution.com>
 */
class Speed_Controller_ActionController extends Zend_Controller_Action
{
    protected $flashMessenger;
    protected $hash;

    public function init()
    {
        $this->flashMessenger = $this->_helper->FlashMessenger;
        $this->initialize();
    }

    protected function initialize() {}

    protected function redirectForSuccess($redirectLink, $message)
    {
        $this->setSuccessMessage($message);
        $this->_redirect($redirectLink);
    }

    protected function redirectForFailure($redirectLink, $message)
    {
        $this->setFailureMessage($message);
        $this->_redirect($redirectLink);
    }

    protected function setSuccessMessage($message)
    {
        $this->flashMessenger->addMessage(array('label label-success' => $message));
    }

    protected function setFailureMessage($message)
    {
        $this->flashMessenger->addMessage(array('label label-important' => $message));
    }

    protected function disableRendering()
    {
        $this->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
    }

    protected function disableLayout()
    {
        Zend_Layout::getMvcInstance()->disableLayout();
    }

    protected function processSearchForm($options = array())
    {
        $options['fields'] = empty ($options['fields']) ? array () : $options['fields'];
        $options['submitLink'] = empty ($options['submitLink']) ? '' : $options['submitLink'];

        $searchKey = $this->getSearchKey($options['fields']);
        $searchFormFields = Attendance_Form_SearchFormField::getSearchFormFields($options);
        $searchForm = new Speed_Form_CommonSearchForm($searchFormFields, $searchKey);

        $this->view->searchForm = $searchForm;
        $this->view->searchKeyHash = $this->hash;

        return $searchKey;
    }

    protected function getSearchKey($options = array())
    {
        $searchQuery = new Zend_Session_Namespace('searchQuery');

        foreach($options AS $option) {
            $searchKey[$option]= $this->_request->getParam($option, null);
        }

        if ($this->getRequest()->isPost()) {
            $hash = md5(uniqid());
            $searchQuery->$hash = $searchKey;
        } else {
            $hash = $this->_request->getParam('hash', false);
            if ($hash) {
                $searchKey = $searchQuery->$hash;
            }
        }

        $this->hash = $hash;
        return $searchKey;
    }

    protected function setPaginationOptions(array $options)
    {
        $model = $options['model'];
        $reportRows = $options['reportRows'];
        $total = $options['totalRows'];
        $url = $options['itemLink'];
        $paginator = $model->getPaginator($reportRows, $total);

        $this->view->baseUrl = 'http://' . $_SERVER['HTTP_HOST'];
        $this->view->reportRows = $reportRows;
        $this->view->paginator = $paginator;

        $this->view->paginatorOptions = array(
                    'path' => '',
                    'itemLink' => $url
        );
    }

    protected function convertArrayToUrl(array $array)
    {
        unset($array['module']);
        unset($array['controller']);
        unset($array['action']);
        unset($array['page']);

        $temp = array();
        foreach ($array as $key => $val)
        {
            $temp[] = $key;
            $temp[] = $val;
        }

        return implode('/', $temp);
    }

    protected function validateUser()
        {
            $authNamespace = new Zend_Session_Namespace('userInformation');

            if (empty($authNamespace->userData['username'])){
                $this->redirectForFailure("/user/auth/login","Please login first to view");
            }
        }

    protected function validateAdmin()
    {
        {
            $authNamespace = new Zend_Session_Namespace('adminInformation');

            if (empty($authNamespace->adminData['username'])){
                $this->redirectForFailure("/admin/auth/login","Please login first to view");
            }
        }
    }
}