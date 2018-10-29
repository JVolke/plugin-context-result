<?php
namespace ContextResult\Containers;

use Plenty\Plugin\Templates\Twig;

class ContextResultService
{
    public function call(Twig $twig):string
    {
        return $twig->render('ContextResult::Content.Service');
    }
}
