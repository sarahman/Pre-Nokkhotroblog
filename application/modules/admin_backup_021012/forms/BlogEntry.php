<?php
/**
 * Blog Entry Form
 *
 * @category        Form
 * @package         Blog
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2011
 */
class Admin_Form_BlogEntry extends Speed_Form_Base
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
            'name' => 'blog-form',
            'class' => 'span12',
            'id' => (empty($isEdit) ? 'add' : 'edit') . '-blog-form'
        );

        $this->initializeForm($options);
    }

    protected function loadElements($options, $isEdit)
    {
        $this->addBlogTitleField();
        $this->addBlogcategoryField($options['blog_category_id']);
        $this->addBlogDescriptionField();
        $this->addFeaturedImage();
        $this->addSubmitButtonField($isEdit);
        $this->addCancelButtonElement();
        empty($isEdit) || $this->addHiddenElement('blog_id');
    }

    protected function addBlogcategoryField($blogCategory)
    {
        $field = new Zend_Form_Element_Select('blog_category_id');

        foreach ($blogCategory AS $value) {
            $field->addMultiOptions(array($value['blog_category_id'] => $value['category_name']));
        }

        $field->setAttrib('class', 'span6')
            ->setAttrib('id', 'blog_category_id')
            ->setLabel('Category');

        $this->formElements['blog_category_id'] = $field;
    }

    protected function addBlogTitleField()
    {
        $options = array(
            'name' => 'title',
            'label' => 'Title',
            'class' => 'span12',
            'messageForRequired' => "Please enter blog title."
        );

        $this->addTextElement($options);
    }

    protected function addBlogDescriptionField()
    {
        $options = array(
            'name' => 'description',
            'label' => 'Description',
            'class' => 'span10',
            'messageForRequired' => "Please enter description."
        );
        $this->addTextAreaElement($options);
    }

    protected function addFeaturedImage()
    {
        $file = new Zend_Form_Element_File('featured_image');

        $file->setLabel('Image')
            ->setAttrib('class', 'span4')
            ->addValidator('Extension', false, 'jpg,png,gif')
            ->setDescription('Maximize FIle Size 1 MB')
            ->setDestination('uploads/blog_featured_image/');

        $this->formElements['featured_image'] = $file;
   }

    protected function addSubmitButtonField($isEdit = null)
    {
        $name = empty($isEdit) ? 'add' : 'update';
        $this->addSubmitButtonElement(array(
            'name' => $name,
            'id' => $name . '-button'
        ));
    }

   //protected function addCancelButtonElement()
	
}
