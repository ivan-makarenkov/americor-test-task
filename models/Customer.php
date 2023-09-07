<?php

namespace app\models;


use app\models\event\HistoryEventInterface;
use app\models\traits\TranslateArrayValuesTrait;
use Yii;
use yii\db\ActiveRecord;


/**
 * This is the model class for table "{{%customer}}".
 *
 * @property integer $id
 * @property string $name
 */
class Customer extends ActiveRecord implements HistoryEventInterface
{
    use TranslateArrayValuesTrait;

    const QUALITY_ACTIVE = 'active';
    const QUALITY_REJECTED = 'rejected';
    const QUALITY_COMMUNITY = 'community';
    const QUALITY_UNASSIGNED = 'unassigned';
    const QUALITY_TRICKLE = 'trickle';

    const TYPE_LEAD = 'lead';
    const TYPE_DEAL = 'deal';
    const TYPE_LOAN = 'loan';

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%customer}}';
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return self::translateArrayValues([
            'name' => 'Name',
        ]);
    }

    /**
     * @return array
     */
    public static function getQualityTexts(): array
    {
        return self::translateArrayValues([
            self::QUALITY_ACTIVE =>'Active',
            self::QUALITY_REJECTED =>'Rejected',
            self::QUALITY_COMMUNITY =>'Community',
            self::QUALITY_UNASSIGNED =>'Unassigned',
            self::QUALITY_TRICKLE =>'Trickle',
        ]);
    }

    /**
     * @param $quality
     * @return mixed|null
     */
    public static function getQualityText($quality)
    {
        return self::getQualityTexts()[$quality] ?? $quality;
    }

    /**
     * @return array
     */
    public static function getTypeTexts(): array
    {
        return self::translateArrayValues([
            self::TYPE_LEAD =>'Lead',
            self::TYPE_DEAL =>'Deal',
            self::TYPE_LOAN =>'Loan',
        ]);
    }

    /**
     * @param $type
     * @return mixed
     */
    public static function getTypeText($type)
    {
        return self::getTypeTexts()[$type] ?? $type;
    }

    public function getEventList(): array
    {
        return self::translateArrayValues([
            'type_changed' =>'Type changed',
            'quantity_changed' =>'Property changed',
        ]);
    }
}