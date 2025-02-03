<?php

namespace App\Models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property string $token
 * @property int $user_id
 * @property string $expired_at
 * @property string $created_at
 * @property string $updated_at
 *
 * @property-read User $user
 */
class Token extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'tokens';
    }

    public function rules(): array
    {
        return [
            [['token', 'user_id', 'expired_at'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            ['user_id', 'exist', 'targetRelation' => 'user'],
        ];
    }

    public function behaviors(): array
    {
        return [
            'timestamps' => [
                'class' => TimestampBehavior::class,
                'value' => function () {
                    return date('Y-m-d H:i:s');
                },
            ],
        ];
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
