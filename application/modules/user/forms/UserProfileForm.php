<?php
/**
 * User Profile Form
 *
 * @category        Form
 * @copyright       Copyright (c) 2011
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 */
class User_Form_UserProfileForm extends Speed_Form_Base
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
        //$this->addProfileImage();
        $this->addSubmitButtonField();
        $this->addCancelButtonField();

        $this->finalizeForm();
        EasyBib_Form_Decorator::setFormDecorator($this, EasyBib_Form_Decorator::BOOTSTRAP, 'submit', 'cancel');
    }

    protected function initForm()
    {

        $options = array(
            'name' => 'Edit Profile',
            'class' => 'span8',
            'enctype' => 'multipart/form-data'
        );


        $this->initializeForm($options);
    }

    protected function addUserField($isEdit = false)
    {
        $options = array(
            'name' => 'username',
            'label' => 'Username',
            'class' => 'span5',
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
            'class' => 'span5',
            'messageForRequired' => 'name is required.'
        );
        $this->addTextElement($options);

    }

    protected function addEmailField($isEdit = false)
    {
        $options = array(
            'name' => 'email_address',
            'label' => 'Email Address',
            'class' => 'span5',
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
            'class' => 'span5',
            'messageForRequired' => 'Please enter password.'
        );

        $this->addPasswordElement($options);
    }

    protected function addConfirmedUserPasswordField()
    {
        $options = array(
            'name' => 'confirm_password',
            'label' => 'Confirm Password',
            'class' => 'span5',
            'messageForRequired' => 'Please confirm password.'
        );

        $element = $this->addPasswordElement($options);

        $element->addValidator('Identical', false, array(
            'token' => 'password',
            'messages' => 'Passwords do not match.'
        ));
    }

    protected function addProfileImage()
    {
        $file = new Zend_Form_Element_File('user_image');

        $file->setLabel('Image')
            ->setAttrib('class', 'span4')
            ->addValidator('Extension', false, 'jpg,png,gif')
            ->addValidator('Size', false, 20000)
            ->setDescription('Maximize FIle Size 2 MB')
            ->setDestination('uploads/user_profile_images/')
            ->setMaxFileSize(20000);

        $this->addElement($file);
    }


    protected function addSubmitButtonField()
    {
        $this->addSubmitButtonElement(array('name' => 'submit'));
    }

    protected function addCancelButtonField()
    {
        $this->addRedirectingCancelButtonElement(array(
            'name' => 'cancel',
            'redirectLink' => '/user/auth'
        ));
    }
}
