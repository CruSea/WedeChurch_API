<?php
/**
 * Created by PhpStorm.
 * User: bengeos
 * Date: 6/12/17
 * Time: 2:12 PM
 */
namespace WedeChurch;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use WedeChurch\Controllers\WedeChurchController;
use WedeChurch\Factories\WedeChurchControllerFactory;

return array(
    'router' => array(
        'routes' => array(
            'wede_church_api' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/api',
                    'defaults' => array(
                        'controller' => WedeChurchController::class,
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'factories' => array(
            WedeChurchController::class => WedeChurchControllerFactory::class,
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