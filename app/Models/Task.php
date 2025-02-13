<?php

namespace App\Models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $project_id
 * @property int $user_created_id
 * @property int|null $user_assigned_id
 * @property int $priority_id
 * @property string $status
 * @property string $title
 * @property string|null $description
 * @property string|null $due_until
 * @property string $created_at
 * @property string $updated_at
 * @property string|null $deleted_at
 *
 * @property-read Project $project
 * @property-read User $userCreated
 * @property-read ?User $userAssigned
 */
class Task extends ActiveRecord
{
    const STATUS_PENDING = 'pending';
    const STATUS_IN_WORK = 'in_work';
    const STATUS_DONE = 'done';

    public static array $availableStatuses = [
        self::STATUS_PENDING,
        self::STATUS_IN_WORK,
        self::STATUS_DONE,
    ];

    public static function tableName(): string
    {
        return 'tasks';
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
            [['project_id', 'user_created_id', 'status', 'priority_id', 'title'], 'required'],
            [['user_assigned_id', 'description', 'due_until', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
        ];
    }

    public function getProject(): ActiveQuery
    {
        return $this->hasOne(Project::class, ['id' => 'project_id']);
    }

    public function getUserCreated(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_created_id']);
    }

    public function getUserAssigned(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_assigned_id']);
    }
}
