<?php

use Interop\Container\ContainerInterface;
use Slim\Views\Twig;
use Cart\Models\Product;
use Slim\Views\TwigExtension;
use function Di\get;

return [

    'router' => get(Slim\Router::class),
    Twig::class => function (ContainerInterface $c) {

        $twig = new Twig(__DIR__ . '/../resources/views', [
            'cache' => false
        ]);

        $twig->addExtension(new TwigExtension(
            $c->get('router'),
            $c->get('request')->getURi()
        ));

        return $twig;
    },
    Product::class => function (ContainerInterface $c) {
        return new Product;
    }

];
