<?php
namespace Storyboard;


use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Storyboard\Model\Storyboard;
use Storyboard\Model\StoryboardTable;

class Module
{
	public function onBootstrap(MvcEvent $e)
	{
		$eventManager        = $e->getApplication()->getEventManager();
		$moduleRouteListener = new ModuleRouteListener();
		$moduleRouteListener->attach($eventManager);
	}
	
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
						'Storyboard\Model\StoryboardTable' =>  function($sm) {
							$tableGateway = $sm->get('StoryboardTableGateway');
							$table = new StoryboardTable($tableGateway);
							return $table;
						},
						'StoryboardTableGateway' => function ($sm) {
							$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype->setArrayObjectPrototype(new Storyboard());
							return new TableGateway('storyboard', $dbAdapter, null, $resultSetPrototype);
						},
				),
		);
	}
}
