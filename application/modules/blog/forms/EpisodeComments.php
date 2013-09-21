<?php
/**
 * Episode Comment Form
 *
 * @category        Form
 * @package         Episode Comment
 * @author          Mustafa Ahmed Khan <tamal_29@yahoo.com>
 * @copyright       Copyright (c) 2012
 */
class Blog_Form_EpisodeComments extends Speed_Form_Base
{
    
    
    public function __construct($options = array())
        {
            parent::__construct();

            $isEdit = empty($options['isEdit']) ? false : true;

            $this->initForm();
            $this->addEpisodeCommentField($isEdit);
            $this->addSubmitButtonField();
            $this->addCancelButtonField();

            $this->finalizeForm();
            EasyBib_Form_Decorator::setFormDecorator($this, EasyBib_Form_Decorator::BOOTSTRAP,'submit','cancel');
        }

        protected function initForm()
        {
            $options = array(
                'name'  => 'comment-form',
                'class' => 'span12'
            );

            $this->initializeForm($options);
        }

    
       protected function addEpisodeCommentField()	
    {
        $options = array(
            'name' => 'comment',
            'label' => 'Comment : ',
            'class' => 'span10',
            'rows'  => 8,
            'cols'  => 15
           
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
                'redirectLink' => '/blog/episodes/episode-detail'
            ));
        }
}

