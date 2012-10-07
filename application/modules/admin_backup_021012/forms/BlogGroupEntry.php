<?php
/**
 * Group Type Entry Form
 *
 * @category        Form
 * @package         Group Type
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2012
 */
class Admin_Form_BlogGroupEntry extends Speed_Form_Base
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
            'name' => 'category-form',
            'class' => 'span7',
            'id' => (empty($isEdit) ? 'add' : 'edit') . '-category-form'
        );

        $this->initializeForm($options);
    }

    protected function loadElements($options, $isEdit)
    {
        $this->addBlogGroupTypeField($options['blog_group_type_id']);
        $this->addgroupField();	
        $this->addSubmitButtonField($isEdit);
        $this->addCancelButtonElement();
        empty($isEdit) || $this->addHiddenElement('blog_group_id');
    }

    protected function addBlogGroupTypeField($blogGroupType)
    {
        $field = new Zend_Form_Element_Select('blog_group_type_id');

        foreach ($blogGroupType AS $value) {
            $field->addMultiOptions(array($value['blog_group_type_id'] => $value['group_type']));
        }

        $field->setAttrib('class', 'span4')
            ->setAttrib('id', 'blog_group_type_id')
            ->setLabel('Blog group type');

        $this->formElements['blog_group_type_id'] = $field;
    }

       protected function addgroupField()	
    {
        $options = array(
            'name' => 'blog_group',
            'label' => 'Group Name: ',
            'class' => 'span6',
            'messageForRequired' => "Please enter the group type."
        );

        $this->addTextElement($options);
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
