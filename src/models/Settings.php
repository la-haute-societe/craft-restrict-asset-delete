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
 * @author    Alban Jubert
 * @since     1.1.0,1.0.0
 */
class Settings extends Model
{
    /**
     * If set to true, admin will be able to skip the restriction
     *
     * @var bool
     */
    public bool $adminCanSkipRestriction = false;

    /**
     * Ignore revisions when restricting deletions
     *
     * @var bool
     */
    public bool $ignoreRevisions = false;

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
    public function rules(): array
    {
        return [
            [['adminCanSkipRestriction', 'ignoreRevisions'], 'boolean'],
            ['adminCanSkipRestriction', 'default', 'value' => false],
        ];
    }
}
