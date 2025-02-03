<?php

namespace App\Repositories;

use App\Models\User;

final class UserRepository
{
    public static function findUserByLogin(string $login): ?User
    {
        return User::findOne(['login' => $login]);
    }

    public static function findUserById(int $id): ?User
    {
        return User::findOne($id);
    }
}
