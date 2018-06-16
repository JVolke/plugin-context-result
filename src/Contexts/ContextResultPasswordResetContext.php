<?php

namespace ContextResult\Contexts;

use IO\Helper\ContextInterface;
use Ceres\Contexts\PasswordResetContext;

class ContextInterfacePasswordResetContext extends PasswordResetContext implements ContextInterface
{
  public function init($params)
  {
    parent::init($params);
  }
}
