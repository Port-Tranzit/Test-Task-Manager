<?php

namespace App\Services\User;

use App\DTO\User\AuthResultDTO;
use App\Models\Token;
use App\Repositories\UserRepository;
use App\Services\BaseService;
use Yii;

class GetTokenService extends BaseService
{
    const METHOD_NAME = 'getToken';

    public ?string $login = null;
    public ?string $password = null;

    public function rules(): array
    {
        return [
            [['login', 'password'], 'required'],
        ];
    }

    public function getToken(): bool|AuthResultDTO
    {
        if ( !$this->validate() ) {
            return false;
        }

        $user = UserRepository::findUserByLogin($this->login);

        if ( empty($user) ) {
            $this->addError('login', 'Пользователь не найден');
            return false;
        }

        if ( !Yii::$app->security->validatePassword($this->password, $user->password_hash) ) {
            $this->addError('password', 'Неверный пароль');
            return false;
        }

        $token = new Token();
        $token->user_id = $user->id;
        $token->token = $this->generateNewToken();
        $token->expired_at = date(DATETIME_FORMAT, time() + DAY * 3);

        if ( !$token->save() ) {
            $this->addErrors($token->errors);
            return false;
        }

        return AuthResultDTO::makeFromData($user, $token);
    }

    private function generateNewToken(): string
    {
        $tokenBase = Yii::$app->security->generateRandomString();
        $timestamp = time();

        return "{$tokenBase}@{$timestamp}";
    }
}
