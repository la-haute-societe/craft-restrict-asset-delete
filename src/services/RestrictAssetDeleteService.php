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

use craft\base\Component;
use craft\db\Query;
use craft\elements\Asset;
use lhs\restrictassetdelete\RestrictAssetDelete;

/**
 * RestrictAssetDeleteService Service
 *
 * @author Alban Jubert
 * @since  1.0.0
 */
class RestrictAssetDeleteService extends Component
{
    /**
     * Determines if an asset is used or not.
     *
     * @param Asset $asset
     * @return string
     */
    public function isUsed(Asset $asset)
    {
        $query = (new Query())
            ->select(['relations.id'])
            ->from(['{{%relations}}'])
            ->leftJoin('{{%elements}}', 'elements.id = relations.sourceId')
            ->where(['targetId' => $asset->id])
            ->orWhere(['sourceId' => $asset->id]);

        if (RestrictAssetDelete::getInstance()->getSettings()->ignoreRevisions) {
            $query->andWhere([
                'elements.revisionId' => null,
                'elements.dateDeleted' => null,
            ]);
        }

        return $query->exists();
    }
}
