<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ProfileType extends Enum
{
    public const ADMIN =   'admin';
    public const ORGANIZATION =   'organization';
    public const VOLUNTEER = 'volunteer';
}
