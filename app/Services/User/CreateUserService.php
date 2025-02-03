<?php

namespace App\Services\User;

use App\DTO\User\UserDTO;
use App\Repositories\UserRepository;
use App\Services\BaseService;
use App\Models\User;
use Yii;

class CreateUserService extends BaseService
{
    const METHOD_NAME = 'createUser';

    public ?string $login = null;
    public ?string $password = null;

    public function rules(): array
    {
        return [
            [['login', 'password'], 'required'],
        ];
    }

    public function createUser(): bool|UserDTO
    {
        if ( !$this->validate() ) {
            return false;
        }

        $existingUser = UserRepository::findUserByLogin($this->login);

        if ( !empty($existingUser) ) {
            $this->addError('login', 'Пользователь с таким логином уже существует');
            return false;
        }

        $user = new User();
        $user->login = $this->login;
        $user->password_hash = Yii::$app->security->generatePasswordHash($this->password);

        if ( !$user->save() ) {
            $this->addErrors($user->errors);
            return false;
        }

        return UserDTO::makeFromUser($user);
    }
}
