<?php

namespace App\Enums;

use App\Traits\EnumCaseHelper;
use App\Traits\EnumHelper;

enum UserStatus: string
{
    use EnumHelper;
    use EnumCaseHelper;

    case ACTIVE = 'active';

    case BLOCKED = 'blocked';

    case INACTIVE = 'inactive';
}
