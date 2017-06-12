<?php
/**
 * Created by PhpStorm.
 * User: bengeos
 * Date: 5/24/17
 * Time: 11:31 AM
 */
namespace NegaritSMS;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use NegaritSMS\Controllers\APIController;
use NegaritSMS\Controllers\MainController;
use NegaritSMS\Controllers\PhoneController;
use NegaritSMS\Factories\APIControllerFactory;
use NegaritSMS\Factories\MainControllerFactory;
use NegaritSMS\Factories\PhoneControllerFactory;

return array(
    'router' => array(
        'routes' => array(
            'negarit_api' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/negarit',
                    'defaults' => array(
                        'controller' => MainController::class,
                    ),
                ),
            ),
            'messages_api' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/messages',
                    'defaults' => array(
                        'controller' => APIController::class,
                    ),
                ),
            ),
            'phone_api' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/phone',
                    'defaults' => array(
                        'controller' => PhoneController::class,
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'factories' => array(
            MainController::class => MainControllerFactory::class,
            APIController::class => APIControllerFactory::class,
            PhoneController::class => PhoneControllerFactory::class,
        ),
    ),
    'view_manager' => array(
        'strategies' => array(
            'ViewJsonStrategy',
        ),
        'display_not_found_reason' => false,
        'display_exceptions' => false,
        'doctype' => 'HTML5',
    ),
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Entities')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entities' => __NAMESPACE__ . '_driver'
                )
            )
        )
    ),
);