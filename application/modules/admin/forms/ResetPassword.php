<?php

/**
 * Reset Password Form
 * @category        Form
 * @copyright       Copyright (c) 2011 Right Brain Solution Ltd. http://www.rightbrainsolution.com
 * @author          Eftakhairul Islam <eftakhairul@gmail.com>
 * @author          Syed Abidur Rahman <aabid048@gmail.com>
 */
class User_Form_ResetPassword extends Speed_Form_Base
{
    public function __construct()
    {
        parent::__construct();
        $this->initForm();
        $this->addUserPasswordFields();
        $this->addHiddenElement('code');
        $this->addDisplayGroup($this->formElements, 'auth');
        $this->getDisplayGroup('auth')->setLegend('Welcome Here');
        $this->finalizeForm();
        EasyBib_Form_Decorator::setFormDecorator($this, EasyBib_Form_Decorator::BOOTSTRAP);
    }

    protected function initForm()
    {
        $options = array(
            'name' => 'reset-password-form',
            'link' => '/user/auth/reset-password'
        );
        $this->initializeForm($options);
    }

    protected function addUserPasswordFields()
    {
        $options = array(
            'name' => 'password',
            'label' => 'Password',
            'class' => 'span4',
            'messageForRequired' => 'Please enter your new password.'
        );
        $this->addPasswordElement($options);
        $options         = array(
            'name' => 'confirm_password',
            'label' => 'Confirm Password',
            'class' => 'span4',
            'messageForRequired' => 'Please confirm your password.'
        );
        $confirmPassword = $this->addPasswordElement($options);
        $confirmPassword->addValidator('Identical', false, array(
            'token' => 'password',
            'messages' => 'Passwords do not match.'
        ));
    }
}