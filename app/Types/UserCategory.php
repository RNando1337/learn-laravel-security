<?php

namespace App\Types;

class UserCategory
{
    const PREMIUM = 'P';
    const FREE = "F";

    protected static $typeLabels = [
        self::PREMIUM => 'Premium',
        self::FREE => 'Free',
    ];
}