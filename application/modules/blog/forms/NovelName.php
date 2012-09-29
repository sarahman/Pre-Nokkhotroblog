

<?php
/**
 * Discussion Type Entry Form
 *
 * @category        Form
 * @package         Blog
 * @author          Mohammad Zafar Iqbal <zafar@speedplusnet.com>
 * @copyright       Copyright (c) 2012
 */
class Blog_Form_NovelName extends Speed_Form_Base
{
     
    public function __construct($options = array())
        {
            parent::__construct();

            $isEdit = empty($options['isEdit']) ? false : true;

            $this->initForm();
            $this->addNovelNameField($isEdit); 
            $this->addSubmitButtonField();
            $this->addCancelButtonField();
            $this->finalizeForm();
            EasyBib_Form_Decorator::setFormDecorator($this, EasyBib_Form_Decorator::BOOTSTRAP,'submit','cancel');
        }

        protected function initForm()
        {
            $options = array(
                'name'  => 'novel-name-form',
                'class' => 'span11'
            );

            $this->initializeForm($options);
        }

    protected function addNovelNameField()
    {
        $options = array(
            'name' => 'novel_name',
            'label' => 'Novel Name',
            'class' => 'span11',
            'messageForRequired' => "Please enter the Episode Type."
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
                'redirectLink' => '/novel/name'
            ));
        }
        
        
}

