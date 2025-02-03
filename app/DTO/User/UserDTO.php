<?php

namespace App\DTO\User;

use App\Models\User;
use yii\base\Model;

class UserDTO extends Model
{
    public int $id;
    public string $login;
    public string $createdAt;
    public string $updatedAt;

    public static function makeFromUser(User $user): self
    {
        $instance = new self();
        $instance->id = $user->id;
        $instance->login = $user->login;
        $instance->createdAt = $user->created_at;
        $instance->updatedAt = $user->updated_at;

        return $instance;
    }

    public function fields(): array
    {
        return [
            'id',
            'login',
            'created_at' => 'createdAt',
            'updated_at' => 'updatedAt',
        ];
    }
}
