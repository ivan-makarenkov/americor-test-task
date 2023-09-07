<?php

namespace app\models;

use app\models\event\HistoryEventInterface;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "fax".
 *
 * @property integer $status
 * @property integer $type
 * @property string $typeText
 */
class Fax extends Contact
{
    const TYPE_POA_ATC = 'poa_atc';
    const TYPE_REVOCATION_NOTICE = 'revocation_notice';

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%fax}}';
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return array_merge(self::rules(), [
            [['type'], 'required'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return self::translateArrayValues(self::attributeLabels());
    }

    /**
     * @return array
     */
    public static function getTypeTexts(): array
    {
        return self::translateArrayValues([
            self::TYPE_POA_ATC => 'POA/ATC',
            self::TYPE_REVOCATION_NOTICE => 'Revocation'
        ]);
    }

    public function getEventList(): array
    {
        return self::translateArrayValues([
            'outgoing' =>'Outgoing fax',
            'incoming' =>'Incoming fax'
        ]);
    }
}
