<?php

namespace App\Models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $project_id
 * @property int $user_id
 *
 * @property Project $project
 * @property User $user
 */
class ProjectUser extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'projects_users';
    }

    public function rules(): array
    {
        return [
            [['project_id', 'user_id'], 'required'],
            ['project_id', 'exist', 'targetRelation' => 'project'],
            ['user_id', 'exist', 'targetRelation' => 'user'],
        ];
    }

    public function getProject(): ActiveQuery
    {
        return $this->hasOne(Project::class, ['id' => 'project_id']);
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
