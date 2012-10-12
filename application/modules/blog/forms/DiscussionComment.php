<?php
/**
 * Discussion Type Entry Form
 * @category        Form
 * @package         Discussion Type
 * @author          Mohammad Zafar Iqbal <zafar@speedplusnet.com>
 * @copyright       Copyright (c) 2012
 */
class Blog_Form_DiscussionComment extends Speed_Form_Base
{
    public function __construct($options = array())
    {
        parent::__construct();
        $isEdit = empty($options['isEdit']) ? false : true;
        $this->initForm();
        $this->addDiscussionCommentField($isEdit);
        $this->addSubmitButtonField();
        $this->addCancelButtonField();
        $this->finalizeForm();
        EasyBib_Form_Decorator::setFormDecorator($this, EasyBib_Form_Decorator::BOOTSTRAP, 'submit', 'cancel');
    }

    protected function initForm()
    {
        $options = array(
            'name' => 'comment-form',
            'class' => 'span12'
        );
        $this->initializeForm($options);
    }

    protected function addDiscussionCommentField()
    {
        $options = array(
            'name' => 'comment',
            'label' => 'Comment : ',
            'class' => 'span10',
            'rows' => 8,
            'cols' => 15
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
                                                     'redirectLink' => '/blog/discussions/index'
                                                 ));
    }
}

