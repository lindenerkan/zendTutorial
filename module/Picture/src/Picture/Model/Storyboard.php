<?php	
namespace Picture\Model;

use Zend\InputFilter\FileInput;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Storyboard
{
    public $id;
    public $data;
    
	protected $inputFilter;    
    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;
        $this->data  = (isset($data['data'])) ? $data['data'] : null;
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
    				'name'     => 'id',
    				'required' => true,
    				'filters'  => array(
    						array('name' => 'Int'),
    				),
    		)));
    
    		
    
    		$inputFilter->add($factory->createInput(array(
    				'name'     => 'data',
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