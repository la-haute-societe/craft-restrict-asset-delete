<?php
/**
 * Restrict Asset Delete plugin for Craft CMS 3.x
 *
 * A plugin to prevent a used asset to be deleted.
 *
 * @link      https://www.lahautesociete.com
 * @copyright Copyright (c) 2018 Alban Jubert
 */

namespace lhs\restrictassetdelete\assetbundles\cp;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * RestrictAssetDeleteAsset AssetBundle
 *
 * AssetBundle represents a collection of asset files, such as CSS, JS, images.
 *
 * Each asset bundle has a unique name that globally identifies it among all asset bundles used in an application.
 * The name is the [fully qualified class name](http://php.net/manual/en/language.namespaces.rules.php)
 * of the class representing it.
 *
 * An asset bundle can depend on other asset bundles. When registering an asset bundle
 * with a view, all its dependent asset bundles will be automatically registered.
 *
 * http://www.yiiframework.com/doc-2.0/guide-structure-assets.html
 *
 * @author    Alban Jubert
 * @package   RestrictAssetDelete
 * @since     1.0.0
 */
class RestrictAssetDeleteAsset extends AssetBundle
{
    /**
     * Initializes the bundle.
     */
    public function init(): void
    {
        // define the path that your publishable resources live
        $this->sourcePath = "@lhs/restrictassetdelete/assetbundles/cp/dist";

        // define the dependencies
        $this->depends = [
            CpAsset::class,
        ];

        // define the relative path to CSS/JS files that should be registered with the page
        // when this asset bundle is registered
        $this->js = [
            'js/RestrictAssetDelete.js',
        ];

        $this->css = [
            'css/RestrictAssetDelete.css',
        ];

        parent::init();
    }
}
