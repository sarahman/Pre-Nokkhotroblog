<?php
/**
 * Discussion Type Entry Form
 *
 * @category        Form
 * @package         Discussion Type
 * @author          Mohammad Zafar Iqbal <zafar@speedplusnet.com>
 * @copyright       Copyright (c) 2012
 */
class Admin_Form_DiscussionEntry extends Speed_Form_Base
{
    
    
    public function __construct($options = array())
        {
            parent::__construct();

            $isEdit = empty($options['isEdit']) ? false : true;

            $this->initForm();
            $this->addTitleField($isEdit);
            $this->addDiscussioField($isEdit);
            $this->addDayField();
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

        protected function addTitleField()
    {
        $options = array(
            'name' => 'title',
            'label' => 'Title Name: ',
            'class' => 'span6',
            'messageForRequired' => "Please enter the title."
        );

        $this->addTextElement($options);
    }

       protected function addDiscussioField()	
    {
        $options = array(
            'name' => 'description',
            'label' => 'Discussion: ',
            'class' => 'span6',
            'messageForRequired' => "Please enter the Discussion."
        );

        $this->addTextAreaElement($options);
    }
       protected function addDayField()	
    {
        $options = array(
            'name' => 'valid_day',
            'label' => 'Valid day: ',
            'class' => 'span6',
            'messageForRequired' => "Please enter the Valid day."
        );

        $this->addTextElement($options);
    }

        protected function addSubmitButtonField()
        {
            $this->addSubmitButtonElement(array('name' => 'submit'));
        }

        protected function addCancelButtonField()
        {
            $this->addRedirectingCancelButtonElement(array(
                'name' => 'cancel',
                'redirectLink' => '/admin/discussions/index'
            ));
        }
}
