<?php

namespace app\widgets\HistoryList\renders;

use app\models\History;
use yii\web\View;

class EventRendererFactory
{

    /**
     * @var View
     */
    private $view;
    /**
     * @var History
     */
    private $model;

    public function __construct(History $model, View $view)
    {
        $this->model = $model;
        $this->view = $view;
    }
    public function getRenderer(): HistoryEventRenderInterface
    {
        $className = 'app\widgets\HistoryList\renders\Event' . ucwords($this->model->object) . 'Renderer';

        if (!class_exists($className)) {
            return new BaseEventRenderer($this->model, $this->view);
            //or we can throw the error NotFoundEventRenderer);
        }

        return new $className($this->model, $this->view);
    }
}