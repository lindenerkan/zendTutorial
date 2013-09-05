<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Survey\Controller\Survey' => 'Survey\Controller\SurveyController',
        ),
    ),
		
		'router' => array(
				'routes' => array(
						'survey' => array(
								'type'    => 'segment',
								'options' => array(
										'route'    => '/survey[/][:action][/:id][/:data]',
										'constraints' => array(
												'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'id'     => '[0-9]+',
												'data'	 => '[0-9]+',
										),
										'defaults' => array(
												'controller' => 'Survey\Controller\Survey',
												'action'     => 'index',
										),
								),
						),
				),
		),
    'view_manager' => array(
        'template_path_stack' => array(
            'survey' => __DIR__ . '/../view',
        ),
    ),
);