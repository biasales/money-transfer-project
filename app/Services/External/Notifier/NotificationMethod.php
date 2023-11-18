<?php

namespace App\Services\External\Notifier;

enum NotificationMethod
{
    case EMAIL;
    case SMS;
}