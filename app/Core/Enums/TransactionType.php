<?php

namespace App\Core\Enums;

enum TransactionType: string
{
    case PAYMENT = 'payment';

    case AUTHORIZATION = 'authorization';

    case CAPTURE = 'capture';

    case REFUND = 'refund';

    case VOID = 'void';

    case CHARGEBACK = 'chargeback';

    case PAYOUT = 'payout';
}
