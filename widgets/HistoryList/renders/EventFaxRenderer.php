<?php

namespace app\widgets\HistoryList\renders;

use app\models\History;
use Yii;
use yii\web\View;
use yii\helpers\Html;

class EventFaxRenderer implements HistoryEventRenderInterface
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
        $fax = $this->model->fax;

        return $this->view->render('_item_common', [
            'user' => $this->model->user,
            'body' => $this->getBody() .
                ' - ' .
                (isset($fax->document) ? Html::a(
                    Yii::t('app', 'view document'),
                    $fax->document->getViewUrl(),
                    [
                        'target' => '_blank',
                        'data-pjax' => 0
                    ]
                ) : ''),
            'footer' => Yii::t('app', '{type} was sent to {group}', [
                'type' => $fax ? $fax->getTypeText() : 'Fax',
                'group' =>
                    isset($fax->creditorGroup) ?
                        Html::a($fax->creditorGroup->name, ['creditors/groups'], ['data-pjax' => 0]) : ''
            ]),
            'footerDatetime' => $this->model->ins_ts,
            'iconClass' => 'fa-fax bg-green'
        ]);
    }

    public function getBody(): string
    {
        return $this->model->eventText;
    }
}