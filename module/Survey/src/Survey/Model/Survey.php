<?php
namespace Survey\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
//use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Survey
{
    public $projectID;
    public $namespace;
    public $form;
    public $value;
    protected $inputFilter;
    
    public function exchangeArray($data)
    {
        $this->projectID     = (isset($data['projectID'])) ? $data['projectID'] : null;
        $this->namespace = (isset($data['namespace'])) ? $data['namespace'] : null;
        $this->form= (isset($data['form'])) ? $data['form']:null;
        $this->value= (isset($data['value'])) ? $data['value']:null;
    }
    
    public function getArrayCopy()
    {
    	return get_object_vars($this);
    }
    
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
    	throw new \Exception("Not used");
    }
    
public function getInputFilter()
    {
    	if (!$this->inputFilter) {
    		$inputFilter = new InputFilter();
    		$factory     = new InputFactory();
    
    		$inputFilter->add($factory->createInput(array(
    				'name'     => 'projectID',
    				'required' => true,
    				'filters'  => array(
    						array('name' => 'Int'),
    				),
    		)));

    		$inputFilter->add($factory->createInput(array(
    				'name'     => 'namespace',
    				'required' => true,
    				'filters'  => array(
    						array('name' => 'StripTags'),
    						array('name' => 'StringTrim'),
    				),
    				'validators' => array(
    						array(
    								'name'    => 'StringLength',
    								'options' => array(
    										'encoding' => 'UTF-8',
    										'min'      => 1,
    										'max'      => 500,
    								),
    						),
    				),
    		)));
    		
    		$inputFilter->add($factory->createInput(array(
    				'name'     => 'form',
    				'required' => true,
    				'filters'  => array(
    						array('name' => 'StripTags'),
    						array('name' => 'StringTrim'),
    				),
    				'validators' => array(
    						array(
    								'name'    => 'StringLength',
    								'options' => array(
    										'encoding' => 'UTF-8',
    										'min'      => 1,
    										'max'      => 500,
    								),
    						),
    				),
    		)));
    		
    		$inputFilter->add($factory->createInput(array(
    				'name'     => 'value',
    				'required' => true,
    				'filters'  => array(
    						array('name' => 'StripTags'),
    						array('name' => 'StringTrim'),
    				),
    				'validators' => array(
    						array(
    								'name'    => 'StringLength',
    								'options' => array(
    										'encoding' => 'UTF-8',
    										'min'      => 1,
    										'max'      => 500,
    								),
    						),
    				),
    		)));
    		
    		$this->inputFilter = $inputFilter;
    	}
    
    	return $this->inputFilter;
    }
}