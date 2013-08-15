<?php

namespace Image\Form;

//use Zend\InputFilter;
use Zend\Form\Form;
use Zend\Form\Element;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class ImageForm extends Form
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
        $file = new Element\File('file');
        $file
            ->setLabel('Image')
            ->setAttributes(array(
                'id' => 'file',
            ));
        $this->add($file);

        // Text Input
        $text = new Element\Text('text');
        $text->setLabel('Title');
        $this->add($text);
    }

    public function createInputFilter()
    {
        
    	
    	$this->inputFilter = new InputFilter();
    	$factory = new InputFactory();
    	
    	$this->inputFilter->add(
    			$factory->createInput(
    					array(
    							'name' => 'file',
    							'required' => false,
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
    					)));
    	
    	
    	
    	
    	/*
    	$inputFilter = new InputFilter\InputFilter();

        // File Input
        $file = new InputFilter\FileInput('file');
        $file->setRequired(true);
        $file->getFilterChain()->attachByName(
            'filerenameupload',
            array(
                'target'          => './data/tmpuploads/',
                'overwrite'       => true,
                'use_upload_name' => true,
            )
        );
        $inputFilter->add($file);

        // Text Input
        $text = new InputFilter\Input('text');
        $text->setRequired(true);
        $inputFilter->add($text);
*/
        return $this->inputFilter;
    }
}