<?php

namespace app\widgets\HistoryList\renders;

use app\models\Customer;
use app\models\History;
use Yii;
use yii\web\View;

class EventCustomerRenderer implements HistoryEventRenderInterface
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
        if (strpos($this->model->event, 'type')) {
            return $this->view->render('_item_statuses_change', [
                'model' => $this->model,
                'oldValue' => Customer::getTypeText($this->model->getDetailOldValue('type')),
                'newValue' => Customer::getTypeText($this->model->getDetailNewValue('type'))
            ]);
        }

        return $this->view->render('_item_statuses_change', [
            'model' => $this->model,
            'oldValue' => Customer::getQualityText($this->model->getDetailOldValue('quality')),
            'newValue' => Customer::getQualityText($this->model->getDetailNewValue('quality')),
        ]);
    }

    public function getBody(): string
    {
        return $this->model->sms->message ?: '';
    }
}