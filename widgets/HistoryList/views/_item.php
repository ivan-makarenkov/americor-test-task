<?php

use app\models\search\HistorySearch;
use app\widgets\HistoryList\renders\EventRendererFactory;

/** @var $model HistorySearch */
$rendererFactory = new EventRendererFactory($model, $this);
echo $rendererFactory->getRenderer()->render();