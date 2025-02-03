<?php

namespace api\formatters;

use App\DTO\Project\ProjectDTO;
use App\Models\Project;
use Brezgalov\ApiHelpers\v2\Formatters\ModelResultFormatter;
use yii\data\ActiveDataProvider;

class ProjectFormatter extends ModelResultFormatter
{
    public function format($service, $result)
    {
        if ( !$result instanceof ActiveDataProvider ) {
            return parent::format($service, $result);
        }

        $items = [];
        foreach ($result->getModels() as $model) {
            if ( !$model instanceof Project ) {
                continue;
            }

            $items[] = ProjectDTO::makeFromProject($model);
        }

        return $items;
    }
}
