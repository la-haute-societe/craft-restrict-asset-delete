<?php
/**
 * Restrict Asset Delete plugin for Craft CMS 3.x
 *
 * A plugin to prevent a used asset to be deleted.
 *
 * @link      https://www.lahautesociete.com
 * @copyright Copyright (c) 2018 Alban Jubert
 */

namespace lhs\restrictassetdelete\services;

use craft\db\Query;
use lhs\restrictassetdelete\RestrictAssetDelete;
use craft\elements\Asset;

use Craft;
use craft\base\Component;

/**
 * RestrictAssetDeleteService Service
 *
 * All of your plugin’s business logic should go in services, including saving data,
 * retrieving data, etc. They provide APIs that your controllers, template variables,
 * and other plugins can interact with.
 *
 * https://craftcms.com/docs/plugins/services
 *
 * @author    Alban Jubert
 * @package   RestrictAssetDelete
 * @since     1.0.0
 */
class RestrictAssetDeleteService extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * Determines if an asset is in use or not.
     *
     * @param  AssetElement $asset
     * @return string
     */
    public function isUsed(Asset $asset)
    {
        return (new Query())
            ->select(['id'])
            ->from(['{{%relations}}'])
            ->where(['targetId' => $asset->id])
            ->orWhere(['sourceId' => $asset->id])
            ->exists();
    }
}
