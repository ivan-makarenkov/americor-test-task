<?php

namespace app\models;

use app\models\event\HistoryEventInterface;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%sms}}".
 *
 * @property integer $status
 * @property integer $type
 * @property integer $customer_id
 * @property string $message
 * @property string $formatted_message
 *
 * @property string $statusText
 * @property string $directionText
 *
 * @property Customer $customer
 */
class Sms extends Contact implements HistoryEventInterface
{
    // incoming
    const STATUS_NEW = 0;
    const STATUS_READ = 1;
    const STATUS_ANSWERED = 2;

    // outgoing
    const STATUS_DRAFT = 10;
    const STATUS_WAIT = 11;
    const STATUS_SENT = 12;
    const STATUS_DELIVERED = 13;
    const STATUS_FAILED = 14;
    const STATUS_SUCCESS = 13;


    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%sms}}';
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return array_merge(self::rules(), [
            [['customer_id', 'applicant_id', 'type'], 'integer'],
            [['message'], 'string'],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::class, 'targetAttribute' => ['customer_id' => 'id']],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        $attributes = self::attributeLabels();
        $attributes['customer_id'] = 'Customer ID';
        $attributes['message'] = 'Message';
        $attributes['customer.name'] = 'Client';

        return self::translateArrayValues($attributes);
    }

    /**
     * @return ActiveQuery
     */
    public function getCustomer(): ActiveQuery
    {
        return $this->hasOne(Customer::class, ['id' => 'customer_id']);
    }

    /**
     * @return array
     */
    public static function getStatusTexts(): array
    {
        return self::translateArrayValues([
            self::STATUS_NEW => 'New',
            self::STATUS_READ => 'Read',
            self::STATUS_ANSWERED => 'Answered',

            self::STATUS_DRAFT => 'Draft',
            self::STATUS_WAIT => 'Wait',
            self::STATUS_SENT => 'Sent',
            self::STATUS_DELIVERED => 'Delivered',
        ]);
    }

    public function getEventList(): array
    {
        return self::translateArrayValues([
            'outgoing' =>'Outgoing message',
            'incoming' =>'Incoming message'
        ]);
    }
}
