<?php

namespace ContextResult\Providers;

use Plenty\Plugin\ServiceProvider;
use Plenty\Plugin\Events\Dispatcher;
use IO\Helper\TemplateContainer;
use IO\Helper\ComponentContainer;
use Plenty\Plugin\ConfigRepository;
use IO\Services\ItemSearch\Helper\ResultFieldTemplate;

/**
 * Include Contexts
*/
use ContextResult\Contexts\ContextResultSingleItemContext;

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

    public function boot(Dispatcher $dispatcher, ConfigRepository $config)
    {
          $enabledOverrides = explode(", ", $config->get("ContextResult.fields.override"));
          if (in_array("single_item", $enabledOverrides) || in_array("all", $enabledOverrides))
          {
            $dispatcher->listen( 'IO.ResultFields.*', function(ResultFieldTemplate $templateContainer) {
               $templateContainer->setTemplates([
                   ResultFieldTemplate::TEMPLATE_SINGLE_ITEM   => 'ContextResult::ResultFields.SingleItem'
               ]);
            }, 0);
          }

          if (in_array("list_item", $enabledOverrides) || in_array("all", $enabledOverrides))
          {
           $dispatcher->listen( 'IO.ResultFields.*', function(ResultFieldTemplate $templateContainer) {
                 $templateContainer->setTemplates([
                     ResultFieldTemplate::TEMPLATE_LIST_ITEM   => 'ContextResult::ResultFields.ListItem'
                 ]);
           }, 0);
         }

         if (in_array("basket_item", $enabledOverrides) || in_array("all", $enabledOverrides))
         {
           $dispatcher->listen( 'IO.ResultFields.*', function(ResultFieldTemplate $templateContainer) {
                   $templateContainer->setTemplates([
                       ResultFieldTemplate::TEMPLATE_BASKET_ITEM    => 'ContextResult::ResultFields.BasketItem'
                   ]);
           }, 0);
         }

         $dispatcher->listen('IO.ctx.item', function (TemplateContainer $templateContainer, $templateData = [])
          {
              $templateContainer->setContext( ContextResultSingleItemContext::class);
              return false;
          }, 0);

    }

}
