<?php
/**
 * @link https://craftcms.com/
 * @copyright Copyright (c) Pixel & Tonic, Inc.
 * @license https://craftcms.github.io/license/
 */

namespace lhs\restrictassetdelete\actions;

use Craft;
use craft\base\ElementAction;
use craft\elements\Asset;
use craft\elements\db\ElementQueryInterface;
use lhs\restrictassetdelete\RestrictAssetDelete;
use yii\base\Exception;

/**
 * DeleteAssets represents a Delete Assets element action.
 *
 * @author Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @since 3.0
 */
class DeleteAssets extends ElementAction
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function getTriggerLabel(): string
    {
        return Craft::t('app', 'Delete');
    }

    /**
     * @inheritdoc
     */
    public static function isDestructive(): bool
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function getConfirmationMessage()
    {
        return Craft::t('app', 'Are you sure you want to delete the selected assets?');
    }

    /**
     * Performs the action on any elements that match the given criteria.
     *
     * @param ElementQueryInterface $query The element query defining which elements the action should affect.
     * @return bool Whether the action was performed successfully.
     * @throws \Throwable
     */
    public function performAction(ElementQueryInterface $query): bool
    {
        $blockedAssets = [];
        try {
            foreach ($query->all() as $asset) {
                /**
                 * @var Asset $asset
                 */
                if (Craft::$app->getUser()->checkPermission('deleteFilesAndFoldersInVolume:' . $asset->volumeId)) {
                    if (!RestrictAssetDelete::getInstance()->service->isUsed($asset)) {
                        Craft::$app->getElements()->deleteElement($asset);
                    } else {
                        $blockedAssets[] = $asset;
                    }
                }
            }
        } catch (Exception $exception) {
            $this->setMessage($exception->getMessage());

            return false;
        }

        if (count($blockedAssets)) {
            $this->setMessage(Craft::t('app', 'Some assets were not deleted because they are used.'));
        } else {
            $this->setMessage(Craft::t('app', 'Assets deleted.'));
        }

        return true;
    }
}
