<?php

namespace app\widgets\HistoryList\renders;

use app\models\Contact;
use app\models\History;
use app\models\Sms;
use Yii;
use yii\web\View;

class EventSmsRenderer implements HistoryEventRenderInterface
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
            'footer' => $this->model->sms->direction == Contact::DIRECTION_INCOMING ?
                Yii::t('app', 'Incoming message from {number}', [
                    'number' => $model->sms->phone_from ?? ''
                ]) : Yii::t('app', 'Sent message to {number}', [
                    'number' => $model->sms->phone_to ?? ''
                ]),
            'iconIncome' => $this->model->sms->direction == Contact::DIRECTION_INCOMING,
            'footerDatetime' => $this->model->ins_ts,
            'iconClass' => 'icon-sms bg-dark-blue'
        ]);
    }

    public function getBody(): string
    {
        return $this->model->sms->message ?: '';
    }
}