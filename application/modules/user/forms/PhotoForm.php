<?php
/**
 * User Profile Form
 * @category        Form
 * @copyright       Copyright (c) 2011
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 */
class User_Form_PhotoForm extends Speed_Form_Base
{
    public function __construct($options = array())
    {
        parent::__construct();
        $isEdit = empty($options['isEdit']) ? false : true;
        $this->initForm();
        $this->addTitleField();
        $this->addGallryImage();
        $this->addSubmitButtonField();
        $this->addCancelButtonField();
        $this->finalizeForm();
        EasyBib_Form_Decorator::setFormDecorator($this, EasyBib_Form_Decorator::BOOTSTRAP, 'submit', 'cancel');
    }

    protected function initForm()
    {
        $options = array(
            'name' => 'Edit Profile',
            'class' => 'span10',
            'enctype' => 'multipart/form-data'
        );
        $this->initializeForm($options);
    }

    protected function addTitleField()
    {
        $options = array(
            'name' => 'name',
            'label' => 'Image Title',
            'class' => 'span10',
            'messageForRequired' => 'name is required.'
        );
        $this->addTextElement($options);
    }

    protected function addGallryImage()
    {
        $file = new Zend_Form_Element_File('albam_picture');
        $file->setLabel('Image')
            ->setAttrib('class', 'span4')
            ->addValidator('Extension', false, 'jpg,png,gif')
            ->addValidator('Size', false, 100000)
            ->setDescription('Maximize FIle Size 1 MB')
            ->setDestination('uploads/user_albam_picture/')
            ->setMaxFileSize(100000);
        $this->formElements['albam_picture'] = $file;
    }

    protected function addSubmitButtonField()
    {
        $this->addSubmitButtonElement(array('name' => 'submit'));
    }

    protected function addCancelButtonField()
    {
        $this->addRedirectingCancelButtonElement(array(
                                                     'name' => 'cancel',
                                                     'redirectLink' => '/user/photo/index'
                                                 ));
    }
}

