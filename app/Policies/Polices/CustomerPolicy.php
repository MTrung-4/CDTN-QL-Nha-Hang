<?php

namespace App\Policies\Polices;

use App\Models\User;

class CustomerPolicy
{
    public function show(User $user)
    {
        return $user->role === 'admin' || $user->role === 'staff'; 
    }
}
