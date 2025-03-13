<?php

namespace App\Enum;

enum WeightStatus: string
{
    case W50 = 'W50';
    case W60 = 'W60';
    case W70 = 'W70';
    case W80 = 'W80';

    public function getWeight(): string {
        return $this->value;
    }
}