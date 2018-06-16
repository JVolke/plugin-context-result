<?php

namespace ContextResult\Contexts;

use IO\Helper\ContextInterface;
use Ceres\Contexts\CategoryItemContext;

class ContextResultCategoryItemContext extends CategoryItemContext implements ContextInterface
{
  public function init($params)
  {
    parent::init($params);
  }
}
