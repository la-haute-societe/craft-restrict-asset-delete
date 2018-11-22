<?php
/**
 * Restrict Asset Delete plugin for Craft CMS 3.x
 *
 * A plugin to prevent a used asset to be deleted.
 *
 * @link      https://www.lahautesociete.com
 * @copyright Copyright (c) 2018 Alban Jubert
 */

namespace lhs\restrictassetdelete\models;

use craft\base\Model;

/**
 * RestrictAssetDelete Settings Model
 *
 * This is a model used to define the plugin's settings.
 *
 * Models are containers for data. Just about every time information is passed
 * between services, controllers, and templates in Craft, it’s passed via a model.
 *
 * https://craftcms.com/docs/plugins/models
 *
 * @author    Alban Jubert
 * @package   RestrictAssetDelete
 * @since     1.1.0,1.0.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * If set to true, admin will be able to skip the restriction
     *
     * @var bool
     */
    public $adminCanSkipRestriction = false;

    // Public Methods
    // =========================================================================

    /**
     * Returns the validation rules for attributes.
     *
     * Validation rules are used by [[validate()]] to check if attribute values are valid.
     * Child classes may override this method to declare different validation rules.
     *
     * More info: http://www.yiiframework.com/doc-2.0/guide-input-validation.html
     *
     * @return array
     */
    public function rules()
    {
        return [
            ['adminCanSkipRestriction', 'boolean'],
            ['adminCanSkipRestriction', 'default', 'value' => false],
        ];
    }
}
