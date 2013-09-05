<?php
namespace Survey\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Survey\Model\Survey;
use Zend\Session\Container;


class SurveyController extends AbstractActionController
{
	protected $surveyTable;
	
	public function indexAction()
	{
		$projectID=6;
		$user=$this->getSurveyTable()->isSurveyUser($projectID);
		$formID=$this->getSurveyTable()->isForm($projectID);
		$isPublished=$this->getSurveyTable()->isPublished($projectID);
		    return new ViewModel(array(
	    			'formID'      => $formID,
		    		'user'        => $user,
		    		'isPublished' => $isPublished,
		    		'projectID'   => $projectID
	    ));
	}
	
	public function publishAction()
	{
		$projectID = (int) $this->params()->fromRoute('id', 0);
		$this->getSurveyTable()->publishSurvey($projectID);
		$this->redirect()->toRoute('survey');
	}
	
	public function surveyviewAction()
	{
		$formID = $this->params()->fromRoute('id', 0);
		return new ViewModel(array(
				'formID'      => $formID,
		));
	}
	
	public function resultAction()
	{
		$formID = $this->params()->fromRoute('id', 0);
		$results=$this->getSurveyTable()->getResults($formID);
		return new ViewModel(array(
				'results'      => $results,
				
		));
	}
	
    public function getSurveyTable()
    {
    	if (!$this->surveyTable) {
    		$sm = $this->getServiceLocator();
    		$this->surveyTable = $sm->get('Survey\Model\SurveyTable');
    	}
    	return $this->surveyTable;
    }
}
//75efe44b4994313f2e1094a43598cc9f