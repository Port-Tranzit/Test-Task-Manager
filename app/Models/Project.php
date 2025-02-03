<?php

namespace App\Models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $user_created_id
 * @property string $title
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @property string|null $deleted_at
 *
 * @property-read User $userCreated
 */
class Project extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'projects';
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

    public function rules(): array
    {
        return [
            [['user_created_id', 'title'], 'required'],
            [['description', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            ['user_created_id', 'exist', 'targetRelation' => 'userCreated'],
        ];
    }

    public function getUserCreated(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_created_id']);
    }
}
