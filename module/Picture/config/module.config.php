<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Picture\Controller\Picture' => 'Picture\Controller\PictureController',
        ),
    ),
		
		'router' => array(
				'routes' => array(
						'picture' => array(
								'type'    => 'segment',
								'options' => array(
										'route'    => '/picture[/][:action][/:id]',
										'constraints' => array(
												'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'id'     => '[0-9]+',
										),
										'defaults' => array(
												'controller' => 'Picture\Controller\Picture',
												'action'     => 'index',
										),
								),
						),
				),
		),
    'view_manager' => array(
        'template_path_stack' => array(
            'picture' => __DIR__ . '/../view',
        ),
    ),
);