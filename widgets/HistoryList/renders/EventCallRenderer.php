<?php

namespace app\widgets\HistoryList\renders;

use app\models\Call;
use app\models\Contact;
use app\models\History;
use Yii;
use yii\web\View;

class EventCallRenderer implements HistoryEventRenderInterface
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
        $call = $this->model->call;
        $answered = $call && $call->status == Call::STATUS_ANSWERED;

        return $this->view->render('_item_common', [
            'user' => $this->model->user,
            'content' => $call->comment ?? '',
            'body' => $this->getBody(),
            'footerDatetime' => $this->model->ins_ts,
            'footer' => isset($call->applicant) ? "Called <span>{$call->applicant->name}</span>" : null,
            'iconClass' => $answered ? 'md-phone bg-green' : 'md-phone-missed bg-red',
            'iconIncome' => $answered && $call->direction == Contact::DIRECTION_INCOMING
        ]);
    }

    public function getBody(): string
    {
        $call = $this->model->call;
        return ($call ? $call->totalStatusText . ($call->getTotalDisposition(false) ?
                " <span class='text-grey'>" . $call->getTotalDisposition(false) . "</span>" : "") : '<i>Deleted</i> ');
    }
}