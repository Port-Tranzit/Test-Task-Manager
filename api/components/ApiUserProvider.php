<?php

namespace api\components;

use App\Interfaces\IUserProvider;
use App\Models\User;
use Yii;

class ApiUserProvider implements IUserProvider
{
    public function getLoggedInUser(): ?User
    {
        return Yii::$app->user->identity;
    }
}
