<?php

namespace app\widgets\HistoryList\renders;

use app\models\History;
use Yii;
use yii\web\View;

class BaseEventRenderer implements HistoryEventRenderInterface
{
    /**
     * @var History
     */
    public $model;

    /**
     * @var View
     */
    public $view;

    public function __construct(History $model, View $view)
    {
        $this->model = $model;
        $this->view = $view;
    }

    public function render(): string
    {
        return $this->view->render('_item_common', [
            'user' => $this->model->user,
            'body' => $this->getBody(),
            'bodyDatetime' => $this->model->ins_ts,
            'iconClass' => 'fa-gear bg-purple-light'
        ]);
    }

    public function getBody(): string
    {
        return $this->model->eventText;
    }
}