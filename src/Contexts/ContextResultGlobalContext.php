<?php

namespace ContextResult\Contexts;

use IO\Helper\ContextInterface;
use Ceres\Contexts\GlobalContext;

class GlobalContextGlobalContext extends GlobalContext implements ContextInterface
{
  public function init($params)
  {
    parent::init($params);
  }
}
