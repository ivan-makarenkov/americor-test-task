<?php

namespace app\widgets\HistoryList\renders;

use app\models\History;
use app\models\Sms;
use Yii;
use yii\web\View;

class EventTaskRenderer implements HistoryEventRenderInterface
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
        $task = $this->model->task;

        return $this->view->render('_item_common', [
            'user' => $this->model->user,
            'body' => $this->getBody(),
            'iconClass' => 'fa-check-square bg-yellow',
            'footerDatetime' => $this->model->ins_ts,
            'footer' => isset($task->customerCreditor->name) ? "Creditor: " . $task->customerCreditor->name : ''
        ]);
    }

    public function getBody(): string
    {
        return $this->model->eventText . ": " . ($task->title ?? '');
    }
}