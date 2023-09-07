<?php

namespace app\models;

use app\models\event\HistoryEventInterface;
use app\models\traits\TranslateArrayValuesTrait;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $statusText
 */
class User extends ActiveRecord implements HistoryEventInterface
{
    use TranslateArrayValuesTrait;

    const STATUS_DELETED = 0;
    const STATUS_HIDDEN = 1;
    const STATUS_ACTIVE = 10;

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'created_at', 'updated_at'], 'required'],
            [[
                'status',
                'created_at',
                'updated_at',
            ], 'integer'],
            [[
                'username',
                'email',
            ], 'string', 'max' => 255],

            [['username'], 'unique'],

            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED, self::STATUS_HIDDEN]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return self::translateArrayValues([
            'id' => 'ID',
            'username' => 'Username (login)',
            'statusText' => 'Status',
        ]);
    }

    /**
     * @return array
     */
    public static function getStatusTexts(): array
    {
        return self::translateArrayValues([
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_DELETED => 'Deleted',
            self::STATUS_HIDDEN => 'Hidden'
        ]);
    }

    /**
     * @return string
     */
    public function getStatusText()
    {
        return self::getStatusTexts()[$this->status] ?? $this->status;
    }

    public function getEventList(): array
    {
        return self::translateArrayValues([
            'change_status' => 'Change status'
        ]);
    }
}
