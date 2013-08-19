<?php
namespace Picture;


use Picture\Model\Picture;
use Picture\Model\Storyboard;
use Picture\Model\PictureTable;
use Picture\Model\StoryboardTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;


class Module
{

	
	public function getAutoloaderConfig()
	{
		return array(
				'Zend\Loader\ClassMapAutoloader' => array(
						__DIR__ . '/autoload_classmap.php',
				),
				'Zend\Loader\StandardAutoloader' => array(
						'namespaces' => array(
								__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
						),
				),
		);
	}

	public function getConfig()
	{
		return include __DIR__ . '/config/module.config.php';
	}
	public function getServiceConfig()
	{
		return array(
				'factories' => array(
						'Picture\Model\PictureTable' =>  function($sm) {
							$tableGateway = $sm->get('PictureTableGateway');
							$table = new PictureTable($tableGateway);
							return $table;
						},
						'PictureTableGateway' => function ($sm) {
							$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype->setArrayObjectPrototype(new Picture());
							return new TableGateway('picture', $dbAdapter, null, $resultSetPrototype);
						},
						'Picture\Model\StoryboardTable' =>  function($sm) {
							$tableGateway2 = $sm->get('StoryboardTableGateway');
							$table2 = new StoryboardTable($tableGateway2);
							return $table2;
						},
						'StoryboardTableGateway' => function ($sm) {
							$dbAdapter2 = $sm->get('Zend\Db\Adapter\Adapter');
							$resultSetPrototype2 = new ResultSet();
							$resultSetPrototype2->setArrayObjectPrototype(new Storyboard());
							return new TableGateway('storyboard', $dbAdapter2, null, $resultSetPrototype2);
						},
				),
		);
	}
}
