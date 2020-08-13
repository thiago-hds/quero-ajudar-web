<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class LocationType extends Enum
{
    const ORGANIZATION_ADDRESS   = 0;
    const SPECIFIC_ADDRESS       = 1;
    const REMOTE                 = 2;
    const NEGOTIABLE             = 3;
}
