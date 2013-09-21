<?php
/**
 * Sub Category Entry Form
 *
 * @category        Form
 * @package         Admin
 * @author          Mustafa Ahmed Khan <tamal_29@yahoo.com>
 * @copyright       Copyright (c) 2012
 */
class Admin_Form_SubcategoryEntry extends Speed_Form_Base
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
        $this->addCategoryField($options['blog_category_id']);      
        $this->addsubcategoryField();	
        $this->addSubmitButtonField($isEdit);
        $this->addCancelButtonElement();
        empty($isEdit) || $this->addHiddenElement('subcategory_id');  
    }

    protected function addCategoryField($category)        
    {
        $field = new Zend_Form_Element_Select('blog_category_id');  

        foreach ($category AS $value) {                    
            $field->addMultiOptions(array($value['blog_category_id'] => $value['category_name']));        
        }

        $field->setAttrib('class', 'span4')
            ->setAttrib('id', 'blog_category_id')      
            ->setLabel('Blog Category');

        $this->formElements['blog_category_id'] = $field;      
    }

       protected function addsubcategoryField()	
    {
        $options = array(
            'name' => 'subcategory_name',    
            'label' => 'Sub Category: ',     
            'class' => 'span6',
            'messageForRequired' => "Please enter the sub category."
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
