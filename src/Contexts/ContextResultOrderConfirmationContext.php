<?php

namespace ContextResult\Contexts;

use IO\Helper\ContextInterface;
use Ceres\Contexts\OrderConfirmationContext;

class ContextResultOrderConfirmationContext extends OrderConfirmationContext implements ContextInterface
{
  public function init($params)
  {
    parent::init($params);
  }
}
