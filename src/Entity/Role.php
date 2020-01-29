<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

class Role {
    const Member = 0;
    const Manager = 1;
    const Admin = 2;
}