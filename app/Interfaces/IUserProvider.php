<?php

namespace App\Interfaces;

use App\Models\User;

interface IUserProvider
{
    public function getLoggedInUser(): ?User;
}
