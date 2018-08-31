<?php

namespace ContextResult\Contexts;

use IO\Helper\ContextInterface;
use Ceres\Contexts\SingleItemContext;
use Plenty\Modules\Item\Item\Contracts\ItemRepositoryContract;
use IO\Services\ItemSearch\Services\ItemSearchService;
use IO\Services\ItemSearch\SearchPresets\CrossSellingItems;
use Plenty\Modules\Item\Variation\Contracts\VariationRepositoryContract;
use Plenty\Plugin\Log\Loggable;

class ContextResultSingleItemContext extends SingleItemContext implements ContextInterface
{
  use Loggable;
  public $freeField;
  public $crossSelling;
  public $crossSellingSimilar;

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
    $this->crossSelling = $result['documents'];
    $options2 = [
      "itemId"   => $this->item['documents'][0]['data']['item']['id'],
      "relation" => "Similar"
    ];
    $searchfactory2 = CrossSellingItems::getSearchFactory( $options2 );
    $searchfactory2->setPage(1,4);
    $result2 = pluginApp(ItemSearchService::class)->getResult( $searchfactory2 );
    $this->crossSellingSimilar = $result2['documents'];
    $this->getLogger(__METHOD__)->error("Debug Cross Selling Similar", $result2['documents']);
    $with = [ 'properties' => 1 ];
    $lang = "de";
    $mainVariationProperties = pluginApp(VariationRepositoryContract::class)->show($this->item['documents'][0]['data']['variation']['id'], $with, $lang);

  }
}
