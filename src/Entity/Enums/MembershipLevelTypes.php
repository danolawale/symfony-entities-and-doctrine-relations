<?php

namespace App\Entity\Enums;

enum MembershipLevelTypes: string
{
    case STANDARD = 'standard';
    case HYPE = 'hype';
    case SUPER = 'super';

    public function toString(): string
    {
        return match($this) {
            self::STANDARD => 'standard',
            self::HYPE => 'hype',
            self::SUPER => 'super'
        };
    }
}