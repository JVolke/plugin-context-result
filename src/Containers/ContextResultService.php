<?php
namespace ContextResult\Containers;

use Plenty\Plugin\Templates\Twig;

class Service
{
    public function call(Twig $twig):string
    {
        return $twig->render('ContextResult::Containers.Service');
    }
}
