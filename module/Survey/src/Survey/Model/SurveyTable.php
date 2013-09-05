<?php
namespace Survey\Model;
//include 'JotForm.php';

use Zend\Db\TableGateway\TableGateway;
use Survey\Model\JotForm;

class Exception
{
	public function __construct($e){
		echo $e;
	}
}

class SurveyTable
{
    protected $tableGateway;
	protected $jotFormApi;
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
        $this->jotFormApi = new JotForm();
    }
    
    public function getSurveyRow($projectId)
    {
    	$projectID=(int) $projectId;
    	$row = $this->tableGateway->select(array('projectID' => $projectID,
    			'namespace' => 'analiz',
    			'form'      => 'survey')
    	)->current();
    	return $row;
    }
    
    public function isSurveyUser($projectId)
    {
    	$projectID=(int) $projectId;
    	$row=$this->getSurveyRow($projectID);
    	//echo $row->value."<br>";
    	if($row)
    	{
    		$str=$row->value;
    		$t=(explode('/', $str));
    		$apiKey=$this->loginSurvey($t[0], $t[2]);
    		return $t[0];
    	}
    	else 
    	{
    		$username='groupogret'.rand(1, 100).$projectID;
    		$password=$username;
    		$email='deniyorumgelecekmidiye3@gmail.com';
    		$appname='jotform';
    		
    		$userDetails = array("username" => $username, 
    							"password"  => $password,
    							"email"     => $email
    						);
    		
    		$response = $this->jotFormApi->registerUser($userDetails);
    		if (isset($response['username'])) {
    			$apiKey=$this->loginSurvey($username, $password);
    			$value=$username.'/'.$email.'/'.$password.'/'.$apiKey.'/';
    			$this->tableGateway->insert(array(
    										'projectID' => $projectID,
    										'namespace' => 'analiz',
    										'form'      => 'survey',
    										'value'     => $value
    								));
    			return $username;
    		}
    		else 
    			echo 'Could not Registered. Contact with your instructor.';
    	}
    }
    
    public function loginSurvey($username,$password)
    {
    	$creadentials = array(
    			"username" => $username,
    			"password" => $password,
    			"appName" => "jotform",
    			"access" => "full",
    	);
    	$response = $this->jotFormApi->loginUser($creadentials);
    	if (isset($response['appKey'])) {
    		$this->jotFormApi->setApiKey($response['appKey']);
    		return $response['appKey'];
    	}
    	else 
    		echo 'Could not Login. Contact with your instructor.';
    }
    
    public function isPublished($projectID)
    {
    	$row=$this->getSurveyRow($projectID);
    	$str=$row->value;
    	$t=(explode('/', $str));
    	if($t[5]=="Published")
    	{
    		return true;
    	}
    	else
    		return false;
    }
    
    public function publishSurvey($projectID)
    {
    	$row=$this->getSurveyRow($projectID);
    	$value=$row->value.'/Published';
    	$this->tableGateway->update(array(
    			'projectID' => $projectID,
    			'namespace' => 'analiz',
    			'form'      => 'survey',
    			'value'     => $value
    	),
    			array('projectID' => $projectID,
    					'namespace' => 'analiz',
    					'form'      => 'survey'
    			)
    	);
    }
    
    public function getResults($formID,$username="groupogr66",$password="groupogr")
    {
    	$this->loginSurvey($username, $password);
    	$submissions = $this->jotFormApi->getFormSubmissions($formID);
    	return $submissions;
    }
    
    public function isForm($projectID)
    {
    	$row=$this->getSurveyRow($projectID);
    	$str=$row->value;
    	$t=(explode('/', $str));
    	if($t[4])
    	{
    		return $t[4];
    	}
    	else
    	{
    		$form = array(
		        'questions' => array(
		            array(
		                'type' => 'control_head',
		                'text' => 'Anket',
		                'order' => '1',
		                'name' => 'Header',
		            ),
	        		array(
	        				'type' => 'control_textbox',
	        				'text' => 'Text Box',
	        				'order' => '2',
	        				'name' => 'TextBox',
	        				'validation' => 'None',
	        				'required' => 'No',
	        				'readonly' => 'No',
	        				'size' => '20',
	        				'labelAlign' => 'Auto',
	        				'hint' => '',
	        		),
		        ),
		        'properties' => array(
		            'title' => 'Ogret Form',
		            'height' => '600',
		        ),
		    );
		    $response = $this->jotFormApi->createForm($form);
		    $forms = $this->jotFormApi->getForms(0, 1, null, null);
		    $latestForm = $forms[0];
		    $latestFormID = $latestForm["id"];
		    $this->tableGateway->update(array(
		    								'projectID' => $projectID,
		    								'namespace' => 'analiz',
		    								'form'      => 'survey',
		    								'value'     => $row->value . $latestFormID
		    								), 
		    							array('projectID' => $projectID,
		    									'namespace' => 'analiz',
		    									'form'      => 'survey'
		    								)
		    						);
		    return $latestFormID;
    	}
    }
}