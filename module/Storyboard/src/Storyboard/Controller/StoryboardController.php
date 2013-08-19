<?php
namespace Storyboard\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Storyboard\Model\Storyboard;
use Zend\Session\Container;
use Storyboard\Form;


class StoryboardController extends AbstractActionController
{
	protected $storyboardTable;
	protected $sessionContainer;
	public function indexAction()
	{
		$this->sessionContainer = new Container('storyboard');
		//$row=$this->getStoryboardTable()->getRow(1);

		$data=$this->getStoryboardTable()->fetchAll();
	    return new ViewModel(array(
	        'data'=>$data,
	    
	    ));
	}
	
	public function addAction()
	{
		$form = new Form\StoryboardForm();
		$id = (int) $this->params()->fromRoute('id', 0);
		
		
		
		if ($this->getRequest()->isPost()) {
			$picture = new Storyboard();
			$data = array_merge_recursive(
					$this->getRequest()->getPost()->toArray(),
					$this->getRequest()->getFiles()->toArray()
			);
			$form->setData($data);
			if ($form->isValid()) {
		
				$data = $form->getData();
				
				//$this->sessionContainer->formData = $data;
		
				
				$picture->exchangeArray($data);
				$this->getStoryboardTable()->addData($picture,$id);
		
				$this->redirect()->toRoute('storyboard');
		
			}
		}
		
		
		return array('form' => $form);
	}
	
	
	public function editAction()
	{
		$form = new Form\StoryboardEditForm();
		$id = (int) $this->params()->fromRoute('id', 0);
		$value = (int) $this->params()->fromRoute('data', 0);
		$e=$this->getStoryboardTable()->getSet($id,$value);
		$form->setData($e);
		if ($this->getRequest()->isPost()) {
			$picture = new Storyboard();
			$data = array_merge_recursive(
					$this->getRequest()->getPost()->toArray(),
					$this->getRequest()->getFiles()->toArray()
			);
			//$data=$this->getRequest()->getPost()->toArray();
			$form->setData($data);
			if ($form->isValid()) {
		
				$data = $form->getData();
		
				//$this->sessionContainer->formData = $data;
				$picture->exchangeArray($data);
				
				$this->getStoryboardTable()->editData($picture,$id,$value);
		
				$this->redirect()->toRoute('storyboard');
		
			}
		}
		
		
		return array('form' => $form,
				'e'=>$e
		);
	}

	public function deleteAction()
	{
		$value = (int) $this->params()->fromRoute('data',0);
		$id = (int) $this->params()->fromRoute('id', 0);
		
		$this->getStoryboardTable()->deleteRow($id, $value);
		$this->redirect()->toRoute('storyboard');
	}
    public function getStoryboardTable()
    {
    	if (!$this->storyboardTable) {
    		$sm = $this->getServiceLocator();
    		$this->storyboardTable = $sm->get('Storyboard\Model\StoryboardTable');
    	}
    	return $this->storyboardTable;
    }
}