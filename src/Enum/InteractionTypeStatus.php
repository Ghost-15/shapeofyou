<?php

namespace App\Enum;

enum InteractionTypeStatus: string
{
    case LIKE = 'LIKE';
    case COMMENTARY = 'COMMENTARY';
    case SHARE = 'SHARE';

    public function getInteractionType() : string
    {
        return $this->value;
    }
}