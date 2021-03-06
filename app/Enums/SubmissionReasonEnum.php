<?php

namespace App\Enums;

use App\Enums\Traits\EnumMethods;

enum SubmissionReasonEnum: string
{
    use EnumMethods;

    case idea = 'idea';
    case issue = 'issue';
    case book_problem = 'book_problem';
    case book_adding = 'book_adding';
    case other = 'other';
}
