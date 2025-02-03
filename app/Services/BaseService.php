<?php

namespace App\Services;

use App\Interfaces\IUserProvider;
use Brezgalov\ApiHelpers\v2\IRegisterInput;
use yii\base\Model;
use Yii;

abstract class BaseService extends Model implements IRegisterInput
{
    public function registerInput(array $data = []): void
    {
        $this->load($data, '');
    }

    protected function getCurrentUserId(): ?int
    {
        $service = Yii::createObject(IUserProvider::class);

        $user = $service->getLoggedInUser();
        return $user?->id;
    }
}
