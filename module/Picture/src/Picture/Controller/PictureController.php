<?php
namespace Picture\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Picture\Model\Picture;
use Picture\Model\Storyboard;
use Zend\Session\Container;
use Picture\Form;


class PictureController extends AbstractActionController
{
	protected $sessionContainer;
	protected $pictureTable;
	protected $storyboardTable;
	public function indexAction()
	{
		/*
		$jsonData=array(
					array(
						'title' => 'img03',
						'src'   => 'img03.jpg'	
					),
					array(
							'title' => 'img04',
							'src'   => 'img04.jpg'
					),
		);
		
		$json=json_encode($jsonData);
		echo $json;
		echo "<br>";
		$dejson=json_decode($json,true);
		
		echo $dejson[0]['title'];
		
		*/
		//$storyboard=$this->getStoryboardTable()->fetchAll();
		$storyboard=$this->getStoryboardTable()->fetchAll();
		$storyboard=json_decode($storyboard->data,true);
		
		
		$files = $this->getPictureTable()->fetchAll();		
		$files = unserialize($files->src);

		
		$this->sessionContainer = new Container('picture');
		return new ViewModel(array(
				'pictures' => $files,
				'storyboard' => $storyboard,
        ));
	}
	public function successAction()
	{
		return array(
				'formData' => $this->sessionContainer->formData,
		);
	}

	public function storyboardeditAction()
	{
		$storyboard=$this->getStoryboardTable()->fetchAll();
		$storyboard= json_decode($storyboard->data,true);
		$form= new Form\StoryboardForm('storyboard');
		
		$form->setData($storyboard[0]);
		return array(
				'form'=>$form,
				'storyboard'=>$storyboard[0]
		);
	}
	
	public function addAction()
	{
		
		$form = new Form\PictureForm('file-form');
	
		if ($this->getRequest()->isPost()) {
			$picture = new Picture();
			// Postback
			$data = array_merge_recursive(
					$this->getRequest()->getPost()->toArray(),
					$this->getRequest()->getFiles()->toArray()
			);
	
			$form->setData($data);
			if ($form->isValid()) {
		
				$data = $form->getData();
				$this->sessionContainer->formData = $data;
				
				
				$picture->exchangeArray($data);
				$this->getPictureTable()->savePicture($picture);

				$this->redirect()->toRoute('picture');
				
			}
		}
	
		return array('form' => $form);
	}
	
	public function getPictureTable()
	{
		if (!$this->pictureTable) {
			$sm = $this->getServiceLocator();
			$this->pictureTable = $sm->get('Picture\Model\PictureTable');
		}
		return $this->pictureTable;
	}
	
	public function getStoryboardTable()
	{
		if (!$this->storyboardTable) {
			$sm = $this->getServiceLocator();
			$this->storyboardTable = $sm->get('Picture\Model\StoryboardTable');
		}
		return $this->storyboardTable;
	}
	
	public function deleteAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);

				$this->getPictureTable()->deletePicture($id);
		
	
			// Redirect to list of albums
			return $this->redirect()->toRoute('picture');
		
	
	}
	
}