<?php

// app/Enums/StatusEvent.php

namespace App\Enums;

enum StatusEvent: string
{
    case Upcoming = 'upcoming';
    case Ongoing = 'ongoing';
    case Completed = 'completed';
}
