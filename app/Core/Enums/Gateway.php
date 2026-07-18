<?php

namespace App\Core\Enums;

enum Gateway: string
{
    case SATIM = 'satim';

    case CIB = 'cib';

    case EDAHABIA = 'edahabia';

    case BARIDIMOB = 'baridimob';

    case STRIPE = 'stripe';

    case ADYEN = 'adyen';

    case WORLDPAY = 'worldpay';

    case CHECKOUT = 'checkout';
}
