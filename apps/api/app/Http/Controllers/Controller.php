<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Spatie\Permission\Traits\HasRoles;

abstract class Controller
{
    use AuthorizesRequests,HasRoles;
}
