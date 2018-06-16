<?php

namespace ContextResult\Contexts;

use IO\Helper\ContextInterface;
use Ceres\Contexts\ItemSearchContext;

class ContextResultItemSearchContext extends ItemSearchContext implements ContextInterface
{
  public function init($params)
  {
    parent::init($params);
  }
}
