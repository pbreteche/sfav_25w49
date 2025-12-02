<?php

namespace App\Entity;

enum PostState: string
{
    case Draft = 'draft';
    case Published = 'published';
    case Archived = 'archived';
}
