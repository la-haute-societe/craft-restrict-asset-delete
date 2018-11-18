<?php
/**
 * Restrict Asset Delete plugin for Craft CMS 3.x
 *
 * A plugin to prevent a used asset to be deleted.
 *
 * @link      https://www.lahautesociete.com
 * @copyright Copyright (c) 2018 Alban Jubert
 */

/**
 * Restrict Asset Delete en Translation
 *
 * Returns an array with the string to be translated (as passed to `Craft::t('restrict-asset-delete', '...')`) as
 * the key, and the translation as the value.
 *
 * http://www.yiiframework.com/doc-2.0/guide-tutorial-i18n.html
 *
 * @author    Alban Jubert
 * @package   RestrictAssetDelete
 * @since     1.0.0
 */
return [
    'Restrict Asset Delete plugin loaded'                 => 'Plugin Restrict Asset Delete chargé',
    'Some assets were not deleted because they are used.' => 'Certaines ressources n\'ont pas été supprimées car elles sont utilisées.',
    'Skip restriction'                                    => 'Ignorer la restriction'
];
