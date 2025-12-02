<?php
return [
    'controllers' => [
        'invokables' => [
            'BienEtre\Controller\Index' => Controller\IndexController::class,
        ],
    ],
    'router' => [
        'routes' => [
            'bien-etre' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/bien-etre',
                    'defaults' => [
                        '__NAMESPACE__' => 'BienEtre\Controller',
                        'controller' => 'Index',
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'create' => [
                        'type' => 'Literal',
                        'options' => [
                            'route' => '/create',
                            'defaults' => [
                                'action' => 'create',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
