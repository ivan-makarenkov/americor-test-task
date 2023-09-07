<?php

namespace app\models;

use app\models\event\HistoryEventInterface;
use app\models\traits\TranslateArrayValuesTrait;
use yii\db\ActiveRecord;

/** This is the abstract model with common parts of contact like Sms, Call, Fax.
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $ins_ts
 * @property string $from
 * @property string $to
 * @property integer $status
 * @property integer $direction
 *
 * @property User $user
 */
abstract class Contact extends ActiveRecord implements HistoryEventInterface
{
    use TranslateArrayValuesTrait;

    const DIRECTION_INCOMING = 0;
    const DIRECTION_OUTGOING = 1;

    public function rules(): array
    {
        return [
            [['to', 'direction', 'status'], 'required'],
            [['user_id', 'status', 'direction'], 'integer'],
            [['ins_ts'], 'safe'],
            [['from', 'to'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'ins_ts' => 'Date',
            'user_id' => 'User ID',
            'from' => 'From',
            'to' => 'To',
            'direction' => 'Direction',
            'directionText' => 'Direction',
            'status' => 'Status',
            'statusText' => 'Status',
            'user.fullname' => 'User'
        ];
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}