<?php

namespace App\Models;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $name
 */
class Priority extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'priorities';
    }

    public function rules(): array
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }
}
