<?php


namespace App\Enum;

enum MorphologyStatus: string
{
    case A = 'A';
    case H = 'H';
    case V = 'V';
    case X = 'X';

    public function getMorphology(): string {
        return $this->value;
    }
}
