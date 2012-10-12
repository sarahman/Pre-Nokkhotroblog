<?php
/**
 * Blog Entry Form
 * @category        Form
 * @package         Blog
 * @author          Md. Sirajus Salayhin <salayhin@gmail.com>
 * @copyright       Copyright (c) 2011
 */
class Blog_Form_EpisodeEdit extends Speed_Form_Base
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
            'name' => 'episode-form',
            'class' => 'span12',
            'id' => (empty($isEdit) ? 'add' : 'edit') . '-episode-form'
        );
        $this->initializeForm($options);
    }

    protected function loadElements($options, $isEdit)
    {
        $this->addEpisodeNameField($options['episode_id']);
        $this->addEpisodeField();
        $this->addDescriptionField();
        $this->addSubmitButtonField($isEdit);
        $this->addCancelButtonElement();
        empty($isEdit) || $this->addHiddenElement('blog_id');
    }

    protected function addEpisodeNameField($episode)
    {
        $field = new Zend_Form_Element_Select('episode_id');
        foreach ($episode AS $value) {
            $field->addMultiOptions(array($value['episode_id'] => $value['episode_name']));
        }
        $field->setAttrib('class', 'span8')
            ->setAttrib('id', 'episode_id')
            ->setLabel('Episode');
        $this->formElements['episode_id'] = $field;
    }

    protected function addEpisodeField()
    {
        $options = array(
            'episode_number' => 'title',
            'label' => 'Episode Number',
            'class' => 'span12',
            'messageForRequired' => "Please enter episode number."
        );
        $this->addTextElement($options);
    }

    protected function addDescriptionField()
    {
        $options = array(
            'name' => 'description',
            'label' => 'Description',
            'class' => 'span10',
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
