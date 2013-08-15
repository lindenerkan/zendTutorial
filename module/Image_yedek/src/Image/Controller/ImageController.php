<?php
namespace Image\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Image\Model\Image;
use Zend\Session\Container;
use Image\Form;

class ImageController extends AbstractActionController
{
	protected $sessionContainer;
	protected $imageTable;
	public function indexAction()
	{
		$this->sessionContainer = new Container('image');
		return new ViewModel(array(
            'images' => $this->getImageTable()->fetchAll(),
        ));
	}
	public function successAction()
	{
		return array(
				'formData' => $this->sessionContainer->formData,
		);
	}
		
	public function addAction()
	{
		$form = new Form\ImageForm('file-form');
	
		if ($this->getRequest()->isPost()) {
			$image = new Image();
			// Postback
			$data = array_merge_recursive(
					$this->getRequest()->getPost()->toArray(),
					$this->getRequest()->getFiles()->toArray()
			);
	
			$form->setData($data);
			if ($form->isValid()) {
				//
				// ...Save the form...
				//
				
				
				
				$data = $form->getData();
				$this->sessionContainer->formData = $data;

				echo print_r($data);
				
				$image->exchangeArray($data);
				$this->getImageTable()->saveImage($image);
				
				//$response= $this->redirect()->toRoute('image');
				//$response->setStatusCode(303);
				//$this->getImageTable()->saveImage($response);
				//return $this->redirectToSuccessPage($form->getData());
				//return $response;
				$this->redirect()->toRoute('image');
				
			}
		}
	
		return array('form' => $form);
	}
	
	public function getImageTable()
	{
		if (!$this->imageTable) {
			$sm = $this->getServiceLocator();
			$this->imageTable = $sm->get('Image\Model\ImageTable');
		}
		return $this->imageTable;
	}
	public function add_oldAction()
	{
		$form = new ImageForm();
		$form->get('submit')->setValue('Add');
	
		$request = $this->getRequest();
		if ($request->isPost()) {
			$image = new Image();
			$form->setInputFilter($image->getInputFilter());
			$form->setData($request->getPost());
			
			$data=$request->getFiles();
			echo print_r($data['src']['name']);
			echo print_r($data['src']['tmp_name']);
	
			if ($form->isValid()) {
					$image->exchangeArray($form->getData(),$request->getFiles());
				$this->getImageTable()->saveImage($image);
				
				// Redirect to list of images
				return $this->redirect()->toRoute('image');
			}
		}
		return array('form' => $form);
	}
	public function deleteAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);

				$this->getImageTable()->deleteImage($id);
		
	
			// Redirect to list of albums
			return $this->redirect()->toRoute('image');
		
	
	}
	
}