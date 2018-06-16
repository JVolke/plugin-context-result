<?php

namespace ContextResult\Contexts;

use IO\Helper\ContextInterface;
use Ceres\Contexts\GlobalContext;

class ContextResultGlobalContext extends GlobalContext implements ContextInterface
{
  public function init($params)
  {
    parent::init($params);
  }
}
