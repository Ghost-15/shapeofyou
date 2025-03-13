<?php

namespace App\Enum;

enum RoleStatus: string
{
    case CLIENT = 'Client';
    case ADMIN = 'Admin';
    case MODERATOR = 'Moderator';

    public function getRole(): string {
        return $this->value;
    }
}