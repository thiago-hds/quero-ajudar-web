<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ApplicationStatusType extends Enum
{
    const ACTIVE    =   1;
    const CANCELLED_BY_VOLUNTEER =   2;
    const CANCELLED_BY_ORGANIZATION = 3;
}
