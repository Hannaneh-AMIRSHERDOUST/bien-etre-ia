<?php
return [
    'controllers' => [
        'invokables' => [
            'BienEtreBot\Controller\Index' => BienEtreBot\Controller\IndexController::class,
        ],
    ],
    'router' => [
        'routes' => [
            'bien-etre-bot' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/bien-etre-bot',
                    'defaults' => [
                        '__NAMESPACE__' => 'BienEtreBot\Controller',
                        'controller' => 'Index',
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'chat' => [
                        'type' => 'Literal',
                        'options' => [
                            'route' => '/chat',
                            'defaults' => [
                                'action' => 'chat',
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
    'navigation' => [
        'site' => [
            [
                'label' => 'Chatbot Bien-Être',
                'route' => 'bien-etre-bot',
                'visible' => true,
            ],
        ],
    ],
];
