<?php

namespace App\Enum;

enum GenderStatus: string {
    case MALE = 'MALE';
    case FEMALE = 'FEMALE';

    public function getGender(): string {
        return $this->value;
    }
}