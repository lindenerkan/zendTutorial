<?php	
namespace Image\Model;

use Zend\InputFilter\FileInput;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Image
{
    public $id;
    public $src;
    public $title;
    
	protected $inputFilter;    
    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;
        $this->title  = (isset($data['text'])) ? $data['text'] : null;
        $this->src  = (isset($data['file']['name'])) ? $data['file']['name'] : $data['src'];
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
    				'name'     => 'title',
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
    										'max'      => 100,
    								),
    						),
    				),
    		)));
    		
    		
    		
    		
    		
    		
    		
    		
    		$this->inputFilter = $inputFilter;
    	}
    
    	return $this->inputFilter;
    }
 
 }