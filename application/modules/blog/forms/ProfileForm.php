<?php
/**
 * User Profile Form
 * @category        Form
 * @copyright       Copyright (c) 2012
 * @author          Md. zafar <zafar@speedplusenet.com>
 */
class Blog_Form_ProfileForm extends Speed_Form_Base
{
    public function __construct($options = array())
    {
        parent::__construct();
        $isEdit = empty($options['isEdit']) ? false : true;
        $this->initForm();
        $this->addDisplayField();
        $this->addNameField();
        $this->addEmailField($isEdit);
        $this->addSexField(); // Extra
        //$this->addMarital_statusField(); // New add Sep24
        $this->addProfessionField(); // New add Sep24
        $this->addUserPhoneField(); // New add Sep24
        $this->addDistrictField(); // New add Sep24
        $this->addCountryField(); // New add Sep24
        $this->addHobbyField(); // New add Sep24
        // $this->addProfessionNewField(); // Ex
        // $this->addEducationalField(); // New add Sep24
        $this->addBioField();
        $this->addFacebookLink();
        $this->addTwitterLink();
        $this->addGtalkLink();
        $this->addLinkedinLink();
        $this->addDobField();
        $this->addTaglineField();
        $this->addProfileImage();
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

    protected function addNameField()
    {
        $options = array(
            'name' => 'name',
            'label' => 'নাম',
            'class' => 'span10',
            'messageForRequired' => 'name is required.'
        );
        $this->addTextElement($options);
    }

    protected function addEmailField($isEdit = false)
    {
        $options = array(
            'name' => 'email_address',
            'label' => 'ইমেইল ঠিকানা',
            'class' => 'span10',
            'messageForRequired' => 'Email Address is required and has to be unique.'
        );
        $element = $this->addTextElement($options);
        $element->addValidator('EmailAddress', true, array('messages' => 'Please enter valid email address'));
        if ($isEdit == false) {
            $element->addValidator(new Zend_Validate_Db_NoRecordExists(
                                       array('table' => 'users', 'field' => 'email_address')));
        }
    }

    protected function addDisplayField()
    {
        $options = array(
            'name' => 'display_name',
            'label' => 'ছদ্ম নাম',
            'class' => 'span10',
        );
        $this->addTextElement($options);
    }

    protected function addFacebookLink()
    {
        $options = array(
            'name' => 'facebook_link',
            'label' => 'ফেসবুক লিংক',
            'class' => 'span10',
        );
        $this->addTextElement($options);
    }

    protected function addTwitterLink()
    {
        $options = array(
            'name' => 'twitter_link',
            'label' => 'টুইটার লিংক',
            'class' => 'span10',
        );
        $this->addTextElement($options);
    }

    protected function addGtalkLink()
    {
        $options = array(
            'name' => 'gtalk_link',
            'label' => 'জি-টক লিংক',
            'class' => 'span10',
        );
        $this->addTextElement($options);
    }

    protected function addLinkedinLink()
    {
        $options = array(
            'name' => 'linkedin_link',
            'label' => 'লিঙ্কডইন লিংক',
            'class' => 'span10',
        );
        $this->addTextElement($options);
    }

    protected function addDobField()
    {
        $options = array(
            'name' => 'date_of_birth',
            'label' => 'জন্মতারিখ',
            'class' => 'span2 hasDatepicker',
            'messageForRequired' => 'name is required.'
        );
        $this->addTextElement($options);
    }

    protected function addBioField()
    {
        $options = array(
            'name' => 'bio',
            'label' => 'জীবন বৃত্তান্ত',
            'class' => 'span10',
            'rows' => 10,
            'cols' => 20,
        );
        $this->addTextAreaElement($options);
    }

    protected function addTaglineField()
    {
        $options = array(
            'name' => 'tagline',
            'label' => 'টেগ লাইন',
            'class' => 'span10',
        );
        $this->addTextElement($options);
    }

    protected function addProfileImage()
    {
        $file = new Zend_Form_Element_File('profile_picture');
        $file->setLabel('আপনার ছবি')
            ->setAttrib('class', 'span4')
            ->addValidator('Extension', false, 'jpg,png,gif')
            ->addValidator('Size', false, 100000)
            ->setDescription('ফাইলের মাপ 1 মেগাবাইট রাখুন')
            ->setDestination('uploads/user_profile_images/')
            ->setMaxFileSize(100000);
        $this->formElements['profile_picture'] = $file;
    }

    public function addBannerImage()
    {
        $file = new Zend_Form_Element_File('user_panel_benner');
        $file->setLabel('ব্যানার চিত্র')
            ->addValidator('Extension', false, 'jpg,png,gif')
            ->addValidator('Size', false, 100000)
            ->setDescription('Maximize FIle Size 1 MB')
            ->setDestination('uploads/user_panel_benner/')
            ->setMaxFileSize(100000);
        $this->formElements['user_panel_benner'] = $file;
    }

    // Mohammad Zafar iqbal Update Sep24
    protected function addCountryField()
    {
        $options = array(
            'name' => 'country',
            'label' => 'দেশ',
            'class' => 'span10',
        );
        $this->addTextElement($options);
    }

    protected function addDistrictField()
    {
        $options = array(
            'name' => 'district',
            'label' => 'জেলা',
            'class' => 'span10',
        );
        $this->addTextElement($options);
    }

    protected function addUserPhoneField()
    {
        $options = array(
            'name' => 'phone',
            'label' => 'ফোন নম্বর',
            'class' => 'span10',
        );
        $this->addTextElement($options);
    }

    protected function addProfessionNewField()
    {
        $options = array(
            'name' => 'profession',
            'label' => 'Your profession',
            'class' => 'span10',
        );
        $this->addTextElement($options);
    }

    protected function addMarital_statusField()
    {
        $field = new Zend_Form_Element_Select('marital_status');
        {
            $field->addMultiOptions(array(
                                        'বিবাহিত' => 'বিবাহিত',
                                        'অ-বিবাহিত' => 'অ-বিবাহিত'));
        }
        $field->setAttrib('class', 'span6')
            ->setAttrib('id', 'marital_status')
            ->setLabel('বৈবাহিক অবস্থা');
        $this->formElements['marital_status'] = $field;
    }

    protected function addSexField()
    {
        $field = new Zend_Form_Element_Select('sex');
        {
            $field->addMultiOptions(array(
                                        'পুরুষ' => 'পুরুষ',
                                        'নারী' => 'নারী'));
        }
        $field->setAttrib('class', 'span6')
            ->setAttrib('id', 'sex')
            ->setLabel('লিঙ্গ');
        $this->formElements['sex'] = $field;
    }

    protected function addProfessionField()
    {
        $field = new Zend_Form_Element_Select('profession');
        {
            $field->addMultiOptions(array(
                                        'শিক্ষক' => 'শিক্ষক',
                                        'ছাত্র' => 'ছাত্র',
                                        'ব্যবসা' => 'ব্যবসা',
                                        'চাকুরী জীবি' => 'চাকুরী জীবি',
                                        'আইটি -পরামর্শদাতা' => 'আইটি -পরামর্শদাতা',
                                        'ডাক্তার' => 'ডাক্তার',
                                        'যন্ত্রশিল্পী' => 'যন্ত্রশিল্পী',
                                        'গৃহিনী' => 'গৃহিনী'
                                    ));
        }
        $field->setAttrib('class', 'span6')
            ->setAttrib('id', 'profession')
            ->setLabel('পেশা');
        $this->formElements['profession'] = $field;
    }

    protected function addHobbyField()
    {
        $options = array(
            'name' => 'hobby',
            'label' => 'আপনার শখ',
            'class' => 'span10',
        );
        $this->addTextElement($options);
    }

    protected function addEducationalField()
    {
        $options = array(
            'name' => 'educational_background',
            'label' => 'শিক্ষাগত প্রেক্ষাপট',
            'class' => 'span10',
        );
        $this->addTextElement($options);
    }

// End Update  
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

