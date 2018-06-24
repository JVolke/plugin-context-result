<?php

namespace ContextResult\Services;

use IO\Helper\MemoryCache;
use IO\Services\UrlBuilder\CategoryUrlBuilder;
use IO\Services\UrlBuilder\UrlQuery;
use ContextResult\Services\UrlBuilder\VariationUrlBuilder;
use Plenty\Plugin\Http\Request;

class MyUrlService
{
    use MemoryCache;

    /**
     * Get canonical url for a category
     * @param int           $categoryId
     * @param string|null   $lang
     * @return UrlQuery
     */
    public function getCategoryURL( $categoryId, $lang = null )
    {
        if ( $lang === null )
        {
            $lang = pluginApp( SessionStorageService::class )->getLang();
        }
        $categoryUrl = $this->fromMemoryCache(
            "categoryUrl.$categoryId.$lang",
            function() use ($categoryId, $lang) {
                /** @var CategoryUrlBuilder $categoryUrlBuilder */
                $categoryUrlBuilder = pluginApp( CategoryUrlBuilder::class );
                return $categoryUrlBuilder->buildUrl( $categoryId, $lang );
            }
        );

        return $categoryUrl;
    }

    /**
     * Get canonical url for a variation
     * @param int           $itemId
     * @param int           $variationId
     * @param string|null   $lang
     * @return UrlQuery
     */
    public function getVariationURL( $itemId, $variationId, $lang = null )
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

    /**
     * Get canonical url for current page
     * @param string|null   $lang
     * @return string|null
     */
    public function getCanonicalURL( $lang = null )
    {
        if ( $lang === null )
        {
            $lang = pluginApp( SessionStorageService::class )->getLang();
        }

        $canonicalUrl = $this->fromMemoryCache(
            "canonicalUrl.$lang",
            function() use ($lang) {
                /** @var CategoryService $categoryService */
                $categoryService = pluginApp( CategoryService::class );
                if ( TemplateService::$currentTemplate === 'tpl.item' )
                {
                    $currentItem = $categoryService->getCurrentItem();
                    if ( count($currentItem) > 0 )
                    {
                        return $this
                            ->getVariationURL( $currentItem['item']['id'], $currentItem['variation']['id'], $lang )
                            ->toAbsoluteUrl( $lang !== null );
                    }

                    return null;
                }

                if ( substr(TemplateService::$currentTemplate,0, 12) === 'tpl.category' )
                {
                    $currentCategory = $categoryService->getCurrentCategory();

                    if ( $currentCategory !== null )
                    {
                        $categoryDetails = $categoryService->getDetails( $currentCategory, $lang );

                        if($categoryDetails !== null && strlen($categoryDetails->canonicalLink) > 0)
                        {
                            return $categoryDetails->canonicalLink;
                        }

                        return $this
                            ->getCategoryURL( $currentCategory->id, $lang )
                            ->toAbsoluteUrl( $lang !== null );
                    }
                    return null;
                }

                if ( TemplateService::$currentTemplate === 'tpl.home' )
                {
                    return pluginApp( UrlQuery::class, ['path' => "", 'lang' => $lang])
                        ->toAbsoluteUrl( $lang !== null );
                }

                return null;
            }
        );

        return $canonicalUrl;

    }

    public function isCanonical()
    {
        $requestUri = pluginApp(Request::class)->getRequestUri();
        $requestUrl = pluginApp( UrlQuery::class, ['path' => $requestUri])->toAbsoluteUrl(true);
        $canonical = $this->getCanonicalURL();

        return $requestUrl === $canonical;
    }

    /**
     * Get equivalent canonical urls for each active language
     * @return array
     */
    public function getLanguageURLs()
    {
        $languageUrls = $this->fromMemoryCache(
            "languageUrls",
            function() {
                $result = [];
                $defaultUrl = $this->getCanonicalURL();

                if ( $defaultUrl !== null )
                {
                    $result["x-default"] = $defaultUrl;
                }

                /** @var WebstoreConfigurationService $webstoreConfigService */
                $webstoreConfigService = pluginApp( WebstoreConfigurationService::class );
                foreach( $webstoreConfigService->getActiveLanguageList() as $language )
                {
                    $url = $this->getCanonicalURL( $language );
                    if ( $url !== null )
                    {
                        $result[$language] = $url;
                    }
                }

                return $result;
            }
        );

        return $languageUrls;
    }
}
