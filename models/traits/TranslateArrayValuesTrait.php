<?php

namespace app\models\traits;

trait TranslateArrayValuesTrait
{
    public static function translateArrayValues(array $attributes): array
    {
        return array_map(function(string $value): string {
            return Yii::t('app', $value);
        } , $attributes);
    }
}