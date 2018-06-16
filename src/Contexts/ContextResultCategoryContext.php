<?php

namespace ContextResult\Contexts;

use IO\Helper\ContextInterface;
use Ceres\Contexts\CategoryContext;

class ContextResultCategoryContext extends CategoryContext implements ContextInterface
{
  public function init($params)
  {
    parent::init($params);
  }
}
