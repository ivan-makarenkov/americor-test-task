<?php

namespace app\models;

use app\models\event\HistoryEventInterface;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%call}}".
 *
 * @property integer $customer_id
 * @property integer $status
 * @property string $comment
 *
 * -- magic properties
 * @property string $statusText
 * @property string $directionText
 * @property string $totalStatusText
 * @property string $totalDisposition
 * @property string $durationText
 * @property string $fullDirectionText
 * @property string $client_phone
 *
 * @property Customer $customer
 */
class Call extends Contact
{
    const STATUS_NO_ANSWERED = 0;
    const STATUS_ANSWERED = 1;

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%call}}';
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return array_merge(self::rules(), [
            [['type', 'viewed'], 'required'],
            [['customer_id', 'type', 'status'], 'integer'],
            [['outcome'], 'string', 'max' => 255],
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
     * @param bool $hasComment
     * @return string
     */
    public function getTotalDisposition(bool $hasComment = true): string
    {
        $t = [];
        if ($hasComment && $this->comment) {
            $t[] = $this->comment;
        }
        return implode(': ', $t);
    }


    public function getEventList(): array
    {
        return self::translateArrayValues([
            'outgoing' =>'Outgoing call',
            'incoming' =>'Incoming call'
        ]);
    }
}
