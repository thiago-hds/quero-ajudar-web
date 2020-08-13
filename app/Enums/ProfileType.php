<?php

namespace App\Enums;

use App\Organization;
use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ProfileType extends Enum
{
    const ADMIN =   0;
    const ORGANIZATION =   1;
    const VOLUNTEER = 2;
}
