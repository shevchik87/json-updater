<?php

namespace App\Component\Helper;

use Ramsey\Uuid\Uuid;

class GeneratorHelper
{
    public function generateToken()
    {
        return md5(Uuid::uuid1()->toString());
    }

    public function generateUUID()
    {
        return Uuid::uuid1()->toString();

    }
}
