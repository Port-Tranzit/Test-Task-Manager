<?php

namespace App\DTO\Priority;

use App\Models\Priority;
use yii\base\Model;

class PriorityDTO extends Model
{
    public int $id;
    public string $name;

    public static function makeFromPriority(Priority $priorities): self
    {
        $instance = new self();
        $instance->id = $priorities->id;
        $instance->name = $priorities->name;

        return $instance;
    }

    public function fields(): array
    {
        return [
            'id',
            'name',
        ];
    }
}
