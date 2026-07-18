<?php

namespace App\Core\Enums;

enum PaymentStatus: string
{
    case PENDING = 'pending';

    case PROCESSING = 'processing';

    case AUTHORIZED = 'authorized';

    case REQUIRES_ACTION = 'requires_action';

    case SUCCEEDED = 'succeeded';

    case FAILED = 'failed';

    case CANCELED = 'canceled';

    case REFUNDED = 'refunded';

    case PARTIALLY_REFUNDED = 'partially_refunded';

    case EXPIRED = 'expired';
}
