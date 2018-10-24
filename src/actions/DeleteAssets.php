<?php
/**
 * @link https://craftcms.com/
 * @copyright Copyright (c) Pixel & Tonic, Inc.
 * @license https://craftcms.github.io/license/
 */

namespace lhs\restrictassetdelete\actions;

use Craft;
use craft\elements\Asset;
use craft\elements\db\ElementQueryInterface;
use yii\base\Exception;

/**
 * DeleteAssets represents a Delete Assets element action.
 *
 * @author Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @since 3.0
 */
class DeleteAssets extends \craft\elements\actions\DeleteAssets
{
    // Public Methods
    // =========================================================================

    /**
     * Performs the action on any elements that match the given criteria.
     *
     * @param ElementQueryInterface $query The element query defining which elements the action should affect.
     * @return bool Whether the action was performed successfully.
     * @throws \Throwable
     */
    public function performAction(ElementQueryInterface $query): bool
    {
        $success = true;
        try {
            foreach ($query->all() as $asset) {
                /**
                 * @var Asset $asset
                 */
                if (Craft::$app->getUser()->checkPermission('deleteFilesAndFoldersInVolume:' . $asset->volumeId)) {
                    if (!Craft::$app->getElements()->deleteElement($asset)) {
                        $success = false;
                    }
                }
            }
        } catch (Exception $exception) {
            $this->setMessage($exception->getMessage());

            return false;
        }

        if (!$success) {
            $this->setMessage(Craft::t('restrict-asset-delete', 'Some assets were not deleted because they are used.'));
        }
        else {
            $this->setMessage(Craft::t('app', 'Assets deleted.'));
        }

        return true;
    }
}
