<?php

/**
 * Authentication Plugin
 * @category   Plugin
 * @copyright  Copyright (c) 2011 Right Brain Solution Ltd. http://rightbrainsolution.com
 * @author     Syed Abidur Rahman <abid@rightbrainsolution.com>
 * @author     Eftakhairul Islam <eftakhairul@gmail.com>
 */

class Speed_Plugin_Authentication extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {

        $actionToBeSkipped = array('login');
        $userInformation   = new Zend_Session_Namespace('userInformation');

        $acl = Speed_Model_Acl::getInstance();
        if ($userInformation->userData) {

            $isAllowed = $acl->isRoleAllowed(
                $userInformation->userData['role_id'],
                $request->getModuleName('module'),
                $request->getControllerName('controller'),
                $request->getActionName('action')
            );

            if ($isAllowed == false) {

                echo "You don't have access";
                die;

                $this->setPath($request, array(
                    'Module' => 'user',
                    'Controller' => 'Error',
                    'Action' => 'have-no-access',
                ));
            }
        } else {

            if (!in_array($request->getActionName(), $actionToBeSkipped)) {

                $this->setPath($request, array(
                    'Module' => 'user',
                    'Controller' => 'auth',
                    'Action' => 'login',
                ));
            }
        }
    }

    protected function setPath(Zend_Controller_Request_Abstract $request, $data = array())
    {
        $request->setModuleName($data['Module']);
        $request->setControllerName($data['Controller']);
        $request->setActionName($data['Action']);
        $request->setDispatched(true);
    }
}