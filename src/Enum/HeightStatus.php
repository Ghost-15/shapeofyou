<?php

namespace App\Enum;

enum HeightStatus: string
{
    case H150 = 'H150';
    case H160 = 'H160';
    case H170 = 'H170';
    case H180 = 'H180';

    public function getHeight(): string {
        return $this->value;
    }
}