<?php
/**
 * Created by PhpStorm.
 * User: bengeos
 * Date: 5/5/17
 * Time: 8:19 PM
 */
namespace PhoneBook;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use PhoneBook\Controllers\PhoneBookController;
use PhoneBook\Factories\PhoneBookControllerFactory;

return array(
    'router' => array(
        'routes' => array(
            'phone_book_api' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/phone_api',
                    'defaults' => array(
                        'controller' => PhoneBookController::class,
                    ),
                ),
            )
        ),
    ),
    'controllers' => array(
        'factories' => array(
            PhoneBookController::class => PhoneBookControllerFactory::class,
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