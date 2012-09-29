<?php
/**
 * notic Entry Form
 *
 * @notic        Form
 * @package         notice
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2011
 */
class Admin_Form_NoticeEntry extends Speed_Form_Base
{
    public function __construct($options = array())
    {

        parent::__construct();
        $isEdit = empty($options['isEdit']) ? false : true;

        $this->initForm($isEdit);
        $this->loadElements($options, $isEdit);

        $this->finalizeForm();
        EasyBib_Form_Decorator::setFormDecorator($this, EasyBib_Form_Decorator::BOOTSTRAP,
        empty($isEdit) ? 'add' : 'update');
    }

    protected function initForm($isEdit = false)
    {
        $options = array(
            'name' => 'notic-form',
            'class' => 'span7',
            'id' => (empty($isEdit) ? 'add' : 'edit') . '-notic-form'
        );

        $this->initializeForm($options);
    }

    protected function loadElements($options, $isEdit)
    {
        
        $this->addNoticTitelField();
       	$this->addNoticDesctiptionField();
        $this->addSubmitButtonField($isEdit);
        $this->addCancelButtonElement();
        empty($isEdit) || $this->addHiddenElement('notice_id ');
    }

   protected function addNoticTitelField()
    {
        $options = array(
            'name' => 'title',
            'label' => 'Titel: ',
            'class' => 'span6',
            'messageForRequired' => "Please enter titel."
        );

        $this->addTextElement($options);
    }



    protected function addNoticDesctiptionField()
    {
        $options = array(
            'name' => 'description',
            'label' => 'Description',
            'class' => 'span6',
            'messageForRequired' => "Please enter description."
        );
        $this->addTextAreaElement($options);
    }

    protected function addSubmitButtonField($isEdit = null)
    {
        $name = empty($isEdit) ? 'add' : 'update';
        $this->addSubmitButtonElement(array(
            'name' => $name,
            'id' => $name . '-button'
        ));
    }

	
}