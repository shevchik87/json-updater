<?php
declare(strict_types = 1);

namespace App\Component\User;

use Ramsey\Uuid\Uuid;

class Generator
{
    public function getNewToken()
    {
        return md5(Uuid::uuid1()->toString());
    }
}