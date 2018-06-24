<?php

namespace ContextResult\Services;

use IO\Helper\MemoryCache;
use IO\Services\UrlBuilder\CategoryUrlBuilder;
use IO\Services\UrlBuilder\UrlQuery;
use ContextResult\Services\UrlBuilder\VariationUrlBuilder;
use Plenty\Plugin\Http\Request;
use IO\Services\UrlService;

class MyUrlService extends UrlService
{
  parent::getVariationURL( $itemId, $variationId, $lang = null )
  {
      if ( $lang === null )
      {
          $lang = pluginApp( SessionStorageService::class )->getLang();
      }

      $variationUrl = $this->fromMemoryCache(
          "variationUrl.$itemId.$variationId.$lang",
          function() use ($itemId, $variationId, $lang) {
              /** @var VariationUrlBuilder $variationUrlBuilder */
              $variationUrlBuilder = pluginApp( VariationUrlBuilder::class );
              $variationUrl = $variationUrlBuilder->buildUrl( $itemId, $variationId, $lang );

              if ( $variationUrl->getPath() !== null )
              {
                  $variationUrl->append(
                      $variationUrlBuilder->getSuffix( $itemId, $variationId )
                  );
              }

              return $variationUrl;
          }
      );

      return $variationUrl;
  }

}
