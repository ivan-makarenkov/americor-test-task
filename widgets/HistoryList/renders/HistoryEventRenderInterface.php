<?php

namespace app\widgets\HistoryList\renders;

use app\models\History;
use yii\web\View;

interface HistoryEventRenderInterface
{
    public function __construct(History $model, View $view);
    public function render(): string;
    public function getBody(): string;
}