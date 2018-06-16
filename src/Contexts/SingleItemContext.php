<?php

namespace ContextResult\Contexts;

use IO\Helper\ContextInterface;
use Ceres\Contexts\SingleItemContext;
use Plenty\Modules\Item\Item\Contracts\ItemRepositoryContract;

class ContextResultSingleItemContext extends SingleItemContext implements ContextInterface
{
  public $freeField;

  public function init($params)
  {
    parent::init($params);
    $this->freeField = pluginApp(ItemRepositoryContract::class)->show($this->item['documents'][0]['data']['item']['id']);
  }
}
