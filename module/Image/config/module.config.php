<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Image\Controller\Image' => 'Image\Controller\ImageController',
        ),
    ),
		
		'router' => array(
				'routes' => array(
						'image' => array(
								'type'    => 'segment',
								'options' => array(
										'route'    => '/image[/][:action][/:id]',
										'constraints' => array(
												'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'id'     => '[0-9]+',
										),
										'defaults' => array(
												'controller' => 'Image\Controller\Image',
												'action'     => 'index',
										),
								),
						),
				),
		),
    'view_manager' => array(
        'template_path_stack' => array(
            'image' => __DIR__ . '/../view',
        ),
    ),
);