<?php

namespace ContextResult\Contexts;

use IO\Helper\ContextInterface;
use Ceres\Contexts\SingleItemContext;
use Plenty\Modules\Item\Item\Contracts\ItemRepositoryContract;
use IO\Services\ItemSearch\Services\ItemSearchService;
use IO\Services\ItemSearch\SearchPresets\CrossSellingItems;
use Plenty\Modules\Item\Variation\Contracts\VariationRepositoryContract;
use Plenty\Modules\Item\VariationProperty\Contracts\VariationPropertyValueRepositoryContract;
use Plenty\Plugin\Log\Loggable;

class ContextResultSingleItemContext extends SingleItemContext implements ContextInterface
{
  use Loggable;
  public $freeField;
  public $crossSelling;

  public function init($params)
  {
    parent::init($params);
    $this->freeField = pluginApp(ItemRepositoryContract::class)->show($this->item['documents'][0]['data']['item']['id']);
    $options = [
      "itemId"   => $this->item['documents'][0]['data']['item']['id'],
      "relation" => "Accessory"
    ];
    $searchfactory = CrossSellingItems::getSearchFactory( $options );
    $searchfactory->setPage(1,4);
    $result = pluginApp(ItemSearchService::class)->getResult( $searchfactory );
    $this->getLogger(__METHOD__)->error("Debug Cross Selling", $result);
    $with = [ "variationProperties" ];
    $lang = "de";
    $mainVariationProperties = pluginApp(VariationPropertyValueRepositoryContract::class)->findByVariationId($this->item['documents'][0]['data']['variation']['id']);
    $this->getLogger(__METHOD__)->error("Debuggin", $mainVariationProperties);

  }
}
