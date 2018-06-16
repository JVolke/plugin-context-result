<?php

namespace ContextResult\Contexts;

use IO\Helper\ContextInterface;
use Ceres\Contexts\OrderReturnContext;

class ContextResultOrderReturnContext extends OrderReturnContext implements ContextInterface
{
  public function init($params)
  {
    parent::init($params);
  }
}
