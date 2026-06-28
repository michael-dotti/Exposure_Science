<?php

namespace App\Enums;

enum EventType: string
{
    case TASK = 'Task';
    case WARNING = 'Attenzione';
    case NEWS = 'Novità';
    case MEETING = 'Riunione';
}