<?php

namespace ContextResult\Contexts;

use IO\Helper\ContextInterface;
use Ceres\Contexts\ItemWishListContext;

class ContextResultItemWishListContext extends ItemWishListContext implements ContextInterface
{
  public function init($params)
  {
    parent::init($params);
  }
}
