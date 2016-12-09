<?php
namespace bl\emailTemplates\providers;

use Yii;
use yii\base\Object;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * Database language provider
 *
 * @property string $arModel
 * @property integer $idField
 * @property string $nameField
 *
 * @link https://github.com/black-lamp/yii2-email-templates
 * @license GNU Public License
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @copyright Copyright (c) Vladimir Kuprienko
 */
class DbLanguageProvider extends Object implements LanguageProviderInterface
{
    /**
     * @var string Id of database component from application config
     */
    public $db = 'db';

    /**
     * @var string Name of table in database
     */
    public $tableName;

    /**
     * @var string Name of field with primary key
     */
    public $idField;

    /**
     * @var string Name of field with language name
     */
    public $nameField;

    /**
     * @var ActiveRecord[]
     */
    protected $_languages = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        $db = Yii::$app->get($this->db);

        /** @var ActiveRecord $entity */
        $languages = (new Query())
            ->select([$this->idField, $this->nameField])
            ->from($this->tableName)
            ->all($db);

        foreach ($languages as $language) {
            $this->_languages[$language[$this->idField]] = $language[$this->nameField];
        }
    }

    /**
     * @inheritdoc
     */
    public function getLanguages()
    {
        return $this->_languages;
    }

    /**
     * @inheritdoc
     */
    public function getDefault()
    {
        $languages = $this->_languages;
        return each($languages);
    }

    /**
     * @inheritdoc
     */
    public function getNameByID($id)
    {
        return ArrayHelper::getValue($this->_languages, $id);
    }
}