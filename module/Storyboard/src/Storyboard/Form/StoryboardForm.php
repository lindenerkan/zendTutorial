<?php

namespace Storyboard\Form;

//use Zend\InputFilter;
use Zend\Form\Form;
use Zend\Form\Element;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class StoryboardForm extends Form
{
	protected $inputFilter;
	
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
        $this->addElements();
        $this->setInputFilter($this->createInputFilter());
    }

    public function addElements()
    {
        // File Input
        
    	
    	$file = new Element\File('src');
        $file
            ->setAttributes(array(
                'id' => 'src',
            ));
        $file->setLabel('Image: ');
        $this->add($file);

        // Text Input
        $text = new Element\Textarea('title');
        $text->setLabel('Text: ');
        $this->add($text);
        
        
    }

    public function createInputFilter()
    {
        
    	
    	$this->inputFilter = new InputFilter();
    	$factory = new InputFactory();
    	
    	$this->inputFilter->add(
    			$factory->createInput(
    					array(
    							'name' => 'src',
    							'required' => true,
    							'filters' => array(
    									new \Zend\Filter\File\RenameUpload(array(
    											'target' => './data/tmpuploads',
    											'randomize' => true,
    											'overwrite' => true,
    											'use_upload_name'=>true,
    									))
    							),
    							'validators' => array(
    									new \Zend\Validator\File\UploadFile(),
    									new \Zend\Validator\File\Extension(array(
    											'jpg',
    											'png',
    											'gif'
    									)),
    									new \Zend\Validator\File\Size(array(
    											'max' => 5 * 1024 * 1024
    									))
    							)
    					),
    					array(
    							'name'=>'title',
    							'required'=>true,
    							'filters'=>array(
    									
    							),
    							'validators' => array(
    							)
    						)
    					));
    	
        return $this->inputFilter;
    }
}