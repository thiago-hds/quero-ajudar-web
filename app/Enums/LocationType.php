<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class LocationType extends Enum
{
    public const ORGANIZATION_ADDRESS   = 'organization_address';
    public const SPECIFIC_ADDRESS       = 'specific_address';
    public const REMOTE                 = 'remote';
    public const NEGOTIABLE             = 'negotiable';
}
