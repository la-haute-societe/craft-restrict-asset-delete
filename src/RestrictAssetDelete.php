<?php
/**
 * Restrict Asset Delete plugin for Craft CMS 3.x
 *
 * A plugin to prevent a used asset to be deleted.
 *
 * @link      https://www.lahautesociete.com
 * @copyright Copyright (c) 2018 Alban Jubert
 */

namespace lhs\restrictassetdelete;

use Craft;
use craft\base\Model;
use craft\base\Plugin;
use craft\console\User;
use craft\elements\actions\DeleteAssets as CraftDeleteAssetsAction;
use craft\elements\Asset;
use craft\events\ModelEvent;
use craft\events\RegisterElementActionsEvent;
use craft\events\RegisterUserPermissionsEvent;
use craft\services\UserPermissions;
use lhs\restrictassetdelete\actions\DeleteAssets as DeleteAssetsAction;
use lhs\restrictassetdelete\models\Settings;
use lhs\restrictassetdelete\services\RestrictAssetDeleteService;
use yii\base\Event;

/**
 * @author    Alban Jubert
 * @since     1.0.0
 *
 * @property  RestrictAssetDeleteService $service
 * @property  RestrictAssetDeleteService $restrictAssetDeleteService
 * @property  Settings                   $settings
 * @method    Settings getSettings()
 */
class RestrictAssetDelete extends Plugin
{
    public $schemaVersion = '1.1.0';

    public function init()
    {
        parent::init();

        $this->setComponents([
            'service' => RestrictAssetDeleteService::class,
        ]);

        /**
         * Register plugin permissions
         */
        Event::on(
            UserPermissions::class,
            UserPermissions::EVENT_REGISTER_PERMISSIONS,
            function (RegisterUserPermissionsEvent $event) {
                $event->permissions['Restrict Asset Delete'] = $this->getPluginPermissions();
            }
        );

        Event::on(
            Asset::class,
            Asset::EVENT_BEFORE_DELETE,
            function (ModelEvent $event) {
                /** @var Asset $asset */
                $asset = $event->sender;
                if (!$this->canSkipRestriction()
                    && $this->service->isUsed($asset)
                ) {
                    $event->handled = true;
                    $event->isValid = false;
                }
            }
        );

        if (Craft::$app->getRequest()->getIsCpRequest()) {
            /**
             * Substitute Core DeleteAssets with plugin custom one
             */
            Event::on(
                Asset::class,
                Asset::EVENT_REGISTER_ACTIONS,
                function (RegisterElementActionsEvent $event) {
                    foreach ($event->actions as $i => $action) {
                        if ($action === CraftDeleteAssetsAction::class && !$this->canSkipRestriction()
                        ) {
                            $event->actions[$i] = DeleteAssetsAction::class;
                        }
                    }
                }
            );
        }

        Craft::info("$this->name plugin loaded", __METHOD__);
    }

    /**
     * Creates and returns the model used to store the plugin’s settings.
     *
     * @return Model|null
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }

    /**
     * Returns the rendered settings HTML, which will be inserted into the content
     * block on the settings page.
     *
     * @return string The rendered settings HTML
     */
    protected function settingsHtml(): string
    {
        return Craft::$app->view->renderTemplate(
            'restrict-asset-delete/settings',
            [
                'settings' => $this->getSettings(),
            ]
        );
    }

    /**
     * Return the plugin custom permissions
     * @return array
     */
    protected function getPluginPermissions(): array
    {
        $permissions = [
            'restrict-asset-delete:skip-restriction' => [
                'label' => Craft::t('restrict-asset-delete', 'Ignore the restriction'),
            ],
        ];
        return $permissions;
    }

    protected function canSkipRestriction()
    {
        $user = Craft::$app->user;

        if ($user->getIsAdmin()) {
            return $this->getSettings()->adminCanSkipRestriction;
        }

        return $user->checkPermission('restrict-asset-delete:skip-restriction');

    }
}
