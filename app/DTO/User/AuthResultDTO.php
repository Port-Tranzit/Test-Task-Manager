<?php

namespace App\DTO\User;

use App\Models\Token;
use App\Models\User;
use yii\base\Model;

class AuthResultDTO extends Model
{
    public int $userId;
    public string $userLogin;
    public string $token;
    public string $validUntil;

    public static function makeFromData(User $user, Token $token): self
    {
        $instance = new self();
        $instance->userId = $user->id;
        $instance->userLogin = $user->login;
        $instance->token = $token->token;
        $instance->validUntil = $token->expired_at;

        return $instance;
    }

    public function fields(): array
    {
        return [
            'user_id' => 'userId',
            'login' => 'userLogin',
            'token',
            'valid_until' => 'validUntil',
        ];
    }
}
