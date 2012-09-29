<?php

/**
 * ACL Model
 *
 * @category    Model
 * @package     Library
 * @author      Eftakhairul Islam <eftakhairul@gmail.com> (http://eftakhairul.com)
 * @copyright   Right Brain Solution Ltd. (http://www.rightbrainsolution.com)
 */
class Speed_Model_Acl extends Zend_Acl
{
    protected static $instance;

    private $roles;

    /**
     *
     * @return App_Model_Acl
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function resetInstance()
    {
        self::$instance = null;
        self::getInstance();
    }

    protected function __construct()
    {

        $this->addRoles();
        $this->addResources();
        $this->addPermissions();

        return $this;
    }

    private function addRoles()
    {
        $this->roles = new Zend_Config_Ini(APPLICATION_PATH . '/configs/roles.ini');
        $this->roles = $this->roles->toArray();

        foreach($this->roles AS $role)
        {
            $this->addRole(new Zend_Acl_Role($role));
        }
    }

    private function addResources()
    {
       $resources = new Zend_Config_Ini(APPLICATION_PATH . '/configs/resources.ini');
       $resources = $resources->toArray();

      foreach($resources AS $moduleName => $modules)
      {
          foreach($modules AS $controller)
          {
            $resource =  $this->makeResource($moduleName, $controller);
            $this->add(new Zend_Acl_Resource($resource));
          }
      }
    }

    private function addPermissions()
    {
        $permissions = new Zend_Config_Ini(APPLICATION_PATH . '/configs/permissions.ini');
        $permissions = $permissions->toArray();

//        echo '<pre>';
//        print_r($permissions);
//        echo '</pre>';

        foreach($permissions AS $userType => $modules)
        {
            foreach($modules AS $moduleName => $controllers)
            {
                foreach($controllers AS $controllerName => $actions)
                {
                    $resource =  $this->makeResource($moduleName, $controllerName);
                    $this->allow($this->roles[$userType], $resource, $actions);
                }
            }
        }
    }

    public function isRoleAllowed($role, $module = 'admin', $controller, $action = null)
    {
        if ($action != null) {
            $action = strtolower($action);
        }

        $resource =  $this->makeResource($module, $controller);

        if ($this->hasRole($role) && $this->isAllowed($role, $resource, $action)) {
            return true;
        }

        return false;
    }

    private function makeResource($moduleName = '', $controlerName = '')
    {
        return strtolower(trim($moduleName) . ':' . trim($controlerName));
    }
}