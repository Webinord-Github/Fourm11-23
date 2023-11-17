<?php

namespace App\Policies;
use App\Models\User;

use Illuminate\Auth\Access\HandlesAuthorization;

class IsSuperAdmin
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function SuperAdmin(User $user) {
        return $user->hasRole('Super Admin');
    }

    
}
