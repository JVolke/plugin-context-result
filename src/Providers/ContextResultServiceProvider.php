<?php

namespace ContextResult\Providers;

use Plenty\Plugin\ServiceProvider;
use Plenty\Plugin\Events\Dispatcher;
use IO\Helper\TemplateContainer;
use IO\Helper\ComponentContainer;
use IO\Services\ItemSearch\Helper\ResultFieldTemplate;

/**
 * Include Contexts
*/
use ContextResult\Contexts\SingleItemContext;

/**
 * Class ContextResultServiceProvider
 * @package ContextResult\Providers
 */
class ContextResultServiceProvider extends ServiceProvider
{
    /**
    * Register the route service provider
    */
    public function register()
    {

    }

    public function boot(Dispatcher $dispatcher)
    {
          $dispatcher->listen( 'IO.ResultFields.*', function(ResultFieldTemplate $templateContainer) {
             $templateContainer->setTemplates([
                 ResultFieldTemplate::TEMPLATE_SINGLE_ITEM   => 'ContextResult::ResultFields.SingleItem'
             ]);
          }, 0);

         $dispatcher->listen( 'IO.ResultFields.*', function(ResultFieldTemplate $templateContainer) {
               $templateContainer->setTemplates([
                   ResultFieldTemplate::TEMPLATE_LIST_ITEM   => 'ContextResult::ResultFields.ListItem'
               ]);
         }, 0);

         $dispatcher->listen( 'IO.ResultFields.*', function(ResultFieldTemplate $templateContainer) {
                 $templateContainer->setTemplates([
                     ResultFieldTemplate::TEMPLATE_BASKET_ITEM    => 'ContextResult::ResultFields.BasketItem'
                 ]);
         }, 0);

         $dispatcher->listen('IO.ctx.item', function (TemplateContainer $templateContainer, $templateData = [])
          {
              $templateContainer->setContext( ContextResultSingleItemContext::class);
              return false;
          }, 0);

    }

}
