<?php
/**
 * Discussion Type Entry Form
 *
 * @category        Form
 * @package         Discussion Type
 * @author          Mohammad Zafar Iqbal <zafar@speedplusnet.com>
 * @copyright       Copyright (c) 2012
 */
class Blog_Form_EpisodEntry extends Speed_Form_Base
{
    
    
    public function __construct($options = array())
        {
            parent::__construct();

            $isEdit = empty($options['isEdit']) ? false : true;

            $this->initForm();
            
            $this->addEpisodNumberField();
            $this->addBlogstatusField($options['status']); 
            $this->addEpisodDescriptionField($isEdit);
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


    protected function addEpisodNumberField()  
    {
        $options = array(
            'name' => 'episode_number',
            'label' => 'Episode Number: ',
            'class' => 'span6',
            'messageForRequired' => "Please enter the Discussion."
        );

      $this->addTextElement($options);
    }
    
    protected function addBlogstatusField($blogStatus)
    {
        $field = new Zend_Form_Element_Select('status');

        foreach ($blogStatus AS $value) {
            $field->addMultiOptions(array($value['status'] => $value['status']));
        }

        $field->setAttrib('class', 'span6')
            ->setAttrib('id', 'status')
            ->setLabel('Status');

        $this->formElements['status'] = $field;
    }
     
    protected function addEpisodDescriptionField()  
    {
        $options = array(
            'name' => 'description',
            'label' => 'Description: ',
            'class' => 'span6',
            'messageForRequired' => "Please enter the Description."
        );
          $this->addTextAreaElement($options);
    }
    
    protected function addSubmitButtonField()
        {
            $this->addSubmitButtonElement(array('name' => 'submit'));
        }

        protected function addCancelButtonField()
        {
            $this->addRedirectingCancelButtonElement(array(
                'name' => 'cancel',
                'redirectLink' => '/blog/episods/index'
            ));
        }
        
}
