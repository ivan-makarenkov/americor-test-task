<?php

namespace app\models\event;

interface HistoryEventInterface
{
    /**
     * @return array
     */
    public function getEventList(): array;
}