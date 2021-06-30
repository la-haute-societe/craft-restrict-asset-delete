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
use craft\base\Plugin;
use craft\elements\Asset;
use craft\events\ModelEvent;
use craft\events\RegisterElementActionsEvent;
use craft\events\RegisterUserPermissionsEvent;
use craft\services\UserPermissions;
use lhs\restrictassetdelete\models\Settings;
use lhs\restrictassetdelete\services\RestrictAssetDeleteService;
use yii\base\Event;

/**
 * Craft plugins are very much like little applications in and of themselves. We’ve made
 * it as simple as we can, but the training wheels are off. A little prior knowledge is
 * going to be required to write a plugin.
 *
 * For the purposes of the plugin docs, we’re going to assume that you know PHP and SQL,
 * as well as some semi-advanced concepts like object-oriented programming and PHP namespaces.
 *
 * https://craftcms.com/docs/plugins/introduction
 *
 * @author    Alban Jubert
 * @package   RestrictAssetDelete
 * @since     1.0.0
 *
 * @property  RestrictAssetDeleteService $restrictAssetDeleteService
 * @property  Settings $settings
 * @method    Settings getSettings()
 */
class RestrictAssetDelete extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * Static property that is an instance of this plugin class so that it can be accessed via
     * RestrictAssetDelete::$plugin
     *
     * @var RestrictAssetDelete
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * To execute your plugin’s migrations, you’ll need to increase its schema version.
     *
     * @var string
     */
    public $schemaVersion = '1.1.0';

    // Public Methods
    // =========================================================================

    /**
     * Set our $plugin static property to this class so that it can be accessed via
     * RestrictAssetDelete::$plugin
     *
     * Called after the plugin class is instantiated; do any one-time initialization
     * here such as hooks and events.
     *
     * If you have a '/vendor/autoload.php' file, it will be loaded for you automatically;
     * you do not need to load it in your init() method.
     *
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

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
                        if (is_string($action)
                            && $action === 'craft\elements\actions\DeleteAssets'
                            && !$this->canSkipRestriction()
                        ) {
                            $event->actions[$i] = 'lhs\restrictassetdelete\actions\DeleteAssets';
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
     * @return \craft\base\Model|null
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
     * @throws \Twig_Error_Loader
     * @throws \yii\base\Exception
     */
    protected function settingsHtml(): string
    {
        return Craft::$app->view->renderTemplate(
            'restrict-asset-delete/settings',
            [
                'settings' => $this->getSettings()
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
        return (Craft::$app->getUser()->getIsAdmin() && $this->getSettings()->adminCanSkipRestriction) || Craft::$app->user->can('restrict-asset-delete:skip-restriction');
    }
}
