<?php

namespace App\Services\ProjectUser;

use App\Models\ProjectUser;
use App\Repositories\ProjectRepository;
use App\Repositories\UserRepository;
use App\Services\BaseService;

class RemoveUserService extends BaseService
{
    const METHOD_NAME = 'removeUser';

    public ?int $project_id = null;
    public ?int $user_id = null;

    public function rules(): array
    {
        return [
            [['project_id', 'user_id'], 'required'],
        ];
    }

    public function removeUser(): bool
    {
        if ( !$this->validate() ) {
            return false;
        }

        $project = ProjectRepository::findProjectById($this->project_id);

        if ( empty($project) ) {
            $this->addError('project_id', 'Проект не найден');
            return false;
        }

        if ( $this->getCurrentUserId() !== $project->user_created_id ) {
            $this->addError('project_id', 'Только создатель проекта может исключать участников');
            return false;
        }

        $user = UserRepository::findUserById($this->user_id);

        if ( empty($user) ) {
            $this->addError('user_id', 'Пользователь не найден');
            return false;
        }

        $link = ProjectUser::find()
            ->where([
                'project_id' => $project->id,
                'user_id' => $user->id,
            ])
            ->one();

        if ( empty($link) ) {
            $this->addError('user_id', 'Пользователь не добавлен в проект');
            return false;
        }

        if ( !$link->delete() ) {
            $this->addErrors($link->errors);
            return false;
        }

        return true;
    }
}
