<?php
/**
 * Signup Form
 *
 * @category        Form
 * @copyright       Copyright (c) 2011
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 */
class Admin_Form_AdminUser extends Speed_Form_Base
{
    public function __construct($options = array())
        {
            parent::__construct();

            $isEdit = empty($options['isEdit']) ? false : true;

            $this->initForm();
            $this->addUserField($isEdit);
            $this->addNameField();
            $this->addUserPasswordField();
            $this->addConfirmedUserPasswordField();
            $this->addEmailField($isEdit);
            $this->addRollField();
            //$this->addAdminRollField($options);//$options['role_id']
            //$this->addCreatebyField();
            $this->addSubmitButtonField();
            $this->addCancelButtonField();

            $this->finalizeForm();
            EasyBib_Form_Decorator::setFormDecorator($this, EasyBib_Form_Decorator::BOOTSTRAP,'submit','cancel');
        }

        protected function initForm()
        {
            $options = array(
                'name'  => 'signup-form',
                'class' => 'span10'
            );

            $this->initializeForm($options);
        }

        protected function addUserField($isEdit = false)
        {
            $options = array(
                'name'                  => 'username',
                'label'                 => 'Username',
                'class'                 => 'span5',
                'messageForRequired'    => 'Username is required and has to be unique.'
             );

            $element = $this->addTextElement($options);

            if ($isEdit) {
                $element->setAttrib('readonly','readonly');
            } else {
                $element->addValidator(new Zend_Validate_Db_NoRecordExists(array(
                                        'table' => 'admins', 'field' => 'username')));
            }
        }


        protected function addNameField()
            {
                $options = array(
                    'name'                  => 'name',
                    'label'                 => 'Name',
                    'class'                 => 'span5',
                    'messageForRequired'    => 'Name is required.'
                 );
            $this->addTextElement($options);

            }
            
            protected function addRollField()
            {
                $options = array(
                    'name'                  => 'role_id',
                    'label'                 => 'Admin Roll ID',
                    'class'                 => 'span5',
                    'messageForRequired'    => 'Roll is required.'
                 );
            $this->addTextElement($options);

            }
            
            protected function addCreatebyField()
            {
                $options = array(
                    'name'                  => 'create_by',
                    'label'                 => 'Admin Create By',
                    'class'                 => 'span5',
                    'messageForRequired'    => 'Admin Create By'
                 );
            $this->addTextElement($options);

            }
           
            

        protected function addEmailField($isEdit = false)
        {
            $options = array(
                'name'                  => 'email_address',
                'label'                 => 'Email Address',
                'class'                 => 'span5',
                'messageForRequired'    => 'Email Address is required and has to be unique.'
             );

            $element = $this->addTextElement($options);

            $element->addValidator('EmailAddress', true, array('messages' => 'Please enter valid email address'));

            if ($isEdit == false){
                $element->addValidator(new Zend_Validate_Db_NoRecordExists(
                                    array( 'table' => 'admins', 'field' => 'email_address' )) );
            }
        }

        protected function addUserPasswordField()
        {
            $options = array(
                'name'                  => 'password',
                'label'                 => 'Password',
                'class'                 => 'span5',
                'messageForRequired'    => 'Please enter password.'
            );

            $this->addPasswordElement($options);
        }

        protected function addConfirmedUserPasswordField()
        {
            $options = array(
                'name'                  => 'confirm_password',
                'label'                 => 'Confirm Password',
                'class'                 => 'span5',
                'messageForRequired'    => 'Please confirm password.'
            );

            $element  = $this->addPasswordElement($options);

            $element->addValidator('Identical', false, array(
                'token' => 'password',
                'messages' => 'Passwords do not match.'
            ));
        }
//$field = new Zend_Form_Element_Select('role_id'); $this->formElements($options)=$field;


        protected function addSubmitButtonField()
        {
            $this->addSubmitButtonElement(array('name' => 'submit'));
        }

        protected function addCancelButtonField()
        {
            $this->addRedirectingCancelButtonElement(array(
                'name' => 'cancel',
                'redirectLink' => '/admin/adminusers'
            ));
        }
}
