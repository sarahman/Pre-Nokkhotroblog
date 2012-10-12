<?php
/**
 * Signup Form
 * @category        Form
 * @copyright       Copyright (c) 2011
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 */
class User_Form_SignupForm extends Speed_Form_Base
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
        $this->addSubmitButtonField();
        //$this->addCancelButtonField();
        $this->finalizeForm();
        EasyBib_Form_Decorator::setFormDecorator($this, EasyBib_Form_Decorator::BOOTSTRAP, 'submit', 'cancel');
    }

    protected function initForm()
    {
        $options = array(
            'name' => 'signup-form',
            'class' => 'span5'
        );
        $this->initializeForm($options);
    }

    protected function addUserField($isEdit = false)
    {
        $options = array(
            'name' => 'username',
            'label' => 'Username',
            'class' => 'span3',
            'messageForRequired' => 'Username is required and has to be unique.'
        );
        $element = $this->addTextElement($options);
        if ($isEdit) {
            $element->setAttrib('readonly', 'readonly');
        } else {
            $element->addValidator(new Zend_Validate_Db_NoRecordExists(array(
                'table' => 'users', 'field' => 'username')));
        }
    }

    protected function addNameField()
    {
        $options = array(
            'name' => 'name',
            'label' => 'Name',
            'class' => 'span3',
            'messageForRequired' => 'name is required.'
        );
        $this->addTextElement($options);
    }

    protected function addEmailField($isEdit = false)
    {
        $options = array(
            'name' => 'email_address',
            'label' => 'Email Address',
            'class' => 'span3',
            'messageForRequired' => 'Email Address is required and has to be unique.'
        );
        $element = $this->addTextElement($options);
        $element->addValidator('EmailAddress', true, array('messages' => 'Please enter valid email address'));
        if ($isEdit == false) {
            $element->addValidator(new Zend_Validate_Db_NoRecordExists(
                                       array('table' => 'users', 'field' => 'email_address')));
        }
    }

    protected function addUserPasswordField()
    {
        $options = array(
            'name' => 'password',
            'label' => 'Password',
            'class' => 'span3',
            'messageForRequired' => 'Please enter password.'
        );
        $this->addPasswordElement($options);
    }

    protected function addConfirmedUserPasswordField()
    {
        $options = array(
            'name' => 'confirm_password',
            'label' => 'Confirm Password',
            'class' => 'span3',
            'messageForRequired' => 'Please confirm password.'
        );
        $element = $this->addPasswordElement($options);
        $element->addValidator('Identical', false, array(
            'token' => 'password',
            'messages' => 'Passwords do not match.'
        ));
    }

    protected function addSubmitButtonField()
    {
        $this->addSubmitButtonElement(array('name' => 'submit'));
    }
}
