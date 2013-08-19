<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Storyboard\Controller\Storyboard' => 'Storyboard\Controller\StoryboardController',
        ),
    ),
		
		'router' => array(
				'routes' => array(
						'storyboard' => array(
								'type'    => 'segment',
								'options' => array(
										'route'    => '/storyboard[/][:action][/:id][/:data]',
										'constraints' => array(
												'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'id'     => '[0-9]+',
												'data'	 => '[0-9]+',
										),
										'defaults' => array(
												'controller' => 'Storyboard\Controller\Storyboard',
												'action'     => 'index',
										),
								),
						),
				),
		),
    'view_manager' => array(
        'template_path_stack' => array(
            'storyboard' => __DIR__ . '/../view',
        ),
    ),
);