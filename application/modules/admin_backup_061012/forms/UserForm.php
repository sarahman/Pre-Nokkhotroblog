<?php

/**
 * User Form
 *
 * @category        Form
 * @copyright       Copyright (c) 2011 Right Brain Solution Ltd. http://www.rightbrainsolution.com
 * @author          Eftakhairul Islam <eftakhairul@gmail.com>
 * @author          Syed Abidur Rahman <aabid048@gmail.com>
 */
class Admin_Form_UserForm extends Speed_Form_Base
{
    public function __construct($options = array())
    {
        parent::__construct();

        $isEdit = empty($options['isEdit']) ? false : true;

        $this->initForm();
        $this->addUserField($isEdit);
        $this->addUserPasswordField();
        $this->addConfirmedUserPasswordField();
        $this->addEmailField($isEdit);
        $this->addRoleField($options['roles']);
        $this->addUserStatusField($options['user_statuses']);
        $this->addSubmitButtonField();
        $this->addCancelButtonField();

        $this->finalizeForm();
        EasyBib_Form_Decorator::setFormDecorator($this, EasyBib_Form_Decorator::BOOTSTRAP,'submit','cancel');
    }

    protected function initForm()
    {
        $options = array(
            'name'  => 'user-form',
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
                                    'table' => 'users', 'field' => 'username')));
        }
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
                                array( 'table' => 'users', 'field' => 'email_address' )) );
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

    protected function addRoleField($roles)
    {
        $field = new Zend_Form_Element_Select('role_id');

        $field->setLabel('Roles')
              ->addFilter('StringTrim');

        $field->addMultiOption('', '- Select Role -');

        foreach($roles AS $value) {
            $field->addMultiOption($value['role_id'], $value['title']);
        }

        $this->setElementRequired($field, 'Please select a role.');
        $this->formElements['role_id'] = $field;
    }

    protected function addUserStatusField($status)
    {
        $field = new Zend_Form_Element_Select('user_status');

        $field->setLabel('Status')
              ->addFilter('StringTrim');

        $field->addMultiOption('', '- Select Status -');

        foreach($status AS $key => $value) {
            $field->addMultiOption($key, $value);
        }

        $this->setElementRequired($field, 'Please select a user status.');
        $this->formElements['user_status'] = $field;
    }

    protected function addSubmitButtonField()
    {
        $this->addSubmitButtonElement(array('name' => 'submit'));
    }

    protected function addCancelButtonField()
    {
        $this->addRedirectingCancelButtonElement(array(
            'name' => 'cancel',
            'redirectLink' => '/user/users'
        ));
    }
}