<?php

namespace App\Models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * @property int $id
 * @property string $login
 * @property string $password_hash
 * @property string $created_at
 * @property string $updated_at
 */
class User extends ActiveRecord implements IdentityInterface
{
    public static function tableName(): string
    {
        return 'users';
    }

    public function rules(): array
    {
        return [
            [['login', 'password_hash'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
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

    public static function findIdentity($id): ?User
    {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null): ?User
    {
        $token = Token::findOne([
            'and',
            ['token' => $token],
            ['>', 'expired_at', date('Y-m-d H:i:s')],
        ]);

        return $token?->user;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return null;
    }

    public function validateAuthKey($authKey): bool
    {
        return true;
    }
}
