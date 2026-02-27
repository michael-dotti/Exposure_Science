<?php

namespace App\Enums;

enum EventType: string
{
    case TASK = 'task';
    case WARNING = 'warning';
    case NEWS = 'news';
    case MEETING = 'meeting';
}